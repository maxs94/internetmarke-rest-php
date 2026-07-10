<?php

declare(strict_types=1);

namespace Tests\Validator;

use Maxs94\Internetmarke\Validator\EnumValidator;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class EnumValidatorTest extends TestCase
{
    public function testPassesNullWithoutException(): void
    {
        EnumValidator::validate(null, ['A', 'B'], 'field');
        $this->addToAssertionCount(1);
    }

    public function testPassesAllowedValue(): void
    {
        EnumValidator::validate('DPI300', ['DPI300', 'DPI203'], 'dpi');
        $this->addToAssertionCount(1);
    }

    public function testThrowsWhenValueNotInEnum(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        EnumValidator::validate('DPI600', ['DPI300', 'DPI203'], 'dpi');
    }

    public function testThrowsOnEmptyStringNotInEnum(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        EnumValidator::validate('', ['ADDRESS_ZONE', 'FRANKING_ZONE'], 'voucherLayout');
    }

    public function testIsCaseSensitive(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        EnumValidator::validate('dpi300', ['DPI300', 'DPI203'], 'dpi');
    }
}
