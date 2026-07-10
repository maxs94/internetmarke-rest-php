<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Validator;

final class IntegerMinValidator
{
    public static function validate(?int $value, int $min, string $field): void
    {
        if ($value === null) {
            return;
        }

        if ($value < $min) {
            throw new \InvalidArgumentException(sprintf(
                '%s must be at least %d, got %d.',
                $field, $min, $value
            ));
        }
    }
}
