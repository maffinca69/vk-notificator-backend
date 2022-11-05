<?php

namespace App\Http\Request\FormRequest\API;

use Anik\Form\FormRequest;

class SettingsUpdatingRequest extends FormRequest
{
    protected function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:user,id'],
            'settings' => 'array',
            'settings.*' => ['required', 'string'],
        ];
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->get('user_id');
    }

    /**
     * @return array
     */
    public function getSettings(): array
    {
        return $this->get('settings', []);
    }
}
