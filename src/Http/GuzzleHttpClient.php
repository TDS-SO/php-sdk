<?php

declare(strict_types=1);

namespace TdsSo\Sdk\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use TdsSo\Sdk\Contracts\ConfigurationInterface;
use TdsSo\Sdk\Contracts\HttpClientInterface;
use TdsSo\Sdk\Exceptions\ApiException;

class GuzzleHttpClient implements HttpClientInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var ConfigurationInterface
     */
    private $config;

    public function __construct(ConfigurationInterface $config)
    {
        $this->config = $config;
        $this->client = new Client([
            'base_uri'    => $config->getBaseUri() . '/',
            'timeout'     => $config->getTimeout(),
            'http_errors' => false,
            'verify'      => true,
            'headers'     => [
                'Accept'     => 'application/json',
                'User-Agent' => 'TDS.SO-SDK/1.0.0 PHP/' . PHP_VERSION,
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $endpoint, array $params = []): array
    {
        $params['token'] = $this->config->getToken();

        return $this->request('GET', $endpoint, [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function post(string $endpoint, array $data = []): array
    {
        $data['token'] = $this->config->getToken();

        return $this->request('POST', $endpoint, [
            RequestOptions::FORM_PARAMS => $data,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function put(string $endpoint, array $data = []): array
    {
        $data['token'] = $this->config->getToken();

        return $this->request('PUT', $endpoint, [
            RequestOptions::FORM_PARAMS => $data,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $endpoint, array $params = []): array
    {
        $params['token'] = $this->config->getToken();

        return $this->request('DELETE', $endpoint, [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * Send HTTP request.
     *
     * @throws ApiException
     */
    private function request(string $method, string $endpoint, array $options = []): array
    {
        try {
            if ($this->config->isDebug()) {
                $options['debug'] = true;
            }

            $response = $this->client->request($method, $endpoint, $options);

            $body = (string) $response->getBody();
            $data = json_decode($body, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new ApiException(
                    'Invalid JSON response: ' . json_last_error_msg(),
                    $response->getStatusCode()
                );
            }

            if (isset($data['error'])) {
                throw ApiException::fromResponse($data, $response->getStatusCode());
            }

            return $data;
        } catch (GuzzleException $e) {
            throw new ApiException(
                'HTTP request failed: ' . $e->getMessage(),
                $e->getCode(),
                null,
                [],
                $e
            );
        }
    }
}
