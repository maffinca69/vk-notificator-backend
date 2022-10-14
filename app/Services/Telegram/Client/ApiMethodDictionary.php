<?php

namespace App\Services\Telegram\Client;

final class ApiMethodDictionary
{
    /** @var string Отправка сообщения */
    public const SEND_MESSAGE_METHOD = 'sendMessage';

    /** @var string Отправка стикера */
    public const SEND_STICKER_METHOD = 'sendSticker';

    /** @var string Отправка выполняемого действия */
    public const SEND_ACTION_METHOD = 'sendChatAction';

    /** @var string Отправка фото */
    public const SEND_PHOTO_METHOD = 'sendPhoto';

    /** @var string Отправка медиа */
    public const SEND_MEDIA_GROUP_METHOD = 'sendMediaGroup';

    /** @var string Ответ на колбэк с клавиатуры */
    public const ANSWER_CALLBACK_QUERY_METHOD = 'answerCallbackQuery';

    /** @var string Пин сообщения в чате */
    public const PIN_CHAT_MESSAGE_METHOD = 'pinChatMessage';

    /** @var string Пересылка сообщения */
    public const FORWARD_MESSAGE_METHOD = 'forwardMessage';

    /** @var string Удаление сообщения */
    public const DELETE_MESSAGE_METHOD = 'deleteMessage';
}
