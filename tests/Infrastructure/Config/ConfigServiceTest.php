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
        $this->assertNotEmpty($config['token']);
    }

    public function testGetVKAppConfig()
    {
        $config = $this->configService->get('vk-app');
        $this->assertIsArray($config);
        $this->assertNotEmpty($config);
        $this->assertNotEmpty($config['app_id']);
        $this->assertNotEmpty($config['redirect_uri']);
    }
}
