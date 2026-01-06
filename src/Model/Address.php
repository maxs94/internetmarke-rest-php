<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class Address
{
    private ?string $name = null;
    private ?string $additionalName = null;
    private ?string $addressLine1 = null;
    private ?string $addressLine2 = null;
    private ?string $postalCode = null;
    private ?string $city = null;
    private ?string $country = null;

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setAdditionalName(?string $additionalName): self
    {
        $this->additionalName = $additionalName;

        return $this;
    }

    public function getAdditionalName(): ?string
    {
        return $this->additionalName;
    }

    public function setAddressLine1(string $line): self
    {
        $this->addressLine1 = $line;

        return $this;
    }

    public function getAddressLine1(): ?string
    {
        return $this->addressLine1;
    }

    public function setAddressLine2(?string $line): self
    {
        $this->addressLine2 = $line;

        return $this;
    }

    public function getAddressLine2(): ?string
    {
        return $this->addressLine2;
    }

    public function setPostalCode(string $code): self
    {
        $this->postalCode = $code;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->setName((string) ($data['name'] ?? $data['fullname'] ?? ''));
        $self->setAdditionalName($data['additionalName'] ?? $data['additional_name'] ?? null);
        $self->setAddressLine1((string) ($data['addressLine1'] ?? $data['address_line1'] ?? ''));
        $self->setAddressLine2($data['addressLine2'] ?? $data['address_line2'] ?? null);
        $self->setPostalCode((string) ($data['postalCode'] ?? $data['postal_code'] ?? ''));
        $self->setCity((string) ($data['city'] ?? ''));
        $self->setCountry((string) ($data['country'] ?? ''));

        return $self;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'name' => $this->name,
            'addressLine1' => $this->addressLine1,
            'postalCode' => $this->postalCode,
            'city' => $this->city,
            'country' => $this->country,
        ];

        if ($this->additionalName !== null) {
            $data['additionalName'] = $this->additionalName;
        }

        if ($this->addressLine2 !== null) {
            $data['addressLine2'] = $this->addressLine2;
        }

        return $data;
    }
}
