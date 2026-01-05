<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class ShoppingCartPDFRequest
{
    public const TYPE = 'AppShoppingCartPDFRequest';
    public const POSITION_TYPE = 'AppShoppingCartPDFPosition';

    private ?string $shopOrderId = null;
    private ?int $total = null;
    private ?bool $createManifest = true;
    private ?int $createShippingList = 0;
    private ?string $dpi = 'DPI300';
    private ?int $pageFormatId = 1;
    private ?string $type = self::TYPE;

    /** @var ShoppingCartPosition[] */
    private array $positions = [];

    public function setShopOrderId(?string $id): self
    {
        $this->shopOrderId = $id;

        return $this;
    }

    public function getShopOrderId(): ?string
    {
        return $this->shopOrderId;
    }

    public function setTotal(?int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setCreateManifest(?bool $flag): self
    {
        $this->createManifest = $flag;

        return $this;
    }

    public function isCreateManifest(): ?bool
    {
        return $this->createManifest;
    }

    public function setCreateShippingList(?int $value): self
    {
        $this->createShippingList = $value;

        return $this;
    }

    public function getCreateShippingList(): ?int
    {
        return $this->createShippingList;
    }

    public function setDpi(?string $dpi): self
    {
        $this->dpi = $dpi;

        return $this;
    }

    public function getDpi(): ?string
    {
        return $this->dpi;
    }

    public function setPageFormatId(?int $id): self
    {
        $this->pageFormatId = $id;

        return $this;
    }

    public function getPageFormatId(): ?int
    {
        return $this->pageFormatId;
    }

    /**
     * @param ShoppingCartPosition[] $positions
     */
    public function setPositions(array $positions): self
    {
        $this->positions = $positions;

        foreach ($this->positions as $position) {
            $position->setPositionType(self::POSITION_TYPE);
        }

        return $this;
    }

    /**
     * @return ShoppingCartPosition[]
     */
    public function getPositions(): array
    {
        return $this->positions;
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
        $self->setShopOrderId($data['shopOrderId'] ?? $data['shop_order_id'] ?? null);
        $self->setTotal(isset($data['total']) ? (int) $data['total'] : null);
        $self->setCreateManifest(isset($data['createManifest']) ? (bool) $data['createManifest'] : (isset($data['create_manifest']) ? (bool) $data['create_manifest'] : null));
        $self->setCreateShippingList($data['createShippingList'] ?? $data['create_shipping_list'] ?? null);
        $self->setDpi($data['dpi'] ?? null);
        $self->setPageFormatId(isset($data['pageFormatId']) ? (int) $data['pageFormatId'] : (isset($data['page_format_id']) ? (int) $data['page_format_id'] : null));
        $positions = $data['positions'] ?? [];
        if (is_array($positions)) {
            $items = [];
            foreach ($positions as $p) {
                $items[] = ShoppingCartPosition::fromArray((array) $p);
            }
            $self->setPositions($items);
        }
        $self->setType($data['type'] ?? null);

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'shopOrderId' => $this->shopOrderId,
            'total' => $this->total,
            'createManifest' => $this->createManifest,
            'createShippingList' => $this->createShippingList,
            'dpi' => $this->dpi,
            'pageFormatId' => $this->pageFormatId,
            'positions' => array_map(fn (ShoppingCartPosition $p) => $p->toArray(), $this->positions),
            'type' => $this->type,
        ];
    }
}
