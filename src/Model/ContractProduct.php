<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class ContractProduct
{
    private ?int $productCode = null;
    private ?int $price = null;

    public function setProductCode(?int $code): self
    {
        $this->productCode = $code;

        return $this;
    }

    public function getProductCode(): ?int
    {
        return $this->productCode;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->setProductCode(isset($data['productCode']) ? (int) $data['productCode'] : (isset($data['product_code']) ? (int) $data['product_code'] : null));
        $self->setPrice(isset($data['price']) ? (int) $data['price'] : null);

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'productCode' => $this->productCode,
            'price' => $this->price,
        ];
    }
}
