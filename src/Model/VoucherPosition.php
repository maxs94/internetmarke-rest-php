<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class VoucherPosition
{
    private ?int $labelX = null;
    private ?int $labelY = null;
    private ?int $page = null;

    public function setLabelX(?int $x): self
    {
        $this->labelX = $x;

        return $this;
    }

    public function getLabelX(): ?int
    {
        return $this->labelX;
    }

    public function setLabelY(?int $y): self
    {
        $this->labelY = $y;

        return $this;
    }

    public function getLabelY(): ?int
    {
        return $this->labelY;
    }

    public function setPage(?int $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->setLabelX(isset($data['labelX']) ? (int) $data['labelX'] : (isset($data['label_x']) ? (int) $data['label_x'] : null));
        $self->setLabelY(isset($data['labelY']) ? (int) $data['labelY'] : (isset($data['label_y']) ? (int) $data['label_y'] : null));
        $self->setPage(isset($data['page']) ? (int) $data['page'] : null);

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'labelX' => $this->labelX,
            'labelY' => $this->labelY,
            'page' => $this->page,
        ];
    }
}
