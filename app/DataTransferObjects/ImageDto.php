<?php

namespace App\DataTransferObjects;

class ImageDto extends BaseDataTransferObject
{
    /**
     * @param int $id
     * @param string $alt
     * @param string|null $title
     * @param int $width
     * @param int $height
     * @param string $source
     * @param string $original
     */
    public function __construct(
        readonly public int $id,
        readonly public string $alt,
        readonly public ?string $title,
        readonly public int $width,
        readonly public int $height,
        readonly public string  $source,
        readonly public string  $original,
    )
    {
    }

    /**
     * @param array $data
     * @return object
     */
    public static function fromJson(array $data): object
    {
        return (object) array_map(
            fn(mixed $item) => new self(
                id: $item->target_id,
                alt: $item->alt,
                title: $item->title ?? null,
                width: $item->width,
                height: $item->height,
                source: $item->url,
                original: $item->url,
            ),
            $data
        );
    }
}