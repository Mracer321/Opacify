<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    /** Posts shown per page on the public listing. */
    private const PER_PAGE = 9;

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $posts = BlogPost::query()
            ->publishable()
            ->when($search !== '', fn (Builder $query) => $this->applySearch($query, $search))
            ->latest('published_at')
            ->paginate(self::PER_PAGE)
            ->withQueryString(); // Preserve ?q= across pagination links.

        return view('pages.blog.index', [
            'posts' => $posts,
            'search' => $search,
        ]);
    }

    public function show(string $slug): View
    {
        $post = BlogPost::query()
            ->publishable()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('pages.blog.show', [
            'post' => $post,
            'relatedPosts' => $this->relatedPosts($post),
            'isPreview' => false,
        ]);
    }

    /**
     * Case-insensitive search across the fields a reader would expect: title,
     * excerpt, category, tags and the text of the content blocks. Uses bound
     * LIKE parameters (no raw interpolation) so it is injection-safe.
     */
    private function applySearch(Builder $query, string $search): Builder
    {
        $like = '%'.str_replace(['%', '_'], ['\%', '\_'], $search).'%';

        return $query->where(function (Builder $q) use ($like): void {
            $q->where('title', 'like', $like)
                ->orWhere('excerpt', 'like', $like)
                ->orWhere('category', 'like', $like)
                ->orWhere('tags', 'like', $like)
                ->orWhere('content_blocks', 'like', $like);
        });
    }

    /**
     * Up to 3 other publishable posts, preferring the same category.
     *
     * @return \Illuminate\Support\Collection<int, BlogPost>
     */
    private function relatedPosts(BlogPost $post)
    {
        return BlogPost::query()
            ->publishable()
            ->whereKeyNot($post->getKey())
            ->orderByRaw('CASE WHEN category = ? THEN 0 ELSE 1 END', [$post->category])
            ->latest('published_at')
            ->take(3)
            ->get();
    }
}
