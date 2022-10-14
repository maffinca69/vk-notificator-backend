<?php

namespace App\Http\Controllers;

use App\Http\Request\FormRequest\VKOAuthCallbackRequest;
use App\Services\Telegram\UrlGenerator;
use App\Services\VK\OAuth\VKOauthCallbackService;
use Illuminate\Config\Repository as Config;
use Laravel\Lumen\Routing\Controller;

class VKOAuthCallbackController extends Controller
{
    /**
     * @param VKOAuthCallbackRequest $request
     * @param VKOauthCallbackService $VKOauthCallbackService
     * @param UrlGenerator $urlGenerator
     * @param Config $config
     * @return array
     */
    public function callback(
        VKOAuthCallbackRequest $request,
        VKOauthCallbackService $VKOauthCallbackService,
        UrlGenerator $urlGenerator,
        Config $config
    ): array {
        $params = $request->all();
        $VKOauthCallbackService->process($params);

        $botConfig = $config->get('bot');
        $redirectUrl = $urlGenerator->generate($botConfig['username']);

        return [
            'redirect_uri' => $redirectUrl
        ];
    }
}
