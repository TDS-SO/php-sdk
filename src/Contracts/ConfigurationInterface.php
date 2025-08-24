<?php

declare(strict_types=1);

namespace TdsSo\Sdk\Contracts;

interface ConfigurationInterface
{
    /**
     * Get API token.
     */
    public function getToken(): string;

    /**
     * Get base URI.
     */
    public function getBaseUri(): string;

    /**
     * Get request timeout.
     */
    public function getTimeout(): int;

    /**
     * Check if debug mode is enabled.
     */
    public function isDebug(): bool;
}
