<?php

namespace Deployer;

require 'recipe/symfony4.php';

set('application', 'gobie:web');
set('repository', 'git@github.com:titomiguelcosta/gobie-website.git');
set('git_tty', false);
set('keep_releases', 2);
set('shared_dirs', ['var/log', 'var/sessions', 'vendor']);
set('writable_dirs', ['var/log', 'var/cache', 'var/sessions']);
set('composer_action', 'install');
set('composer_options', '{{composer_action}} --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader');

host('gobie.titomiguelcosta.com')
    ->user('ubuntu')
    ->stage('dev')
    ->set('deploy_path', '/mnt/websites/gobie/web')
    ->set('shared_files', ['.env.local'])
    ->set('http_user', 'www-data')
    ->set('writable_mode', 'acl')
    ->set('branch', 'master')
    ->set('env', [
        'APP_ENV' => 'prod', 
        'PATH' => '/usr/local/bin:/usr/bin:/bin:/mnt/websites/.ubuntu/.nvm/versions/node/v20.0.0/bin',
        'NODE_OPTIONS' => '--openssl-legacy-provider',
    ]);

task('yarn:install', function () {
    run('cd {{release_path}} && yarn install');
    run('cd {{release_path}} && yarn encore production');
}, [
    'timeout' => 3600
]);

after('deploy:shared', 'yarn:install');

after('deploy:failed', 'deploy:unlock');
