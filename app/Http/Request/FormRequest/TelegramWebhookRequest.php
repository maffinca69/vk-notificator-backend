<?php

namespace App\Http\Request\FormRequest;

use Anik\Form\FormRequest;

final class TelegramWebhookRequest extends FormRequest
{
    protected function rules(): array
    {
        return [];
    }
}
