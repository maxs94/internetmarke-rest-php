<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class AddressBinding
{
    private ?Address $sender = null;
    private ?Address $receiver = null;

    public function setSender(Address $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getSender(): ?Address
    {
        return $this->sender;
    }

    public function setReceiver(Address $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function getReceiver(): ?Address
    {
        return $this->receiver;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        if (!empty($data['sender'])) {
            $self->setSender(Address::fromArray((array) $data['sender']));
        }
        if (!empty($data['receiver'])) {
            $self->setReceiver(Address::fromArray((array) $data['receiver']));
        }

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'sender' => $this->sender?->toArray(),
            'receiver' => $this->receiver?->toArray(),
        ];
    }
}
