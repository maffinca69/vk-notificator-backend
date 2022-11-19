<?php

namespace Deployer;

use Symfony\Component\Console\Input\InputOption;

require 'recipe/laravel.php';

option('ip-address', 'ip', InputOption::VALUE_OPTIONAL, 'Adds the cache tables to the backup command.', false);
option('user', 'user', InputOption::VALUE_OPTIONAL, 'Adds the cache tables to the backup command.', false);
option('path', 'dp', InputOption::VALUE_OPTIONAL, 'Adds the cache tables to the backup command.', false);

// Config

set('repository', 'https://github.com/maffinca69/vk-notificator-backend');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

task('deploy:prepare', function () {
    host(input()->getOption('ip-address'))
        ->set('remote_user', input()->getOption('user'))
        ->set('deploy_path', input()->getOption('path'));
});



// Hooks
before('deploy', 'deploy:prepare');
after('deploy:failed', 'deploy:unlock');
