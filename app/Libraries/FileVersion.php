<?php

namespace App\Libraries;

class FileVersion
{
    public static function get($filePath)
    {
        //get an absolute file path
        $fileAbsPath = @$_SERVER['DOCUMENT_ROOT'] . (config('app.env') === 'local' ? '/' : '/' . env('APP_SUB_FOLDER', '/') . '/public/');

        //add datetime parameter
        if (file_exists($fileAbsPath)) {
            $filePath .= ((strpos($filePath, '?')) ? '&' : '?') . 'v=' . filemtime($fileAbsPath);
        }

        return $filePath;
    }
}