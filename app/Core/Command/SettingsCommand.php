<?php

namespace App\Core\Command;

use App\Core\DTO\UpdateDTO;
use App\Models\User;
use App\Services\Telegram\Client\DTO\MessageRequestDTO;
use App\Services\Telegram\Client\Exception\InvalidTelegramResponseException;
use App\Services\Telegram\MessageSendingService;
use App\Services\User\UserGettingService;
use Illuminate\Config\Repository as Config;

final class SettingsCommand extends AbstractCommand
{
    protected string $signature = '/settings';

    private const MESSAGE = '⚙️ Нажмите на кнопку ниже, чтобы открыть настройки';

    /**
     * @param MessageSendingService $messageSendingService
     * @param Config $config
     * @param UserGettingService $userGettingService
     */
    public function __construct(
        private MessageSendingService $messageSendingService,
        private Config $config,
        private UserGettingService $userGettingService
    ) {
    }

    /**
     * @param UpdateDTO $update
     * @throws InvalidTelegramResponseException
     */
    public function handle(UpdateDTO $update): void
    {
        $chatId = $update->getChatId();
        $from = $update->getMessage()->getFrom();
        /** @var User $user */
        $user = $this->userGettingService->getByUuid($from->getId());

        $message = new MessageRequestDTO($chatId);
        $message->setText(self::MESSAGE);
        $message->setReplyMarkup([
            'inline_keyboard' => [
                [
                    [
                        'text' => 'Открыть настройки',
                        'web_app' => [
                            'url' => $this->getSettingsUrl($user)
                        ]
                    ]
                ]
            ]
        ]);

        $this->messageSendingService->send($message);
    }

    /**
     * @param User $user
     * @return string
     */
    private function getSettingsUrl(User $user): string
    {
        $botConfig = $this->config->get('bot');

        $queryParams = [
            'uuid' => $user->getUuid()
        ];
        $query = http_build_query($queryParams);

        return $botConfig['settings_url'] . '?' . $query;
    }
}
