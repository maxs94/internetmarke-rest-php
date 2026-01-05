<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

use Maxs94\Internetmarke\Exception\ApiException;

final class Position
{
    public function __construct(
        private int $labelX = 0,
        private int $labelY = 0,
        private int $page = 0,
    ) {
    }

    public function setLabelX(int $x): self
    {
        if ($x !== null && $x < 0) {
            throw new ApiException('Label X coordinate must be greater than or equal to 0.');
        }

        $this->labelX = $x;

        return $this;
    }

    public function getLabelX(): ?int
    {
        return $this->labelX;
    }

    public function setLabelY(int $y): self
    {
        if ($y !== null && $y < 0) {
            throw new ApiException('Label Y coordinate must be greater than or equal to 0.');
        }

        $this->labelY = $y;

        return $this;
    }

    public function getLabelY(): int
    {
        return $this->labelY;
    }

    public function setPage(int $page): self
    {
        if ($page !== null && $page < 1) {
            throw new ApiException('Page number must be greater than or equal to 1.');
        }

        $this->page = $page;

        return $this;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->setLabelX(isset($data['labelX']) ? (int) $data['labelX'] : (isset($data['label_x']) ? (int) $data['label_x'] : 0));
        $self->setLabelY(isset($data['labelY']) ? (int) $data['labelY'] : (isset($data['label_y']) ? (int) $data['label_y'] : 0));
        $self->setPage(isset($data['page']) ? (int) $data['page'] : (isset($data['page']) ? (int) $data['page'] : 1));

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
