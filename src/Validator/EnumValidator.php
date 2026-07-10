<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Validator;

final class EnumValidator
{
    /**
     * @param string[] $allowed
     */
    public static function validate(?string $value, array $allowed, string $field): void
    {
        if ($value === null) {
            return;
        }

        if (!in_array($value, $allowed, true)) {
            throw new \InvalidArgumentException(sprintf(
                '%s must be one of [%s], got "%s".',
                $field, implode(', ', $allowed), $value
            ));
        }
    }
}
