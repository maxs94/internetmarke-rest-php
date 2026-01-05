<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class AuthenticationRequest
{
    private string $grantType = 'client_credentials';
    private ?string $username = null;
    private ?string $password = null;
    private ?string $clientId = null;
    private ?string $clientSecret = null;

    public function setGrantType(string $grantType): self
    {
        $this->grantType = $grantType;

        return $this;
    }

    public function getGrantType(): string
    {
        return $this->grantType;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setClientId(?string $clientId): self
    {
        $this->clientId = $clientId;

        return $this;
    }

    public function getClientId(): ?string
    {
        return $this->clientId;
    }

    public function setClientSecret(?string $clientSecret): self
    {
        $this->clientSecret = $clientSecret;

        return $this;
    }

    public function getClientSecret(): ?string
    {
        return $this->clientSecret;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->setGrantType((string) ($data['grant_type'] ?? $data['grantType'] ?? 'client_credentials'));
        $self->setClientId($data['client_id'] ?? $data['clientId'] ?? null);
        $self->setClientSecret($data['client_secret'] ?? $data['clientSecret'] ?? null);
        $self->setUsername($data['username'] ?? null);
        $self->setPassword($data['password'] ?? null);

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'grant_type' => $this->grantType,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'username' => $this->username,
            'password' => $this->password,
        ];
    }
}
