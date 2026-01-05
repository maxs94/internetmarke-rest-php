<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class PageLayout
{
    private ?Dimension $size = null;
    private ?string $orientation = null;
    private ?Dimension $labelSpacing = null;
    private ?Position $labelCount = null;
    private ?BorderDimension $margin = null;

    public function setSize(Dimension $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getSize(): ?Dimension
    {
        return $this->size;
    }

    public function setOrientation(?string $orientation): self
    {
        $this->orientation = $orientation;

        return $this;
    }

    public function getOrientation(): ?string
    {
        return $this->orientation;
    }

    public function setLabelSpacing(Dimension $dim): self
    {
        $this->labelSpacing = $dim;

        return $this;
    }

    public function getLabelSpacing(): ?Dimension
    {
        return $this->labelSpacing;
    }

    public function setLabelCount(Position $pos): self
    {
        $this->labelCount = $pos;

        return $this;
    }

    public function getLabelCount(): ?Position
    {
        return $this->labelCount;
    }

    public function setMargin(BorderDimension $margin): self
    {
        $this->margin = $margin;

        return $this;
    }

    public function getMargin(): ?BorderDimension
    {
        return $this->margin;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        if (!empty($data['size'])) {
            $self->setSize(Dimension::fromArray((array) $data['size']));
        }
        $self->setOrientation($data['orientation'] ?? null);
        if (!empty($data['labelSpacing'])) {
            $self->setLabelSpacing(Dimension::fromArray((array) $data['labelSpacing']));
        }
        if (!empty($data['labelCount'])) {
            $self->setLabelCount(Position::fromArray((array) $data['labelCount']));
        }
        if (!empty($data['margin'])) {
            $self->setMargin(BorderDimension::fromArray((array) $data['margin']));
        }

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'size' => $this->size?->toArray(),
            'orientation' => $this->orientation,
            'labelSpacing' => $this->labelSpacing?->toArray(),
            'labelCount' => $this->labelCount?->toArray(),
            'margin' => $this->margin?->toArray(),
        ];
    }
}
