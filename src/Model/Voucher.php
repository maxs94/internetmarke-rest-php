<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class Voucher
{
    private ?string $voucherId = null;
    private ?string $trackId = null;

    public function setVoucherId(string $id): self
    {
        $this->voucherId = $id;

        return $this;
    }

    public function getVoucherId(): ?string
    {
        return $this->voucherId;
    }

    public function setTrackId(?string $trackId): self
    {
        $this->trackId = $trackId;

        return $this;
    }

    public function getTrackId(): ?string
    {
        return $this->trackId;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->setVoucherId((string) ($data['voucherId'] ?? $data['voucher_id'] ?? ''));
        $self->setTrackId($data['trackId'] ?? $data['track_id'] ?? null);

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'voucherId' => $this->voucherId,
            'trackId' => $this->trackId,
        ];
    }
}
