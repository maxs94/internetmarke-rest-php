<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class PrivateCatalog
{
    /** @var MotiveLink[] */
    private array $imageLink = [];

    /**
     * @param MotiveLink[] $links
     */
    public function setImageLink(array $links): self
    {
        $this->imageLink = $links;

        return $this;
    }

    /**
     * @return MotiveLink[]
     */
    public function getImageLink(): array
    {
        return $this->imageLink;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $items = $data['imageLink'] ?? $data['image_link'] ?? [];
        if (is_array($items)) {
            $list = [];
            foreach ($items as $it) {
                $list[] = MotiveLink::fromArray((array) $it);
            }
            $self->setImageLink($list);
        }

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'imageLink' => array_map(fn (MotiveLink $m) => $m->toArray(), $this->imageLink),
        ];
    }
}
