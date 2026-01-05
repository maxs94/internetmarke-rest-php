<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Config;

final class ClientConfig
{
    public const DEFAULT_BASE_URI = 'https://api-eu.dhl.com/post/de/shipping/im/v1';

    private string $baseUri;

    public function __construct(?string $baseUri = null)
    {
        $this->baseUri = $baseUri ?? self::DEFAULT_BASE_URI;
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public static function fromString(string $baseUri): self
    {
        return new self($baseUri);
    }
}
