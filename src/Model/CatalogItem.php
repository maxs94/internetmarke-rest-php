<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class CatalogItem
{
    private ?string $category = null;
    private ?string $categoryDescription = null;
    private ?int $categoryId = null;

    /** @var ImageItem[] */
    private array $images = [];

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategoryDescription(?string $desc): self
    {
        $this->categoryDescription = $desc;

        return $this;
    }

    public function getCategoryDescription(): ?string
    {
        return $this->categoryDescription;
    }

    public function setCategoryId(?int $id): self
    {
        $this->categoryId = $id;

        return $this;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    /**
     * @param ImageItem[] $images
     */
    public function setImages(array $images): self
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @return ImageItem[]
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->setCategory((string) ($data['category'] ?? ''));
        $self->setCategoryDescription((string) ($data['categoryDescription'] ?? $data['category_description'] ?? ''));
        $self->setCategoryId(isset($data['categoryId']) ? (int) $data['categoryId'] : (isset($data['category_id']) ? (int) $data['category_id'] : null));
        $items = $data['images'] ?? [];
        if (is_array($items)) {
            $imgs = [];
            foreach ($items as $it) {
                $imgs[] = ImageItem::fromArray((array) $it);
            }
            $self->setImages($imgs);
        }

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'category' => $this->category,
            'categoryDescription' => $this->categoryDescription,
            'categoryId' => $this->categoryId,
            'images' => array_map(fn (ImageItem $i) => $i->toArray(), $this->images),
        ];
    }
}
