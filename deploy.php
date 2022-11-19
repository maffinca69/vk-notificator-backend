<?php
namespace Deployer;

use Symfony\Component\Console\Input\InputOption;

require 'recipe/laravel.php';

option('ip-address', 'ip', InputOption::VALUE_OPTIONAL, 'Adds the cache tables to the backup command.', false);
option('user', 'user', InputOption::VALUE_OPTIONAL, 'Adds the cache tables to the backup command.', false);
option('deploy-path', 'path', InputOption::VALUE_OPTIONAL, 'Adds the cache tables to the backup command.', false);

// Config

set('repository', 'https://github.com/maffinca69/vk-notificator-backend');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host(input()->getOption('ip-address'))
    ->set('remote_user', input()->getOption('user'))
    ->set('deploy_path', input()->getOption('deploy-path'));

// Hooks

after('deploy:failed', 'deploy:unlock');
