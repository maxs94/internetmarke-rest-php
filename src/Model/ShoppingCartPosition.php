<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

use Maxs94\Internetmarke\Validator\EnumValidator;
use Maxs94\Internetmarke\Validator\IntegerMinValidator;

final class ShoppingCartPosition
{
    public const VOUCHER_LAYOUT_ADDRESS_ZONE = 'ADDRESS_ZONE';
    public const VOUCHER_LAYOUT_FRANKING_ZONE = 'FRANKING_ZONE';

    private ?int $productCode = null;
    private ?int $imageID = null;
    private ?Address $sender = null;
    private ?Address $receiver = null;
    private ?string $voucherLayout = self::VOUCHER_LAYOUT_ADDRESS_ZONE;
    private ?string $positionType = null;
    private ?Position $position = null;

    public function __construct()
    {
        $this->position = new Position(1, 1, 1);
    }

    public function setProductCode(?int $code): self
    {
        IntegerMinValidator::validate($code, 1, 'productCode');
        $this->productCode = $code;

        return $this;
    }

    public function getProductCode(): ?int
    {
        return $this->productCode;
    }

    public function setImageID(?int $id): self
    {
        $this->imageID = $id;

        return $this;
    }

    public function getImageID(): ?int
    {
        return $this->imageID;
    }

    public function setSender(?Address $address): self
    {
        $this->sender = $address;

        return $this;
    }

    public function getSender(): ?Address
    {
        return $this->sender;
    }

    public function setReceiver(?Address $address): self
    {
        $this->receiver = $address;

        return $this;
    }

    public function getReceiver(): ?Address
    {
        return $this->receiver;
    }

    public function setVoucherLayout(?string $layout): self
    {
        EnumValidator::validate($layout, [self::VOUCHER_LAYOUT_ADDRESS_ZONE, self::VOUCHER_LAYOUT_FRANKING_ZONE], 'voucherLayout');
        $this->voucherLayout = $layout;

        return $this;
    }

    public function getVoucherLayout(): ?string
    {
        return $this->voucherLayout;
    }

    public function setPositionType(?string $type): self
    {
        $this->positionType = $type;

        return $this;
    }

    public function getPositionType(): ?string
    {
        return $this->positionType;
    }

    public function setPosition(?Position $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getPosition(): ?Position
    {
        return $this->position;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->setProductCode(isset($data['productCode']) ? (int) $data['productCode'] : (isset($data['product_code']) ? (int) $data['product_code'] : null));
        $self->setImageID(isset($data['imageID']) ? (int) $data['imageID'] : (isset($data['image_id']) ? (int) $data['image_id'] : null));
        $address = $data['address'] ?? [];
        if (!empty($address['sender'])) {
            $self->setSender(Address::fromArray((array) $address['sender']));
        }
        if (!empty($address['receiver'])) {
            $self->setReceiver(Address::fromArray((array) $address['receiver']));
        }
        $self->setVoucherLayout($data['voucherLayout'] ?? $data['voucher_layout'] ?? null);
        $self->setPositionType($data['positionType'] ?? $data['position_type'] ?? null);

        if (!empty($data['position'])) {
            $self->setPosition(Position::fromArray((array) $data['position']));
        }

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        $data = [
            'productCode' => $this->productCode,
            'address' => [
                'sender' => $this->sender ? $this->sender->toArray() : null,
                'receiver' => $this->receiver ? $this->receiver->toArray() : null,
            ],
            'positionType' => $this->positionType,
            'voucherLayout' => $this->voucherLayout,
        ];

        if (!empty($this->imageID)) {
            $data['imageID'] = $this->imageID;
        }

        if ($this->position !== null) {
            $data['position'] = $this->position->toArray();
        }

        return $data;
    }
}
