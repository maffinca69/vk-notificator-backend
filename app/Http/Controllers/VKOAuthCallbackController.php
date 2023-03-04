<?php

namespace App\Http\Controllers;

use App\Http\Request\FormRequest\VKOAuthCallbackRequest;
use App\Infrastructure\Config\ConfigService;
use App\Infrastructure\Telegram\Client\Exception\TelegramHttpClientException;
use App\Services\Telegram\ProfileUrlGettingService;
use App\Services\VK\OAuth\VKOauthCallbackService;
use Laravel\Lumen\Routing\Controller;

class VKOAuthCallbackController extends Controller
{
    /**
     * @param VKOAuthCallbackRequest $request
     * @param VKOauthCallbackService $VKOauthCallbackService
     * @param ProfileUrlGettingService $profileUrlGettingService
     * @param ConfigService $configService
     * @return array
     * @throws TelegramHttpClientException
     */
    public function callback(
        VKOAuthCallbackRequest $request,
        VKOauthCallbackService $VKOauthCallbackService,
        ProfileUrlGettingService $profileUrlGettingService,
        ConfigService $configService
    ): array {
        $params = $request->all();
        $VKOauthCallbackService->process($params);

        $botConfig = $configService->get('bot');
        $redirectUrl = $profileUrlGettingService->get($botConfig['username']);

        return [
            'redirect_uri' => $redirectUrl
        ];
    }
}
