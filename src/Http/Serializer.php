<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Http;

/**
 * Simple serializer that converts DTOs (objects with toArray()) or arrays
 * into Guzzle request options (json, form_params or body).
 */
final class Serializer
{
    /**
     * Convert a DTO/array/scalar into Guzzle request options.
     *
     * - If $body is an object with toArray(): uses that.
     * - If $body is an array: uses that as-is.
     * - If $body is scalar/string: sends as raw body.
     *
     * The $headers parameter is inspected for Content-Type:
     * - If Content-Type contains "application/x-www-form-urlencoded" -> form_params
     * - Otherwise -> json (for arrays/objects). Scalars go into 'body'.
     *
     * @param array<string,string> $headers
     *
     * @return array<string,mixed> Guzzle request options to be merged into request()
     */
    public static function toRequestOptions(mixed $body, array $headers = []): array
    {
        if ($body === null) {
            return [];
        }

        // scalars / strings: raw body
        if (is_scalar($body)) {
            return ['body' => (string) $body];
        }

        // If it's an object with toArray(), use that
        if (is_object($body) && method_exists($body, 'toArray')) {
            $data = $body->toArray();
        } elseif (is_array($body)) {
            $data = $body;
        } else {
            // Fallback: try json encode the object
            try {
                $json = json_encode($body, JSON_THROW_ON_ERROR);

                return ['body' => $json];
            } catch (\Throwable) {
                return ['body' => (string) $body];
            }
        }

        // Determine if caller requested form params
        $contentType = strtolower($headers['Content-Type'] ?? $headers['content-type'] ?? '');
        if (str_contains($contentType, 'application/x-www-form-urlencoded')) {
            return ['form_params' => self::normalizeArray($data)];
        }

        // Default: JSON body
        return ['json' => self::normalizeArray($data)];
    }

    /**
     * Ensure arrays are serializable (convert nested DTOs that implement toArray()).
     */
    private static function normalizeArray(mixed $data): mixed
    {
        if (is_array($data)) {
            $result = [];
            foreach ($data as $k => $v) {
                $result[$k] = self::normalizeArray($v);
            }

            return $result;
        }

        if (is_object($data) && method_exists($data, 'toArray')) {
            return self::normalizeArray($data->toArray());
        }

        // scalar / null / other objects
        return $data;
    }
}
