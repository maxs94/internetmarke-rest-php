<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class MotiveLink
{
    private ?string $link = null;
    private ?string $linkThumbnail = null;

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLinkThumbnail(?string $thumb): self
    {
        $this->linkThumbnail = $thumb;

        return $this;
    }

    public function getLinkThumbnail(): ?string
    {
        return $this->linkThumbnail;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->setLink($data['link'] ?? null);
        $self->setLinkThumbnail($data['linkThumbnail'] ?? $data['link_thumbnail'] ?? null);

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'link' => $this->link,
            'linkThumbnail' => $this->linkThumbnail,
        ];
    }
}
