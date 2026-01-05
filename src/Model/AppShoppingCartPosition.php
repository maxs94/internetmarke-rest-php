<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class AppShoppingCartPosition
{
    private ?int $productCode = null;
    private ?int $imageID = null;
    private ?AddressBinding $address = null;
    private ?string $voucherLayout = null;
    private ?string $positionType = null;

    public function setProductCode(?int $code): self
    {
        $this->productCode = $code;

        return $this;
    }

    public function getProductCode(): ?int
    {
        return $this->productCode;
    }

    public function setImageID(?int $id): self
    {
        $this->imageID = $id;

        return $this;
    }

    public function getImageID(): ?int
    {
        return $this->imageID;
    }

    public function setAddress(?AddressBinding $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getAddress(): ?AddressBinding
    {
        return $this->address;
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

    public function setPositionType(?string $type): self
    {
        $this->positionType = $type;

        return $this;
    }

    public function getPositionType(): ?string
    {
        return $this->positionType;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->setProductCode(isset($data['productCode']) ? (int) $data['productCode'] : (isset($data['product_code']) ? (int) $data['product_code'] : null));
        $self->setImageID(isset($data['imageID']) ? (int) $data['imageID'] : (isset($data['image_id']) ? (int) $data['image_id'] : null));
        if (!empty($data['address'])) {
            $self->setAddress(AddressBinding::fromArray((array) $data['address']));
        }
        $self->setVoucherLayout($data['voucherLayout'] ?? $data['voucher_layout'] ?? null);
        $self->setPositionType($data['positionType'] ?? $data['position_type'] ?? null);

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'productCode' => $this->productCode,
            'imageID' => $this->imageID,
            'address' => $this->address?->toArray(),
            'voucherLayout' => $this->voucherLayout,
            'positionType' => $this->positionType,
        ];
    }
}
