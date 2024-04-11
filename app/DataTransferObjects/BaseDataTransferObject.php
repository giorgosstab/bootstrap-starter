<?php

namespace App\DataTransferObjects;

abstract class BaseDataTransferObject
{
    public function toArray(): array
    {
        $properties = get_object_vars($this);

        return array_map(function ($value) {
            return $value;
        }, $properties);
    }
}