<?php

namespace App\Support;

final readonly class ImageDataUrl
{
    public const MAX_BYTES = 2_097_152;

    public const MAX_DATA_URL_CHARACTERS = 2_796_227;

    private function __construct(
        public string $mimeType,
        public string $content,
        public string $contentHash,
    ) {}

    /**
     * @param  list<string>  $allowedMimeTypes
     */
    public static function parse(string $dataUrl, array $allowedMimeTypes): ?self
    {
        if (! preg_match('~\Adata:(image/[a-z0-9.+-]+);base64,([A-Za-z0-9+/]*={0,2})\z~i', $dataUrl, $matches)) {
            return null;
        }

        $mimeType = strtolower($matches[1]);

        if (! in_array($mimeType, $allowedMimeTypes, true)) {
            return null;
        }

        $content = base64_decode($matches[2], true);

        if (! is_string($content) || $content === '' || strlen($content) > self::MAX_BYTES) {
            return null;
        }

        $image = @getimagesizefromstring($content);

        if (! is_array($image) || strtolower((string) ($image['mime'] ?? '')) !== $mimeType) {
            return null;
        }

        $width = (int) ($image[0] ?? 0);
        $height = (int) ($image[1] ?? 0);

        if ($width < 1 || $height < 1 || $width > 8192 || $height > 8192 || $width * $height > 20_000_000) {
            return null;
        }

        return new self($mimeType, $content, hash('sha256', $content));
    }
}
