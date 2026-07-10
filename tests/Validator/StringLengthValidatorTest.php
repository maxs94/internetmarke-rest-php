<?php

declare(strict_types=1);

namespace Tests\Validator;

use Maxs94\Internetmarke\Validator\StringLengthValidator;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class StringLengthValidatorTest extends TestCase
{
    public function testPassesNullWithoutException(): void
    {
        StringLengthValidator::validate(null, 1, 50, 'field');
        $this->addToAssertionCount(1);
    }

    public function testPassesValueWithinRange(): void
    {
        StringLengthValidator::validate('hello', 1, 50, 'field');
        $this->addToAssertionCount(1);
    }

    public function testPassesExactMinLength(): void
    {
        StringLengthValidator::validate('A', 1, 5, 'field');
        $this->addToAssertionCount(1);
    }

    public function testPassesExactMaxLength(): void
    {
        StringLengthValidator::validate('12345', 5, 5, 'field');
        $this->addToAssertionCount(1);
    }

    public function testThrowsWhenTooShort(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        StringLengthValidator::validate('', 1, 50, 'name');
    }

    public function testThrowsWhenTooLong(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        StringLengthValidator::validate(str_repeat('x', 51), 1, 50, 'name');
    }

    public function testThrowsWhenExactLengthRequired(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        StringLengthValidator::validate('1234', 5, 5, 'postalCode');
    }

    public function testPassesZeroMinWithEmptyString(): void
    {
        StringLengthValidator::validate('', 0, 40, 'additionalName');
        $this->addToAssertionCount(1);
    }
}
