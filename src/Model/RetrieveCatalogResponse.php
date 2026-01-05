<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class RetrieveCatalogResponse
{
    private ?PrivateCatalog $privateCatalog = null;
    private ?PublicCatalog $publicCatalog = null;

    /** @var PageFormat[] */
    private array $pageFormats = [];

    private ?ContractProducts $contractProducts = null;

    public function setPrivateCatalog(?PrivateCatalog $cat): self
    {
        $this->privateCatalog = $cat;

        return $this;
    }

    public function getPrivateCatalog(): ?PrivateCatalog
    {
        return $this->privateCatalog;
    }

    public function setPublicCatalog(?PublicCatalog $cat): self
    {
        $this->publicCatalog = $cat;

        return $this;
    }

    public function getPublicCatalog(): ?PublicCatalog
    {
        return $this->publicCatalog;
    }

    /**
     * @param PageFormat[] $formats
     */
    public function setPageFormats(array $formats): self
    {
        $this->pageFormats = $formats;

        return $this;
    }

    /**
     * @return PageFormat[]
     */
    public function getPageFormats(): array
    {
        return $this->pageFormats;
    }

    public function setContractProducts(?ContractProducts $products): self
    {
        $this->contractProducts = $products;

        return $this;
    }

    public function getContractProducts(): ?ContractProducts
    {
        return $this->contractProducts;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        if (!empty($data['privateCatalog'])) {
            $self->setPrivateCatalog(PrivateCatalog::fromArray((array) $data['privateCatalog']));
        }
        if (!empty($data['publicCatalog'])) {
            $self->setPublicCatalog(PublicCatalog::fromArray((array) $data['publicCatalog']));
        }
        $formats = $data['pageFormats'] ?? $data['page_formats'] ?? [];
        if (is_array($formats)) {
            $list = [];
            foreach ($formats as $f) {
                $list[] = PageFormat::fromArray((array) $f);
            }
            $self->setPageFormats($list);
        }
        if (!empty($data['contractProducts'])) {
            $self->setContractProducts(ContractProducts::fromArray((array) $data['contractProducts']));
        }

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'privateCatalog' => $this->privateCatalog?->toArray(),
            'publicCatalog' => $this->publicCatalog?->toArray(),
            'pageFormats' => array_map(fn (PageFormat $p) => $p->toArray(), $this->pageFormats),
            'contractProducts' => $this->contractProducts?->toArray(),
        ];
    }
}
