<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class BorderDimension
{
    private ?float $top = null;
    private ?float $bottom = null;
    private ?float $left = null;
    private ?float $right = null;

    public function setTop(?float $top): self
    {
        $this->top = $top;

        return $this;
    }

    public function getTop(): ?float
    {
        return $this->top;
    }

    public function setBottom(?float $bottom): self
    {
        $this->bottom = $bottom;

        return $this;
    }

    public function getBottom(): ?float
    {
        return $this->bottom;
    }

    public function setLeft(?float $left): self
    {
        $this->left = $left;

        return $this;
    }

    public function getLeft(): ?float
    {
        return $this->left;
    }

    public function setRight(?float $right): self
    {
        $this->right = $right;

        return $this;
    }

    public function getRight(): ?float
    {
        return $this->right;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->setTop(isset($data['top']) ? (float) $data['top'] : null);
        $self->setBottom(isset($data['bottom']) ? (float) $data['bottom'] : null);
        $self->setLeft(isset($data['left']) ? (float) $data['left'] : null);
        $self->setRight(isset($data['right']) ? (float) $data['right'] : null);

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'top' => $this->top,
            'bottom' => $this->bottom,
            'left' => $this->left,
            'right' => $this->right,
        ];
    }
}
