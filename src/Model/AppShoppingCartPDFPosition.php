<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class AppShoppingCartPDFPosition
{
    private ?VoucherPosition $position = null;
    private ?string $positionType = null;
    private ?int $productCode = null;
    private ?string $voucherLayout = null;

    public function setPosition(VoucherPosition $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getPosition(): ?VoucherPosition
    {
        return $this->position;
    }

    public function setPositionType(?string $type): self
    {
        $this->positionType = $type;

        return $this;
    }

    public function getPositionType(): ?string
    {
        return $this->positionType;
    }

    public function setProductCode(?int $code): self
    {
        $this->productCode = $code;

        return $this;
    }

    public function getProductCode(): ?int
    {
        return $this->productCode;
    }

    public function setVoucherLayout(?string $layout): self
    {
        $this->voucherLayout = $layout;

        return $this;
    }

    public function getVoucherLayout(): ?string
    {
        return $this->voucherLayout;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        if (!empty($data['position'])) {
            $self->setPosition(VoucherPosition::fromArray((array) $data['position']));
        }
        $self->setPositionType($data['positionType'] ?? $data['position_type'] ?? null);
        $self->setProductCode(isset($data['productCode']) ? (int) $data['productCode'] : (isset($data['product_code']) ? (int) $data['product_code'] : null));
        $self->setVoucherLayout($data['voucherLayout'] ?? $data['voucher_layout'] ?? null);

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'position' => $this->position?->toArray(),
            'positionType' => $this->positionType,
            'productCode' => $this->productCode,
            'voucherLayout' => $this->voucherLayout,
        ];
    }
}
