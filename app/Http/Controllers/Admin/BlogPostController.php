<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogPostRequest;
use App\Models\BlogPost;
use App\Support\ImageOptimizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogPostController extends Controller
{
    /**
     * Managed media lives under this directory on the public disk. Only files
     * under this prefix are ever deleted, so unrelated assets are safe.
     */
    private const MEDIA_DIR = 'blog';

    private const IMAGE_FIELDS = ['featured_image', 'og_image'];

    public function __construct(private readonly ImageOptimizer $images)
    {
    }

    public function index(): View
    {
        return view('admin.blog.index', [
            'posts' => BlogPost::query()->latest('updated_at')->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.blog.create', [
            'post' => new BlogPost(),
        ]);
    }

    public function store(BlogPostRequest $request): RedirectResponse
    {
        $data = $this->preparePayload($request);

        foreach (self::IMAGE_FIELDS as $field) {
            $data[$field] = $request->hasFile($field)
                ? $this->storeImage($request->file($field), $data, $field)
                : null;
        }

        $post = BlogPost::create($data);

        return redirect()
            ->route('admin.blog.edit', $post)
            ->with('status', "Post \"{$post->title}\" created.")
            ->with('quality_warnings', $request->qualityWarnings());
    }

    public function edit(BlogPost $blogPost): View
    {
        return view('admin.blog.edit', [
            'post' => $blogPost,
        ]);
    }

    public function update(BlogPostRequest $request, BlogPost $blogPost): RedirectResponse
    {
        $data = $this->preparePayload($request, $blogPost);

        $replaced = [];
        foreach (self::IMAGE_FIELDS as $field) {
            if ($request->hasFile($field)) {
                $replaced[$field] = $blogPost->{$field};
                $data[$field] = $this->storeImage($request->file($field), $data, $field);
            } else {
                unset($data[$field]); // Keep the current image when none uploaded.
            }
        }

        $blogPost->update($data);

        foreach ($replaced as $oldPath) {
            $this->deleteManagedFile($oldPath);
        }

        return redirect()
            ->route('admin.blog.edit', $blogPost)
            ->with('status', "Post \"{$blogPost->title}\" updated.")
            ->with('quality_warnings', $request->qualityWarnings());
    }

    public function destroy(BlogPost $blogPost): RedirectResponse
    {
        foreach (self::IMAGE_FIELDS as $field) {
            $this->deleteManagedFile($blogPost->{$field});
        }

        $blogPost->delete();

        return redirect()
            ->route('admin.blog.index')
            ->with('status', 'Post deleted.');
    }

    /**
     * Admin-only preview using the real public post template. Draft and
     * scheduled posts are viewable here (behind auth) but rendered noindex.
     */
    public function preview(BlogPost $blogPost): View
    {
        return view('pages.blog.show', [
            'post' => $blogPost,
            'relatedPosts' => collect(),
            'isPreview' => true,
        ]);
    }

    /**
     * Upload an in-content image for the block editor. Returns the stored path
     * plus derived metadata defaults (title/alt/description/caption) built from
     * the post title/topic when the admin hasn't typed their own. The admin can
     * still edit every value in the block; provided values are never overwritten.
     */
    public function uploadImage(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'topic' => ['nullable', 'string', 'max:200'],
        ]);

        $topic = trim((string) ($validated['topic'] ?? '')) ?: 'blog image';
        $base = Str::slug($topic.'-image') ?: 'blog-image';
        $path = $this->images->store($request->file('image'), self::MEDIA_DIR, $base);

        $label = Str::of($topic)->trim()->title()->value();

        return response()->json([
            'path' => $path,
            'url' => Storage::disk('public')->url($path),
            'defaults' => [
                'slug' => Str::slug($topic),
                'title' => $label,
                'alt' => $label,
                'caption' => '',
                'description' => $label,
            ],
        ]);
    }

    /**
     * Publish now (or unpublish back to draft) from the listing.
     */
    public function togglePublish(Request $request, BlogPost $blogPost): RedirectResponse
    {
        if ($blogPost->status === BlogPost::STATUS_PUBLISHED) {
            $blogPost->update(['status' => BlogPost::STATUS_DRAFT]);
            $message = 'Post unpublished.';
        } else {
            $blogPost->update([
                'status' => BlogPost::STATUS_PUBLISHED,
                'published_at' => $blogPost->published_at ?? now(),
            ]);
            $message = 'Post published.';
        }

        return back()->with('status', $message);
    }

    /**
     * Shape validated data + enforce publishing invariants.
     */
    private function preparePayload(BlogPostRequest $request, ?BlogPost $existing = null): array
    {
        $data = $request->validated();

        // Derive a publish time when publishing/scheduling without an explicit one.
        if ($data['status'] === BlogPost::STATUS_PUBLISHED) {
            $data['published_at'] = $data['published_at'] ?: ($existing?->published_at ?? now());
        } elseif ($data['status'] === BlogPost::STATUS_DRAFT) {
            // Drafts keep any chosen date but are never publicly visible.
        }

        // Image blocks are uploaded via the async endpoint and arrive as stored
        // paths inside content_blocks; nothing else to transform here.
        return $data;
    }

    /**
     * Store an image, deriving sensible metadata defaults from the post title
     * when the admin left them blank. Never overwrites provided values.
     */
    private function storeImage($file, array $data, string $field): string
    {
        $base = Str::slug(($data['slug'] ?? $data['title'] ?? 'blog').'-'.Str::of($field)->beforeLast('_image'));

        return $this->images->store($file, self::MEDIA_DIR, $base ?: 'blog-image');
    }

    private function deleteManagedFile(?string $path): void
    {
        if (is_string($path) && $path !== '' && str_starts_with($path, self::MEDIA_DIR.'/')) {
            Storage::disk('public')->delete($path);
        }
    }
}
