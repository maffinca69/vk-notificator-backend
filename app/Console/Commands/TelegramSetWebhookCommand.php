<?php

namespace App\Console\Commands;

use App\Infrastructure\Telegram\Client\HttpClient;
use App\Infrastructure\Telegram\Client\Request\SetWebhookRequest;
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
    protected $description = 'Set webhook url';

    public function handle(HttpClient $client): void
    {
        $url = $this->ask('Enter webhook url');
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $this->error('Invalid url!');
            return;
        }

        $request = new SetWebhookRequest($url);
        $response = $client->sendRequest($request);

        $this->info($response->getRawResponse());
    }
}
