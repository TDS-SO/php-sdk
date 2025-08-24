<?php

declare(strict_types=1);

namespace TdsSo\Sdk\Services;

use TdsSo\Sdk\Contracts\HttpClientInterface;

abstract class AbstractService
{
    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }
}
