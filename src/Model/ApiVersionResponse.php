<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class ApiVersionResponse
{
    private ?string $env = null;
    private ?string $version = null;
    private ?string $description = null;

    public function setEnv(?string $env): self
    {
        $this->env = $env;

        return $this;
    }

    public function getEnv(): ?string
    {
        return $this->env;
    }

    public function setVersion(?string $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->setEnv($data['env'] ?? null);
        $self->setVersion($data['version'] ?? null);
        $self->setDescription($data['description'] ?? null);

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'env' => $this->env,
            'version' => $this->version,
            'description' => $this->description,
        ];
    }
}
