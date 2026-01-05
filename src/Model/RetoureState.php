<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class RetoureState
{
    private ?int $retoureTransactionId = null;
    private ?string $shopRetoureId = null;
    private ?int $totalCount = null;
    private ?int $countStillOpen = null;
    private ?int $retourePrice = null;
    private ?string $creationDate = null;
    private ?string $serialnumber = null;

    /** @var Voucher[] */
    private array $refundedVouchers = [];

    /** @var Voucher[] */
    private array $notRefundedVouchers = [];

    public function setRetoureTransactionId(?int $id): self
    {
        $this->retoureTransactionId = $id;

        return $this;
    }

    public function getRetoureTransactionId(): ?int
    {
        return $this->retoureTransactionId;
    }

    public function setShopRetoureId(?string $id): self
    {
        $this->shopRetoureId = $id;

        return $this;
    }

    public function getShopRetoureId(): ?string
    {
        return $this->shopRetoureId;
    }

    public function setTotalCount(?int $count): self
    {
        $this->totalCount = $count;

        return $this;
    }

    public function getTotalCount(): ?int
    {
        return $this->totalCount;
    }

    public function setCountStillOpen(?int $count): self
    {
        $this->countStillOpen = $count;

        return $this;
    }

    public function getCountStillOpen(): ?int
    {
        return $this->countStillOpen;
    }

    public function setRetourePrice(?int $price): self
    {
        $this->retourePrice = $price;

        return $this;
    }

    public function getRetourePrice(): ?int
    {
        return $this->retourePrice;
    }

    public function setCreationDate(?string $date): self
    {
        $this->creationDate = $date;

        return $this;
    }

    public function getCreationDate(): ?string
    {
        return $this->creationDate;
    }

    public function setSerialnumber(?string $serial): self
    {
        $this->serialnumber = $serial;

        return $this;
    }

    public function getSerialnumber(): ?string
    {
        return $this->serialnumber;
    }

    /**
     * @param Voucher[] $vouchers
     */
    public function setRefundedVouchers(array $vouchers): self
    {
        $this->refundedVouchers = $vouchers;

        return $this;
    }

    /**
     * @return Voucher[]
     */
    public function getRefundedVouchers(): array
    {
        return $this->refundedVouchers;
    }

    /**
     * @param Voucher[] $vouchers
     */
    public function setNotRefundedVouchers(array $vouchers): self
    {
        $this->notRefundedVouchers = $vouchers;

        return $this;
    }

    /**
     * @return Voucher[]
     */
    public function getNotRefundedVouchers(): array
    {
        return $this->notRefundedVouchers;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->setRetoureTransactionId(isset($data['retoureTransactionId']) ? (int) $data['retoureTransactionId'] : (isset($data['retoure_transaction_id']) ? (int) $data['retoure_transaction_id'] : null));
        $self->setShopRetoureId($data['shopRetoureId'] ?? $data['shop_retoure_id'] ?? null);
        $self->setTotalCount(isset($data['totalCount']) ? (int) $data['totalCount'] : (isset($data['total_count']) ? (int) $data['total_count'] : null));
        $self->setCountStillOpen(isset($data['countStillOpen']) ? (int) $data['countStillOpen'] : (isset($data['count_still_open']) ? (int) $data['count_still_open'] : null));
        $self->setRetourePrice(isset($data['retourePrice']) ? (int) $data['retourePrice'] : (isset($data['retoure_price']) ? (int) $data['retoure_price'] : null));
        $self->setCreationDate($data['creationDate'] ?? $data['creation_date'] ?? null);
        $self->setSerialnumber($data['serialnumber'] ?? $data['serial_number'] ?? null);

        $refunded = $data['refundedVouchers'] ?? $data['refunded_vouchers'] ?? [];
        if (is_array($refunded)) {
            $items = [];
            foreach ($refunded as $it) {
                $items[] = Voucher::fromArray((array) $it);
            }
            $self->setRefundedVouchers($items);
        }

        $notRefunded = $data['notRefundedVouchers'] ?? $data['not_refunded_vouchers'] ?? [];
        if (is_array($notRefunded)) {
            $items = [];
            foreach ($notRefunded as $it) {
                $items[] = Voucher::fromArray((array) $it);
            }
            $self->setNotRefundedVouchers($items);
        }

        return $self;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'retoureTransactionId' => $this->retoureTransactionId,
            'shopRetoureId' => $this->shopRetoureId,
            'totalCount' => $this->totalCount,
            'countStillOpen' => $this->countStillOpen,
            'retourePrice' => $this->retourePrice,
            'creationDate' => $this->creationDate,
            'serialnumber' => $this->serialnumber,
            'refundedVouchers' => array_map(fn (Voucher $v) => $v->toArray(), $this->refundedVouchers),
            'notRefundedVouchers' => array_map(fn (Voucher $v) => $v->toArray(), $this->notRefundedVouchers),
        ];
    }
}
