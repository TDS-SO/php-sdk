<?php

declare(strict_types=1);

namespace TdsSo\Sdk\Tests\Unit;

use TdsSo\Sdk\Services\CreateService;
use TdsSo\Sdk\Services\DomainsService;
use TdsSo\Sdk\Services\LinksService;
use TdsSo\Sdk\Services\TemplatesService;
use TdsSo\Sdk\TdsSoClient;
use TdsSo\Sdk\Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class TdsSoClientTest extends TestCase
{
    private $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new TdsSoClient(self::TEST_API_TOKEN);
    }

    public function testClientInstantiation(): void
    {
        self::assertInstanceOf(TdsSoClient::class, $this->client);
    }

    public function testLinksServiceAccess(): void
    {
        $service = $this->client->links();
        self::assertInstanceOf(LinksService::class, $service);

        // Test that the same instance is returned
        self::assertSame($service, $this->client->links());
    }

    public function testDomainsServiceAccess(): void
    {
        $service = $this->client->domains();
        self::assertInstanceOf(DomainsService::class, $service);

        // Test that the same instance is returned
        self::assertSame($service, $this->client->domains());
    }

    public function testTemplatesServiceAccess(): void
    {
        $service = $this->client->templates();
        self::assertInstanceOf(TemplatesService::class, $service);

        // Test that the same instance is returned
        self::assertSame($service, $this->client->templates());
    }

    public function testCreateServiceAccess(): void
    {
        $service = $this->client->create();
        self::assertInstanceOf(CreateService::class, $service);

        // Test that the same instance is returned
        self::assertSame($service, $this->client->create());
    }

    public function testClientWithCustomOptions(): void
    {
        $client = new TdsSoClient(self::TEST_API_TOKEN, [
            'base_uri' => 'https://custom.api.url',
            'timeout'  => 60,
            'debug'    => true,
        ]);

        self::assertInstanceOf(TdsSoClient::class, $client);
    }

    public function testMagicGetMethod(): void
    {
        $links = $this->client->links;
        self::assertInstanceOf(LinksService::class, $links);

        $domains = $this->client->domains;
        self::assertInstanceOf(DomainsService::class, $domains);

        $templates = $this->client->templates;
        self::assertInstanceOf(TemplatesService::class, $templates);

        $create = $this->client->create;
        self::assertInstanceOf(CreateService::class, $create);
    }

    /**
     * @expectedException \Error
     */
    public function testInvalidServiceAccess(): void
    {
        $this->expectException(\Error::class);
        $this->client->invalidService();
    }
}
