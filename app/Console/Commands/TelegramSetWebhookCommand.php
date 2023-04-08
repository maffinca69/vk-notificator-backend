<?php

namespace App\Console\Commands;

use App\Infrastructure\Telegram\Client\HttpClient;
use App\Infrastructure\Telegram\Client\Request\SetWebhookRequest;
use App\Models\VKUser;
use App\Services\VK\Notification\NotificationMailingService;
use Illuminate\Console\Command;

class TelegramSetWebhookCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:set-webhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send unread notification to user';

    public function handle(HttpClient $client): void
    {
        $url = $this->ask('Enter webhook url');

        $request = new SetWebhookRequest($url);
        $response = $client->sendRequest($request);

        $this->info($response->getRawResponse());
    }
}
