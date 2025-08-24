<?php

declare(strict_types=1);

namespace TdsSo\Sdk;

use TdsSo\Sdk\Client\Configuration;
use TdsSo\Sdk\Contracts\ConfigurationInterface;
use TdsSo\Sdk\Contracts\HttpClientInterface;
use TdsSo\Sdk\Http\GuzzleHttpClient;
use TdsSo\Sdk\Services\CreateService;
use TdsSo\Sdk\Services\DomainsService;
use TdsSo\Sdk\Services\LinksService;
use TdsSo\Sdk\Services\TemplatesService;

/**
 * TDS.SO API Client.
 *
 * @property LinksService     $links
 * @property DomainsService   $domains
 * @property TemplatesService $templates
 * @property CreateService    $create
 */
class TdsSoClient
{
    /**
     * @var ConfigurationInterface
     */
    private $config;

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var array
     */
    private $services = [];

    /**
     * @param string $token   API token
     * @param array  $options Client options
     */
    public function __construct(string $token, array $options = [])
    {
        $this->config = new Configuration(
            $token,
            $options['base_uri'] ?? 'https://dashboard.tds.so/api/v2',
            $options['timeout'] ?? 30,
            $options['debug'] ?? false
        );

        $this->httpClient = $options['http_client'] ?? new GuzzleHttpClient($this->config);
    }

    /**
     * @return object
     *
     * @throws \BadMethodCallException
     */
    public function __get(string $name)
    {
        $method = $name;

        if (method_exists($this, $method)) {
            return $this->{$method}();
        }

        throw new \BadMethodCallException("Service '{$name}' does not exist");
    }

    public static function createWithConfig(
        ConfigurationInterface $config,
        ?HttpClientInterface $httpClient = null
    ): self {
        $instance = new self($config->getToken());
        $instance->config = $config;
        $instance->httpClient = $httpClient ?? new GuzzleHttpClient($config);

        return $instance;
    }

    public function links(): LinksService
    {
        return $this->getService(LinksService::class);
    }

    public function domains(): DomainsService
    {
        return $this->getService(DomainsService::class);
    }

    public function templates(): TemplatesService
    {
        return $this->getService(TemplatesService::class);
    }

    public function create(): CreateService
    {
        return $this->getService(CreateService::class);
    }

    public function getConfig(): ConfigurationInterface
    {
        return $this->config;
    }

    public function getHttpClient(): HttpClientInterface
    {
        return $this->httpClient;
    }

    /**
     * @return object
     */
    private function getService(string $class)
    {
        if (!isset($this->services[$class])) {
            $this->services[$class] = new $class($this->httpClient);
        }

        return $this->services[$class];
    }
}
