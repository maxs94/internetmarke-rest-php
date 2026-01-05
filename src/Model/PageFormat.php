<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class PageFormat
{
    private ?int $id = null;
    private ?bool $isAddressPossible = null;
    private ?bool $isImagePossible = null;
    private ?string $name = null;
    private ?string $description = null;
    private ?string $pageType = null;
    private ?PageLayout $pageLayout = null;

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setIsAddressPossible(?bool $flag): self
    {
        $this->isAddressPossible = $flag;

        return $this;
    }

    public function getIsAddressPossible(): ?bool
    {
        return $this->isAddressPossible;
    }

    public function setIsImagePossible(?bool $flag): self
    {
        $this->isImagePossible = $flag;

        return $this;
    }

    public function getIsImagePossible(): ?bool
    {
        return $this->isImagePossible;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setDescription(?string $desc): self
    {
        $this->description = $desc;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setPageType(?string $type): self
    {
        $this->pageType = $type;

        return $this;
    }

    public function getPageType(): ?string
    {
        return $this->pageType;
    }

    public function setPageLayout(?PageLayout $layout): self
    {
        $this->pageLayout = $layout;

        return $this;
    }

    public function getPageLayout(): ?PageLayout
    {
        return $this->pageLayout;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->setId(isset($data['id']) ? (int) $data['id'] : null);
        $self->setIsAddressPossible(isset($data['isAddressPossible']) ? (bool) $data['isAddressPossible'] : (isset($data['is_address_possible']) ? (bool) $data['is_address_possible'] : null));
        $self->setIsImagePossible(isset($data['isImagePossible']) ? (bool) $data['isImagePossible'] : (isset($data['is_image_possible']) ? (bool) $data['is_image_possible'] : null));
        $self->setName($data['name'] ?? null);
        $self->setDescription($data['description'] ?? null);
        $self->setPageType($data['pageType'] ?? $data['page_type'] ?? null);
        if (!empty($data['pageLayout'])) {
            $self->setPageLayout(PageLayout::fromArray((array) $data['pageLayout']));
        }

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'isAddressPossible' => $this->isAddressPossible,
            'isImagePossible' => $this->isImagePossible,
            'name' => $this->name,
            'description' => $this->description,
            'pageType' => $this->pageType,
            'pageLayout' => $this->pageLayout?->toArray(),
        ];
    }
}
