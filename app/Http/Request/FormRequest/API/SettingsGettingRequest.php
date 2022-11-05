<?php

namespace App\Http\Request\FormRequest\API;

use Anik\Form\FormRequest;

class SettingsGettingRequest extends FormRequest
{
    /**
     * @return \string[][]
     */
    protected function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:user,id']
        ];
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->get('user_id');
    }
}
