<?php

namespace App\Http\Request\FormRequest\API;

use Anik\Form\FormRequest;

class SettingsUpdatingRequest extends FormRequest
{
    protected function rules(): array
    {
        return [
            'uuid' => ['required', 'integer', 'exists:user,uuid'],
            'settings' => ['required', 'array'],
            'settings.*' => ['required'],
        ];
    }

    /**
     * @return int
     */
    public function getUuid(): int
    {
        return $this->get('uuid');
    }

    /**
     * @return array
     */
    public function getSettings(): array
    {
        return $this->get('settings', []);
    }
}
