<?php

declare(strict_types=1);

namespace TdsSo\Sdk\Contracts;

interface HttpClientInterface
{
    /**
     * Send GET request.
     */
    public function get(string $endpoint, array $params = []): array;

    /**
     * Send POST request.
     */
    public function post(string $endpoint, array $data = []): array;

    /**
     * Send PUT request.
     */
    public function put(string $endpoint, array $data = []): array;

    /**
     * Send DELETE request.
     */
    public function delete(string $endpoint, array $params = []): array;
}
