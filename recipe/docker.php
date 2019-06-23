<?php

namespace Deployer;

set('http_user', 'www-data');

task('artisan:migrate', function () {
    run('php {{release_path}}/artisan migrate');
});

task('npm:run', function () {
    run('cd {{release_path}}/frontend && npm install');
    run('cd {{release_path}}/frontend && npm run dev');
});