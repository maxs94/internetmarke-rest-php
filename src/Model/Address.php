<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

use Maxs94\Internetmarke\Validator\StringLengthValidator;

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
        StringLengthValidator::validate($name, 1, 50, 'name');
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setAdditionalName(?string $additionalName): self
    {
        StringLengthValidator::validate($additionalName, 0, 40, 'additionalName');
        $this->additionalName = $additionalName;

        return $this;
    }

    public function getAdditionalName(): ?string
    {
        return $this->additionalName;
    }

    public function setAddressLine1(string $line): self
    {
        StringLengthValidator::validate($line, 1, 50, 'addressLine1');
        $this->addressLine1 = trim($line);

        return $this;
    }

    public function getAddressLine1(): ?string
    {
        return $this->addressLine1;
    }

    public function setAddressLine2(?string $line): self
    {
        StringLengthValidator::validate($line, 1, 60, 'addressLine2');
        if ($line !== null) {
            $line = trim($line);
        }

        $this->addressLine2 = $line;

        return $this;
    }

    public function getAddressLine2(): ?string
    {
        return $this->addressLine2;
    }

    public function setPostalCode(string $code): self
    {
        StringLengthValidator::validate($code, 5, 5, 'postalCode');
        $this->postalCode = trim($code);

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setCity(string $city): self
    {
        StringLengthValidator::validate($city, 1, 40, 'city');
        $this->city = trim($city);

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCountry(string $country): self
    {
        StringLengthValidator::validate($country, 3, 3, 'country');
        $this->country = trim($country);

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

        if (!empty($this->additionalName)) {
            $data['additionalName'] = $this->additionalName;
        }

        if (!empty($this->addressLine2)) {
            $data['addressLine2'] = $this->addressLine2;
        }

        return $data;
    }
}
