<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class RequestStatus
{
    private ?string $statusCode = null;
    private ?string $title = null;
    private ?string $detail = null;

    public function setStatusCode(?string $code): self
    {
        $this->statusCode = $code;

        return $this;
    }

    public function getStatusCode(): ?string
    {
        return $this->statusCode;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setDetail(?string $detail): self
    {
        $this->detail = $detail;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->setStatusCode($data['statusCode'] ?? $data['status_code'] ?? null);
        $self->setTitle($data['title'] ?? null);
        $self->setDetail($data['detail'] ?? null);

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'statusCode' => $this->statusCode,
            'title' => $this->title,
            'detail' => $this->detail,
        ];
    }
}
