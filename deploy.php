<?php

namespace Deployer;

require 'recipe/symfony4.php';

set('application', 'groomingchimps:web');
set('repository', 'git@bitbucket.org:groomingchimps/web.git');
set('git_tty', false);
set('keep_releases', 2);
set('shared_dirs', ['var/log', 'var/sessions', 'vendor']);
set('writable_dirs', ['var']);
set('composer_action', 'install');
set('composer_options', '{{composer_action}} --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader --no-suggest');

host('groomingchimps.titomiguelcosta.com')
    ->user('ubuntu')
    ->stage('prod')
    ->set('deploy_path', '/mnt/websites/groomingchimps/web')
    ->set('shared_files', ['.env.prod.local'])
    ->set('http_user', 'ubuntu')
    ->set('writable_mode', 'acl')
    ->set('branch', 'master')
    ->set('env', ['APP_ENV' => 'prod']);

task('yarn:install', function () {
    run('cd {{release_path}} && npm install --loglevel=error');
    run('cd {{release_path}} && yarn encore production');
}, [
    'timeout' => 3600
]);

after('deploy:update_code', 'yarn:install');

after('deploy:failed', 'deploy:unlock');
