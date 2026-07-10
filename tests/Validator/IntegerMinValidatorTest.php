<?php

declare(strict_types=1);

namespace Tests\Validator;

use Maxs94\Internetmarke\Validator\IntegerMinValidator;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class IntegerMinValidatorTest extends TestCase
{
    public function testPassesNullWithoutException(): void
    {
        IntegerMinValidator::validate(null, 1, 'field');
        $this->addToAssertionCount(1);
    }

    public function testPassesValueAtMinimum(): void
    {
        IntegerMinValidator::validate(1, 1, 'amount');
        $this->addToAssertionCount(1);
    }

    public function testPassesValueAboveMinimum(): void
    {
        IntegerMinValidator::validate(100, 1, 'amount');
        $this->addToAssertionCount(1);
    }

    public function testThrowsWhenBelowMinimum(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        IntegerMinValidator::validate(0, 1, 'amount');
    }

    public function testThrowsWhenNegative(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        IntegerMinValidator::validate(-5, 1, 'productCode');
    }
}
