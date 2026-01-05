<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class AuthenticationResponse
{
    private ?string $accessToken = null;
    private ?int $walletBalance = null;
    private ?string $infoMessage = null;
    private ?string $tokenType = null;
    private ?int $expiresIn = null;
    private ?\DateTimeImmutable $issuedAt = null;
    private ?string $externalCustomerId = null;
    private ?string $authenticatedUser = null;

    public function setAccessToken(string $token): self
    {
        $this->accessToken = $token;

        return $this;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function setWalletBalance(?int $balance): self
    {
        $this->walletBalance = $balance;

        return $this;
    }

    public function getWalletBalance(): ?int
    {
        return $this->walletBalance;
    }

    public function setInfoMessage(?string $message): self
    {
        $this->infoMessage = $message;

        return $this;
    }

    public function getInfoMessage(): ?string
    {
        return $this->infoMessage;
    }

    public function setTokenType(?string $type): self
    {
        $this->tokenType = $type;

        return $this;
    }

    public function getTokenType(): ?string
    {
        return $this->tokenType;
    }

    public function setExpiresIn(?int $seconds): self
    {
        $this->expiresIn = $seconds;

        return $this;
    }

    public function getExpiresIn(): ?int
    {
        return $this->expiresIn;
    }

    public function setIssuedAt(?\DateTimeImmutable $issuedAt): self
    {
        $this->issuedAt = $issuedAt;

        return $this;
    }

    public function getIssuedAt(): ?\DateTimeImmutable
    {
        return $this->issuedAt;
    }

    public function setExternalCustomerId(?string $id): self
    {
        $this->externalCustomerId = $id;

        return $this;
    }

    public function getExternalCustomerId(): ?string
    {
        return $this->externalCustomerId;
    }

    public function setAuthenticatedUser(?string $user): self
    {
        $this->authenticatedUser = $user;

        return $this;
    }

    public function getAuthenticatedUser(): ?string
    {
        return $this->authenticatedUser;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();

        $self->setAccessToken((string) ($data['access_token'] ?? $data['accessToken'] ?? ''));
        $self->setWalletBalance(isset($data['walletBalance']) ? (int) $data['walletBalance'] : (isset($data['wallet_balance']) ? (int) $data['wallet_balance'] : null));
        $self->setInfoMessage($data['infoMessage'] ?? $data['info_message'] ?? null);
        $self->setTokenType($data['tokenType'] ?? $data['token_type'] ?? null);
        $self->setExpiresIn(isset($data['expires_in']) ? (int) $data['expires_in'] : (isset($data['expiresIn']) ? (int) $data['expiresIn'] : null));
        if (!empty($data['issued_at'] ?? $data['issuedAt'] ?? null)) {
            try {
                $issued = new \DateTimeImmutable($data['issued_at'] ?? $data['issuedAt']);
                $self->setIssuedAt($issued);
            } catch (\Throwable) {
                // ignore parse errors, keep null
            }
        }
        $self->setExternalCustomerId($data['external_customer_id'] ?? $data['externalCustomerId'] ?? null);
        $self->setAuthenticatedUser($data['authenticated_user'] ?? $data['authenticatedUser'] ?? null);

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'access_token' => $this->accessToken,
            'walletBalance' => $this->walletBalance,
            'infoMessage' => $this->infoMessage,
            'tokenType' => $this->tokenType,
            'expires_in' => $this->expiresIn,
            'issued_at' => $this->issuedAt?->format('D, d M Y H:i:s') . ' GMT',
            'external_customer_id' => $this->externalCustomerId,
            'authenticated_user' => $this->authenticatedUser,
        ];
    }
}
