<?php

namespace App\Http\Controllers;

use App\Http\Request\FormRequest\VKOAuthCallbackRequest;
use App\Infrastructure\Config\ConfigService;
use App\Services\Telegram\Client\Exception\InvalidTelegramResponseException;
use App\Services\Telegram\ProfileUrlCreatingService;
use App\Services\VK\OAuth\VKOauthCallbackService;
use Laravel\Lumen\Routing\Controller;

class VKOAuthCallbackController extends Controller
{
    /**
     * @param VKOAuthCallbackRequest $request
     * @param VKOauthCallbackService $VKOauthCallbackService
     * @param ProfileUrlCreatingService $profileUrlCreatingService
     * @param ConfigService $configService
     * @return array
     * @throws InvalidTelegramResponseException
     */
    public function callback(
        VKOAuthCallbackRequest $request,
        VKOauthCallbackService $VKOauthCallbackService,
        ProfileUrlCreatingService $profileUrlCreatingService,
        ConfigService $configService
    ): array {
        $params = $request->all();
        $VKOauthCallbackService->process($params);

        $botConfig = $configService->get('bot');
        $redirectUrl = $profileUrlCreatingService->create($botConfig['username']);

        return [
            'redirect_uri' => $redirectUrl
        ];
    }
}
