<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class PublicCatalog
{
    /** @var CatalogItem[] */
    private array $items = [];

    /**
     * @param CatalogItem[] $items
     */
    public function setItems(array $items): self
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @return CatalogItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $items = $data['items'] ?? [];
        if (is_array($items)) {
            $list = [];
            foreach ($items as $it) {
                $list[] = CatalogItem::fromArray((array) $it);
            }
            $self->setItems($list);
        }

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'items' => array_map(fn (CatalogItem $i) => $i->toArray(), $this->items),
        ];
    }
}
