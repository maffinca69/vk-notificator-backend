<?php

namespace App\Services\Telegram\Formatter;

class HyperLinkFormatter
{
    /**
     * @param string $url
     * @param string $text
     * @return string
     */
    public function format(string $url, string $text): string
    {
        return sprintf('[%s](%s)', $text, $url);
    }
}
