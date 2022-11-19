<?php
namespace Deployer;

use Symfony\Component\Console\Input\InputOption;

require 'recipe/laravel.php';

option('ip-address', 'ip', InputOption::VALUE_OPTIONAL, 'IP ADDRESS', false);
option('user', 'user', InputOption::VALUE_OPTIONAL, 'User', false);
option('deploy_path', 'dp', InputOption::VALUE_OPTIONAL, 'Deploy path', false);

// Project name
set('application', 'VK Notificator');

// Project repository
set('repository', 'https://github.com/maffinca69/vk-notificator-backend');

// Hosts
host(input()->getOption('ip-address'))
->user(input()->getOption('user'))
->set('deploy_path', input()->getOption('deploy-path'));

task('artisan:cache:clear', function () {
run('{{bin/php}} {{release_path}}/artisan cache:clear');
})->desc('Execute artisan cache:clear');


task('artisan:config:cache', function() {})->setPrivate();
task('artisan:down', function() {})->setPrivate();
task('artisan:event:cache', function() {})->setPrivate();
task('artisan:event:clear', function() {})->setPrivate();
task('artisan:horizon:terminate', function() {})->setPrivate();
task('artisan:optimize', function() {})->setPrivate();
task('artisan:optimize:clear', function() {})->setPrivate();
task('artisan:route:cache', function() {})->setPrivate();
task('artisan:storage:link', function() {})->setPrivate();
task('artisan:up', function() {})->setPrivate();
task('artisan:view:cache', function() {})->setPrivate();
task('artisan:view:clear', function() {})->setPrivate();

// Tasks
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'artisan:cache:clear',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
]);