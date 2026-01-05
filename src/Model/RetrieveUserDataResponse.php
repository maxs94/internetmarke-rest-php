<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class RetrieveUserDataResponse
{
    private ?string $ekp = null;
    private ?string $company = null;
    private ?string $salutation = null;
    private ?string $title = null;
    private ?string $invoiceType = null;
    private ?string $invoiceFrequency = null;
    private ?string $mail = null;
    private ?string $firstname = null;
    private ?string $lastname = null;
    private ?string $street = null;
    private ?string $houseNo = null;
    private ?string $zip = null;
    private ?string $city = null;
    private ?string $country = null;
    private ?string $phone = null;
    private ?string $pobox = null;
    private ?string $poboxZip = null;
    private ?string $poboxCity = null;
    private ?string $epostbrief = null;

    public function setEkp(?string $ekp): self
    {
        $this->ekp = $ekp;

        return $this;
    }

    public function getEkp(): ?string
    {
        return $this->ekp;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setSalutation(?string $salutation): self
    {
        $this->salutation = $salutation;

        return $this;
    }

    public function getSalutation(): ?string
    {
        return $this->salutation;
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

    public function setInvoiceType(?string $type): self
    {
        $this->invoiceType = $type;

        return $this;
    }

    public function getInvoiceType(): ?string
    {
        return $this->invoiceType;
    }

    public function setInvoiceFrequency(?string $frequency): self
    {
        $this->invoiceFrequency = $frequency;

        return $this;
    }

    public function getInvoiceFrequency(): ?string
    {
        return $this->invoiceFrequency;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setFirstname(?string $first): self
    {
        $this->firstname = $first;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setLastname(?string $last): self
    {
        $this->lastname = $last;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setHouseNo(?string $houseNo): self
    {
        $this->houseNo = $houseNo;

        return $this;
    }

    public function getHouseNo(): ?string
    {
        return $this->houseNo;
    }

    public function setZip(?string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPobox(?string $pobox): self
    {
        $this->pobox = $pobox;

        return $this;
    }

    public function getPobox(): ?string
    {
        return $this->pobox;
    }

    public function setPoboxZip(?string $zip): self
    {
        $this->poboxZip = $zip;

        return $this;
    }

    public function getPoboxZip(): ?string
    {
        return $this->poboxZip;
    }

    public function setPoboxCity(?string $city): self
    {
        $this->poboxCity = $city;

        return $this;
    }

    public function getPoboxCity(): ?string
    {
        return $this->poboxCity;
    }

    public function setEpostbrief(?string $epostbrief): self
    {
        $this->epostbrief = $epostbrief;

        return $this;
    }

    public function getEpostbrief(): ?string
    {
        return $this->epostbrief;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->setEkp($data['ekp'] ?? null);
        $self->setCompany($data['company'] ?? null);
        $self->setSalutation($data['salutation'] ?? null);
        $self->setTitle($data['title'] ?? null);
        $self->setInvoiceType($data['invoiceType'] ?? $data['invoice_type'] ?? null);
        $self->setInvoiceFrequency($data['invoiceFrequency'] ?? $data['invoice_frequency'] ?? null);
        $self->setMail($data['mail'] ?? null);
        $self->setFirstname($data['firstname'] ?? null);
        $self->setLastname($data['lastname'] ?? null);
        $self->setStreet($data['street'] ?? null);
        $self->setHouseNo($data['houseNo'] ?? $data['house_no'] ?? null);
        $self->setZip($data['zip'] ?? null);
        $self->setCity($data['city'] ?? null);
        $self->setCountry($data['country'] ?? null);
        $self->setPhone($data['phone'] ?? null);
        $self->setPobox($data['pobox'] ?? null);
        $self->setPoboxZip($data['poboxZip'] ?? $data['pobox_zip'] ?? null);
        $self->setPoboxCity($data['poboxCity'] ?? $data['pobox_city'] ?? null);
        $self->setEpostbrief($data['epostbrief'] ?? null);

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'ekp' => $this->ekp,
            'company' => $this->company,
            'salutation' => $this->salutation,
            'title' => $this->title,
            'invoiceType' => $this->invoiceType,
            'invoiceFrequency' => $this->invoiceFrequency,
            'mail' => $this->mail,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'street' => $this->street,
            'houseNo' => $this->houseNo,
            'zip' => $this->zip,
            'city' => $this->city,
            'country' => $this->country,
            'phone' => $this->phone,
            'pobox' => $this->pobox,
            'poboxZip' => $this->poboxZip,
            'poboxCity' => $this->poboxCity,
            'epostbrief' => $this->epostbrief,
        ];
    }
}
