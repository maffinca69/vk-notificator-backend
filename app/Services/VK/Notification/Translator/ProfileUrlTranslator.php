<?php

namespace App\Services\VK\Notification\Translator;

use App\Services\VK\Notification\Formatter\Link\ProfileLinkFormatter;

final class ProfileUrlTranslator
{
    public const PROFILE_URL_REGEXP = '[id(\d*)\|([а-яА-Яa-zA-ZЁёЙй]*)]u';

    /**
     * Search vk-formatted profile link and converting to markdown
     * Example: [id123|Vladimir] -> [Vladimir](https://vk.com/id123)
     *
     * @param string $text
     * @return string
     */
    public function translate(string $text): string
    {
        preg_match_all(self::PROFILE_URL_REGEXP, $text, $matches);

        $groups = [];
        foreach ($matches[0] as $index => $match) {
            $id = $matches[1][$index];
            $name = $matches[2][$index];

            $match = sprintf('[%s]', $match);
            $groups[$match]['id'] = $id;
            $groups[$match]['name'] = $name;
        }

        $links = [];
        foreach ($groups as $match => $group) {
            $url = ProfileLinkFormatter::BASE_PROFILE_URL . $group['id'];

            $links[$match] = sprintf('[%s](%s)', $group['name'], $url);
        }

        return str_replace(array_keys($links), array_values($links), $text);
    }
}
