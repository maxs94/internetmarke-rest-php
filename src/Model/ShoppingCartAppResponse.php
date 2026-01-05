<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class CheckoutShoppingCartAppResponse
{
    private ?string $link = null;
    private ?string $manifestLink = null;
    private ?ShoppingCart $shoppingCart = null;
    private ?int $walletBallance = null;
    private ?string $type = null;

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setManifestLink(?string $link): self
    {
        $this->manifestLink = $link;

        return $this;
    }

    public function getManifestLink(): ?string
    {
        return $this->manifestLink;
    }

    public function setShoppingCart(?ShoppingCart $cart): self
    {
        $this->shoppingCart = $cart;

        return $this;
    }

    public function getShoppingCart(): ?ShoppingCart
    {
        return $this->shoppingCart;
    }

    public function setWalletBallance(?int $balance): self
    {
        $this->walletBallance = $balance;

        return $this;
    }

    public function getWalletBallance(): ?int
    {
        return $this->walletBallance;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->setLink((string) ($data['link'] ?? ''));
        $self->setManifestLink($data['manifestLink'] ?? $data['manifest_link'] ?? null);
        if (!empty($data['shoppingCart'])) {
            $self->setShoppingCart(ShoppingCart::fromArray((array) $data['shoppingCart']));
        }
        $self->setWalletBallance(isset($data['walletBallance']) ? (int) $data['walletBallance'] : (isset($data['wallet_ballance']) ? (int) $data['wallet_ballance'] : null));
        $self->setType($data['type'] ?? null);

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'link' => $this->link,
            'manifestLink' => $this->manifestLink,
            'shoppingCart' => $this->shoppingCart?->toArray(),
            'walletBallance' => $this->walletBallance,
            'type' => $this->type,
        ];
    }
}
