<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

use Maxs94\Internetmarke\Exception\ApiException;

final class ApiVersionResponse
{
    private ?string $env = null;
    private ?string $version = null;
    private ?string $rev = null;
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

    public function setRev(?string $rev): self
    {
        $this->rev = $rev;

        return $this;
    }
    public function getRev(): ?string
    {
        return $this->rev;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $amp = $data['amp'] ?? null;
        if (!is_array($amp)) {
            throw new ApiException('Invalid data for ApiVersionResponse: missing amp field');
        }

        $self = new self();
        $self->setEnv($amp['env'] ?? null);
        $self->setVersion($amp['version'] ?? null);
        $self->setDescription($amp['description'] ?? null);
        $self->setRev($amp['rev'] ?? null);

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
