<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class Dimension
{
    private ?float $x = null;
    private ?float $y = null;

    public function setX(?float $x): self
    {
        $this->x = $x;

        return $this;
    }

    public function getX(): ?float
    {
        return $this->x;
    }

    public function setY(?float $y): self
    {
        $this->y = $y;

        return $this;
    }

    public function getY(): ?float
    {
        return $this->y;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->setX(isset($data['x']) ? (float) $data['x'] : (isset($data['X']) ? (float) $data['X'] : null));
        $self->setY(isset($data['y']) ? (float) $data['y'] : (isset($data['Y']) ? (float) $data['Y'] : null));

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'x' => $this->x,
            'y' => $this->y,
        ];
    }
}
