<?php

namespace App\Libraries;

class HtmlPicture
{
    /**
     * @var array image types to be collected and rendered into picture tag
     */
    public static $sourceTypes;

    /**
     * @var array default image types
     */
    public static $defaultSourceTypes = ['webp', 'jpg', 'jpeg', 'png', 'svg'];

    /**
     * set image types
     * @param $sourceTypes
     */
    public static function setSourceTypes($sourceTypes): void
    {
        if ($sourceTypes) {
            self::$sourceTypes = $sourceTypes;
        } elseif (!self::$sourceTypes) {
            self::$sourceTypes = self::$defaultSourceTypes;
        }
    }

    /**
     * form a picture element
     * @param string $src
     * @param false|mixed $attributes
     * @param mixed $sourceTypes
     * @return string
     */
    public static function get(string $src, $attributes = false, $sourceTypes = false): string
    {
        $documentRoot = @$_SERVER['DOCUMENT_ROOT'] . (config('app.env') === 'local' ? '/' : '/' . env('APP_SUB_FOLDER', '/') . '/public/');

        if (!@file_exists($documentRoot . $src)) {
            return '';
        }

        self::setSourceTypes($sourceTypes);

        $srcParts = pathinfo($src);

        $attributesString = '';

        if ($attributes && is_array($attributes)) {
            foreach ($attributes as $name => $value) {
                $attributesString .= ' ' . $name . '="' . $value . '"';
            }
        }

        $html = '<picture>';
        foreach (self::$sourceTypes as $type) {
            $sourceSrc = str_replace('.' . $srcParts['extension'], '.' . $type, $src);

            if (file_exists($documentRoot . $sourceSrc)) {
                $html .= '<source srcset = "' . FileVersion::get($sourceSrc) . '" type = "image/' . $type . '">';
            }
        }

        $html .= '<img src="' . FileVersion::get($src) . '" ' . $attributesString . '>' . '</picture>';

        return $html;
    }
}