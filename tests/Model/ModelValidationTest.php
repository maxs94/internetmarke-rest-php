<?php

declare(strict_types=1);

namespace Tests\Model;

use Maxs94\Internetmarke\Model\Address;
use Maxs94\Internetmarke\Model\ShoppingCart;
use Maxs94\Internetmarke\Model\ShoppingCartPDFRequest;
use Maxs94\Internetmarke\Model\ShoppingCartPNGRequest;
use Maxs94\Internetmarke\Model\ShoppingCartPosition;
use Maxs94\Internetmarke\Model\VoucherPosition;
use Maxs94\Internetmarke\Model\Voucher;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class ModelValidationTest extends TestCase
{
    public function testAddressNameTooLong(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new Address())->setName(str_repeat('x', 51));
    }

    public function testAddressNameEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new Address())->setName('');
    }

    public function testAddressPostalCodeWrongLength(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new Address())->setPostalCode('1234');
    }

    public function testAddressPostalCodeValid(): void
    {
        $a = (new Address())->setPostalCode('10115');
        $this->assertSame('10115', $a->getPostalCode());
    }

    public function testAddressCountryWrongLength(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new Address())->setCountry('DE');
    }

    public function testAddressCountryValid(): void
    {
        $a = (new Address())->setCountry('DEU');
        $this->assertSame('DEU', $a->getCountry());
    }

    public function testAddressAdditionalNameNullSkipsValidation(): void
    {
        $a = (new Address())->setAdditionalName(null);
        $this->assertNull($a->getAdditionalName());
    }

    public function testAddressAdditionalNameTooLong(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new Address())->setAdditionalName(str_repeat('x', 41));
    }

    public function testAddressCityTooLong(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new Address())->setCity(str_repeat('x', 41));
    }

    public function testShoppingCartShopOrderIdTooLong(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new ShoppingCart())->setShopOrderId(str_repeat('x', 19));
    }

    public function testShoppingCartShopOrderIdNullIsAllowed(): void
    {
        $c = (new ShoppingCart())->setShopOrderId(null);
        $this->assertNull($c->getShopOrderId());
    }

    public function testShoppingCartVoucherListEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new ShoppingCart())->setVoucherList([]);
    }

    public function testShoppingCartVoucherListValid(): void
    {
        $v = Voucher::fromArray(['voucherId' => 'V1']);
        $c = (new ShoppingCart())->setVoucherList([$v]);
        $this->assertCount(1, $c->getVoucherList());
    }

    public function testShoppingCartPositionProductCodeZero(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new ShoppingCartPosition())->setProductCode(0);
    }

    public function testShoppingCartPositionVoucherLayoutInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new ShoppingCartPosition())->setVoucherLayout('INVALID');
    }

    public function testShoppingCartPositionVoucherLayoutValid(): void
    {
        $p = (new ShoppingCartPosition())->setVoucherLayout(ShoppingCartPosition::VOUCHER_LAYOUT_FRANKING_ZONE);
        $this->assertSame('FRANKING_ZONE', $p->getVoucherLayout());
    }

    public function testPNGRequestDpiInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new ShoppingCartPNGRequest())->setDpi('DPI600');
    }

    public function testPNGRequestCreateShippingListInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new ShoppingCartPNGRequest())->setCreateShippingList('3');
    }

    public function testPDFRequestPageFormatIdZero(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new ShoppingCartPDFRequest())->setPageFormatId(0);
    }

    public function testPDFRequestDpiInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new ShoppingCartPDFRequest())->setDpi('DPI600');
    }

    public function testVoucherPositionLabelXZero(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new VoucherPosition())->setLabelX(0);
    }

    public function testVoucherPositionLabelYNullIsAllowed(): void
    {
        $v = (new VoucherPosition())->setLabelY(null);
        $this->assertNull($v->getLabelY());
    }

    public function testVoucherPositionPageBelowMin(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new VoucherPosition())->setPage(0);
    }
}
