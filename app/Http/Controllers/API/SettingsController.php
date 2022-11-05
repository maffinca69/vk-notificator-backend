<?php

namespace App\Http\Controllers\API;

use App\Http\Request\FormRequest\API\SettingsGettingRequest;
use App\Http\Request\FormRequest\API\SettingsUpdatingRequest;
use App\Http\Response\Formatter\SettingsGettingFormatter;
use App\Models\User;
use App\Services\Setting\Exception\InvalidSettingTypeException;
use App\Services\Setting\UserSettingsGettingService;
use App\Services\Setting\UserSettingsUpdatingService;
use App\Services\User\UserGettingService;
use Laravel\Lumen\Routing\Controller;
use Psr\SimpleCache\InvalidArgumentException;

class SettingsController extends Controller
{
    /**
     * @param SettingsGettingRequest $request
     * @param UserSettingsGettingService $userSettingsGettingService
     * @param UserGettingService $userGettingService
     * @param SettingsGettingFormatter $settingsGettingFormatter
     * @return array
     * @throws InvalidArgumentException
     */
    public function get(
        SettingsGettingRequest $request,
        UserSettingsGettingService $userSettingsGettingService,
        UserGettingService $userGettingService,
        SettingsGettingFormatter $settingsGettingFormatter
    ): array {
        /** @var User $user */
        $user = $userGettingService->getByUuid($request->getUuid());

        $settings = $userSettingsGettingService->get($user);
        return $settingsGettingFormatter->format($settings);
    }

    /**
     * @param SettingsUpdatingRequest $request
     * @param UserSettingsUpdatingService $settingsUpdatingService
     * @param UserGettingService $userGettingService
     * @return array
     * @throws InvalidArgumentException
     * @throws InvalidSettingTypeException
     */
    public function update(
        SettingsUpdatingRequest $request,
        UserSettingsUpdatingService $settingsUpdatingService,
        UserGettingService $userGettingService
    ): array {
        $id = $request->getUuid();
        $settings = $request->getSettings();

        /** @var User $user */
        $user = $userGettingService->getByUuid($id);
        return [
            'success' => $settingsUpdatingService->update($user, $settings)
        ];
    }
}
