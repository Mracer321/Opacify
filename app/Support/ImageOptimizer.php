<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Optimizes and stores uploaded blog images.
 *
 * When the GD extension is available (production), images wider than
 * self::MAX_WIDTH are downscaled (aspect ratio preserved) and re-encoded to
 * WebP where supported — keeping files web-friendly and small. When GD is not
 * available, the original file is stored unchanged so uploads never fail. This
 * makes the feature production-safe across environments.
 */
class ImageOptimizer
{
    /** Sensible maximum width for in-article/featured blog images. */
    public const MAX_WIDTH = 1600;

    /** WebP/JPEG quality (0-100). */
    public const QUALITY = 82;

    /**
     * Store an uploaded image under $dir on the public disk, optimizing it when
     * possible. $baseName is a slug-safe filename stem (without extension).
     *
     * @return string Stored path relative to the public disk.
     */
    public function store(UploadedFile $file, string $dir, string $baseName): string
    {
        $dir = trim($dir, '/');
        $baseName = $this->safeBaseName($baseName);

        if (! $this->canOptimize()) {
            $ext = Str::lower($file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'bin');

            return $file->storeAs($dir, $this->uniqueName($dir, $baseName, $ext), 'public');
        }

        [$binary, $ext] = $this->process($file);

        if ($binary === null) {
            $ext = Str::lower($file->getClientOriginalExtension() ?: 'bin');

            return $file->storeAs($dir, $this->uniqueName($dir, $baseName, $ext), 'public');
        }

        $path = $dir.'/'.$this->uniqueName($dir, $baseName, $ext);
        Storage::disk('public')->put($path, $binary);

        return $path;
    }

    public function canOptimize(): bool
    {
        return extension_loaded('gd') && function_exists('imagecreatetruecolor');
    }

    /**
     * @return array{0: ?string, 1: string} [binary|null, extension]
     */
    private function process(UploadedFile $file): array
    {
        $info = @getimagesize($file->getRealPath());

        if ($info === false) {
            return [null, 'bin'];
        }

        [$width, $height] = $info;
        $source = $this->createFromFile($file->getRealPath(), $info[2]);

        if ($source === null) {
            return [null, 'bin'];
        }

        // Downscale only (never upscale) while preserving aspect ratio.
        if ($width > self::MAX_WIDTH) {
            $newWidth = self::MAX_WIDTH;
            $newHeight = (int) round($height * (self::MAX_WIDTH / $width));
            $resized = imagecreatetruecolor($newWidth, $newHeight);
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($source);
            $source = $resized;
        }

        ob_start();
        if (function_exists('imagewebp')) {
            imagewebp($source, null, self::QUALITY);
            $ext = 'webp';
        } else {
            imagejpeg($source, null, self::QUALITY);
            $ext = 'jpg';
        }
        $binary = ob_get_clean();
        imagedestroy($source);

        return [$binary ?: null, $ext];
    }

    private function createFromFile(string $path, int $type): ?\GdImage
    {
        $image = match ($type) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($path),
            IMAGETYPE_PNG => @imagecreatefrompng($path),
            IMAGETYPE_WEBP => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : false,
            IMAGETYPE_GIF => @imagecreatefromgif($path),
            default => false,
        };

        return $image ?: null;
    }

    private function safeBaseName(string $baseName): string
    {
        $slug = Str::slug($baseName);

        return $slug !== '' ? Str::limit($slug, 80, '') : 'image';
    }

    /**
     * Avoid clobbering an existing file with the same derived name.
     */
    private function uniqueName(string $dir, string $baseName, string $ext): string
    {
        $name = $baseName.'.'.$ext;
        $disk = Storage::disk('public');

        $i = 1;
        while ($disk->exists($dir.'/'.$name)) {
            $name = $baseName.'-'.$i.'.'.$ext;
            $i++;
        }

        return $name;
    }
}
