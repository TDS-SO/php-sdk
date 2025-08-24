<?php

declare(strict_types=1);

namespace TdsSo\Sdk\Tests;

use Mockery\MockInterface;
use PHPUnit\Framework\TestCase as BaseTestCase;
use TdsSo\Sdk\Contracts\ConfigurationInterface;
use TdsSo\Sdk\Contracts\HttpClientInterface;

abstract class TestCase extends BaseTestCase
{
    /**
     * API test token for testing.
     */
    protected const TEST_API_TOKEN = 'test_token_64_characters_long_for_testing_purposes_only_not_real';

    /**
     * Test base URI.
     */
    protected const TEST_BASE_URI = 'https://dashboard.tds.so/api/v2';

    protected function tearDown(): void
    {
        parent::tearDown();

        if (class_exists(\Mockery::class)) {
            \Mockery::close();
        }
    }

    /**
     * Get fixture data from JSON file.
     */
    protected function getFixture(string $filename): array
    {
        $path = __DIR__ . '/Fixtures/' . $filename;

        if (!file_exists($path)) {
            throw new \RuntimeException("Fixture file not found: {$path}");
        }

        $content = file_get_contents($path);

        if ($content === false) {
            throw new \RuntimeException("Could not read fixture file: {$path}");
        }

        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException("Invalid JSON in fixture file: {$path}");
        }

        return $data;
    }

    /**
     * Assert that array has specific keys.
     */
    protected function assertArrayHasKeys(array $keys, array $array): void
    {
        foreach ($keys as $key) {
            self::assertArrayHasKey($key, $array, "Array missing key: {$key}");
        }
    }

    /**
     * Create mock for HTTP client interface.
     */
    protected function createHttpClientMock(): MockInterface
    {
        return \Mockery::mock(HttpClientInterface::class);
    }

    /**
     * Create mock for configuration interface.
     */
    protected function createConfigurationMock(): MockInterface
    {
        return \Mockery::mock(ConfigurationInterface::class);
    }
}
