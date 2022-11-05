<?php

namespace App\Console\Commands;

use App\Models\VKUser;
use App\Services\VK\Notification\NotificationMailingService;
use Illuminate\Console\Command;

class NotificationsSendingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vk:send-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send unread notification to user';

    public function handle(NotificationMailingService $notificationMailingService): void
    {
        VKUser::query()->chunk(100, static function($users) use ($notificationMailingService) {
            foreach ($users as $user) {
                $notificationMailingService->send($user);
                sleep(1);
            }
        });
    }
}
