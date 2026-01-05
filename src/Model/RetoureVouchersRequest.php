<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class RetoureVouchersRequest
{
    private ?ShoppingCart $shoppingCart = null;

    public function setShoppingCart(?ShoppingCart $cart): self
    {
        $this->shoppingCart = $cart;

        return $this;
    }

    public function getShoppingCart(): ?ShoppingCart
    {
        return $this->shoppingCart;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        if (!empty($data['shoppingCart'])) {
            $self->setShoppingCart(ShoppingCart::fromArray((array) $data['shoppingCart']));
        }

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'shoppingCart' => $this->shoppingCart?->toArray(),
        ];
    }
}
