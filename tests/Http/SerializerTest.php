<?php

declare(strict_types=1);

namespace Tests\Http;

use Maxs94\Internetmarke\Http\Serializer;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class SerializerTest extends TestCase
{
    public function testToRequestOptionsWithArrayReturnsJsonByDefault(): void
    {
        $body = ['foo' => 'bar', 'nested' => ['a' => 1]];

        $options = Serializer::toRequestOptions($body, []);

        $this->assertArrayHasKey('json', $options);
        $this->assertSame($body, $options['json']);
    }

    public function testToRequestOptionsWithDtoUsesToArrayAndFormParamsWhenContentTypeForm(): void
    {
        $dto = new class {
            public function toArray(): array
            {
                return ['grant_type' => 'client_credentials', 'client_id' => 'cid'];
            }
        };

        $headers = ['Content-Type' => 'application/x-www-form-urlencoded'];

        $options = Serializer::toRequestOptions($dto, $headers);

        $this->assertArrayHasKey('form_params', $options);
        $this->assertSame(['grant_type' => 'client_credentials', 'client_id' => 'cid'], $options['form_params']);
    }

    public function testToRequestOptionsWithScalarReturnsBody(): void
    {
        $body = 'raw text';

        $options = Serializer::toRequestOptions($body, []);

        $this->assertArrayHasKey('body', $options);
        $this->assertSame('raw text', $options['body']);
    }
}
