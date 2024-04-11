<?php

namespace App\Enum;

enum EnumStatus: string
{
    use EnumToArray;

    case ENABLED = 'enabled';

    case DISABLED = 'disabled';

    public function is(string $value): bool
    {
        return $this == self::tryFrom($value);
    }

    public static function resolve(string|int $inputValue): ?self
    {
        $mapping = [
            '1' => self::ENABLED,
            '0' => self::DISABLED
        ];

        // Check if the input value exists in the mapping
        return $mapping[$inputValue] ?? self::from($inputValue);
    }
}
