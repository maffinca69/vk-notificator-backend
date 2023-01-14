<?php

namespace Tests\Services\VK\Notification\Translator;

use App\Services\VK\Notification\Translator\ProfileUrlTranslator;
use PHPUnit\Framework\TestCase;

class ProfileUrlTranslatorTest extends TestCase
{
    public function testCorrectVkLinkConverting(): void
    {
        /** @var ProfileUrlTranslator $profileUrlTranslator */
        $profileUrlTranslator = app()->make(ProfileUrlTranslator::class);

        $text = '[id123|Vladimir], hi!';

        $this->assertEquals($profileUrlTranslator->translate(''), '');
        $this->assertEquals($profileUrlTranslator->translate('hi'), 'hi');
        $this->assertEquals($profileUrlTranslator->translate($text), '[Vladimir](https://vk.com/id123), hi!');
    }

    public function testIncorrectVkLinkConverting(): void
    {
        /** @var ProfileUrlTranslator $profileUrlTranslator */
        $profileUrlTranslator = app()->make(ProfileUrlTranslator::class);

        $this->assertNotEquals($profileUrlTranslator->translate(''), '123');
        $this->assertNotEquals($profileUrlTranslator->translate('[123|Vladimir]'), '[Vladimir](https://vk.com/id123)');
    }
}
