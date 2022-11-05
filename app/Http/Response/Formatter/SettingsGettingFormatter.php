<?php

namespace App\Http\Response\Formatter;

use Illuminate\Translation\Translator;

class SettingsGettingFormatter
{
    public const FILENAME = 'setting';

    public function __construct(protected Translator $translator)
    {
    }

    /**
     * @param array $settings
     * @return array
     */
    public function format(array $settings): array
    {
        $result = [];
        foreach ($settings as $key => $value) {
            $translatedSetting = $this->translator->get(self::FILENAME . '.' . $key);

            $result[] = [
                'key' => $key,
                'value' => $value,
                'title' => $translatedSetting['title'] ?? null,
                'description' => $translatedSetting['description'] ?? null,
            ];
        }

        return $result;
    }
}
