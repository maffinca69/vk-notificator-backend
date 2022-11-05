<?php

namespace App\Http\Controllers\API;

use App\Http\Request\FormRequest\API\SettingsGettingRequest;
use App\Http\Request\FormRequest\API\SettingsUpdatingRequest;
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
     * @return array
     * @throws InvalidArgumentException
     */
    public function get(
        SettingsGettingRequest $request,
        UserSettingsGettingService $userSettingsGettingService,
        UserGettingService $userGettingService
    ): array {
        /** @var User $user */
        $user = $userGettingService->getById($request->getUserId());

        return $userSettingsGettingService->get($user);
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
        $id = $request->getUserId();
        $settings = $request->getSettings();

        /** @var User $user */
        $user = $userGettingService->getById($id);
        return [
            'success' => $settingsUpdatingService->update($user, $settings)
        ];
    }
}
