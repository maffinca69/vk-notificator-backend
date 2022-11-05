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
            'uuid' => ['required', 'integer', 'exists:user,uuid']
        ];
    }

    /**
     * @return int
     */
    public function getUuid(): int
    {
        return $this->get('uuid');
    }
}
