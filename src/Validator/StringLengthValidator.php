<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Validator;

final class StringLengthValidator
{
    public static function validate(?string $value, int $min, int $max, string $field): void
    {
        if ($value === null) {
            return;
        }

        $len = mb_strlen($value);

        if ($len < $min || $len > $max) {
            throw new \InvalidArgumentException(sprintf(
                '%s must be between %d and %d characters, got %d.',
                $field, $min, $max, $len
            ));
        }
    }
}
