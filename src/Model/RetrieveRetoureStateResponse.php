<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class RetrieveRetoureStateResponse
{
    /** @var RetoureState[] */
    private array $retoureStates = [];

    /**
     * @param RetoureState[] $states
     */
    public function setRetoureStates(array $states): self
    {
        $this->retoureStates = $states;

        return $this;
    }

    /**
     * @return RetoureState[]
     */
    public function getRetoureStates(): array
    {
        return $this->retoureStates;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $list = $data['RetrieveRetoureStateResponse'] ?? $data['retrieveRetoureStateResponse'] ?? $data['retrieve_retoure_state_response'] ?? [];
        if (is_array($list)) {
            $items = [];
            foreach ($list as $it) {
                $items[] = RetoureState::fromArray((array) $it);
            }
            $self->setRetoureStates($items);
        }

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'RetrieveRetoureStateResponse' => array_map(fn (RetoureState $s) => $s->toArray(), $this->retoureStates),
        ];
    }
}
