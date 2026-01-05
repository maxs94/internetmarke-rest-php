<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class AppCheckoutPNGRequest
{
    private ?string $type = null;

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->setType($data['type'] ?? null);

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
        ];
    }
}
