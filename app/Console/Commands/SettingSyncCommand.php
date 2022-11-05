<?php

namespace App\Console\Commands;


use App\Models\User;
use App\Services\Internal\DiffArray;
use App\Services\Setting\SettingsDictionary;
use Illuminate\Console\Command;

class SettingSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync settings with user settings';

    public function handle(): void
    {
        $this->info('Start...');

        $settings = SettingsDictionary::getFields();
        $context = $this;

        User::query()->chunk(100, static function ($users) use ($settings, $context) {
            /** @var User $user */
            foreach ($users as $user) {
                $userSettings = $user->getSettings() ?? [];
                $newSettings = DiffArray::diffWithoutNewKeys($settings, $userSettings);
                $user->update(['settings' => $newSettings]);
                $context->info("User settings [{$user->getFullName()}] synced");
            }
        });

        $this->info('Finish!');
    }
}
