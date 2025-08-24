<?php

declare(strict_types=1);

namespace TdsSo\Sdk\Client;

use TdsSo\Sdk\Contracts\ConfigurationInterface;
use TdsSo\Sdk\Exceptions\InvalidConfigurationException;

class Configuration implements ConfigurationInterface
{
    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $baseUri;

    /**
     * @var int
     */
    private $timeout;

    /**
     * @var bool
     */
    private $debug;

    /**
     * @param string $token   API token
     * @param string $baseUri Base URI
     * @param int    $timeout Request timeout in seconds
     * @param bool   $debug   Debug mode
     */
    public function __construct(
        string $token,
        string $baseUri = 'https://dashboard.tds.so/api/v2',
        int $timeout = 30,
        bool $debug = false
    ) {
        $this->validateToken($token);

        $this->token = $token;
        $this->baseUri = rtrim($baseUri, '/');
        $this->timeout = $timeout;
        $this->debug = $debug;
    }

    /**
     * {@inheritdoc}
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * {@inheritdoc}
     */
    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    /**
     * {@inheritdoc}
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * {@inheritdoc}
     */
    public function isDebug(): bool
    {
        return $this->debug;
    }

    /**
     * Validate API token.
     *
     * @throws InvalidConfigurationException
     */
    private function validateToken(string $token): void
    {
        $length = \strlen($token);

        if ($length < 63 || $length > 65) {
            throw new InvalidConfigurationException(
                'API token must be between 63 and 65 characters long'
            );
        }
    }
}
