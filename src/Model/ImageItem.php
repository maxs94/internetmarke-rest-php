<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class ImageItem
{
    private ?int $imageID = null;
    private ?string $imageDescription = null;
    private ?string $imageSlogan = null;
    private ?MotiveLink $links = null;

    public function setImageID(?int $id): self
    {
        $this->imageID = $id;

        return $this;
    }

    public function getImageID(): ?int
    {
        return $this->imageID;
    }

    public function setImageDescription(?string $desc): self
    {
        $this->imageDescription = $desc;

        return $this;
    }

    public function getImageDescription(): ?string
    {
        return $this->imageDescription;
    }

    public function setImageSlogan(?string $slogan): self
    {
        $this->imageSlogan = $slogan;

        return $this;
    }

    public function getImageSlogan(): ?string
    {
        return $this->imageSlogan;
    }

    public function setLinks(?MotiveLink $links): self
    {
        $this->links = $links;

        return $this;
    }

    public function getLinks(): ?MotiveLink
    {
        return $this->links;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->setImageID(isset($data['imageID']) ? (int) $data['imageID'] : (isset($data['image_id']) ? (int) $data['image_id'] : null));
        $self->setImageDescription($data['imageDescription'] ?? $data['image_description'] ?? null);
        $self->setImageSlogan($data['imageSlogan'] ?? $data['image_slogan'] ?? null);
        if (!empty($data['links'])) {
            $self->setLinks(MotiveLink::fromArray((array) $data['links']));
        }

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'imageID' => $this->imageID,
            'imageDescription' => $this->imageDescription,
            'imageSlogan' => $this->imageSlogan,
            'links' => $this->links?->toArray(),
        ];
    }
}
