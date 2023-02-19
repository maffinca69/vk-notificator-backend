<?php

namespace Tests\Infrastructure\Config;

use App\Infrastructure\Config\ConfigService;
use Tests\TestCase;

class ConfigServiceTest extends TestCase
{
    private ConfigService $configService;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->configService = app()->make(ConfigService::class);
    }

    public function testGetBotConfig()
    {
        $config = $this->configService->get('bot');
        $this->assertIsArray($config);
        $this->assertNotEmpty($config);
        $this->assertArrayHasKey('token', $config);
    }

    public function testGetVKAppConfig()
    {
        $config = $this->configService->get('vk-app');
        $this->assertIsArray($config);
        $this->assertNotEmpty($config);
        $this->assertArrayHasKey('app_id', $config);
        $this->assertArrayHasKey('redirect_uri', $config);
    }
}
