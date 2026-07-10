<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

use Maxs94\Internetmarke\Validator\StringLengthValidator;

final class ShoppingCart
{
    private ?string $shopOrderId = null;

    /** @var Voucher[] */
    private array $voucherList = [];

    public function setShopOrderId(?string $id): self
    {
        StringLengthValidator::validate($id, 1, 18, 'shopOrderId');
        $this->shopOrderId = $id;

        return $this;
    }

    public function getShopOrderId(): ?string
    {
        return $this->shopOrderId;
    }

    /**
     * @return Voucher[]
     */
    public function getVoucherList(): array
    {
        return $this->voucherList;
    }

    /**
     * @param Voucher[] $voucherList
     */
    public function setVoucherList(array $voucherList): self
    {
        if (count($voucherList) < 1) {
            throw new \InvalidArgumentException('voucherList must contain at least 1 item.');
        }

        $this->voucherList = $voucherList;

        return $this;
    }

    public function addVoucher(Voucher $voucher): self
    {
        $this->voucherList[] = $voucher;

        return $this;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->setShopOrderId($data['shopOrderId'] ?? $data['shop_order_id'] ?? null);
        $list = $data['voucherList'] ?? $data['voucher_list'] ?? [];
        if (is_array($list)) {
            foreach ($list as $item) {
                $self->addVoucher(Voucher::fromArray((array) $item));
            }
        }

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'shopOrderId' => $this->shopOrderId,
            'voucherList' => array_map(fn (Voucher $v) => $v->toArray(), $this->voucherList),
        ];
    }
}
