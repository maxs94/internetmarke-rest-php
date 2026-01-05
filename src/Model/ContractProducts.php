<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class ContractProducts
{
    /** @var ContractProduct[] */
    private array $products = [];

    /**
     * @param ContractProduct[] $products
     */
    public function setProducts(array $products): self
    {
        $this->products = $products;

        return $this;
    }

    /**
     * @return ContractProduct[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $items = $data['products'] ?? [];
        if (is_array($items)) {
            $list = [];
            foreach ($items as $it) {
                $list[] = ContractProduct::fromArray((array) $it);
            }
            $self->setProducts($list);
        }

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'products' => array_map(fn (ContractProduct $p) => $p->toArray(), $this->products),
        ];
    }
}
