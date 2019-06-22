<?php

namespace Deployer;

task('artisan:migrate', function () {
    run('php {{release_path}}/artisan migrate');
});

task('npm:run', function () {
    run('cd {{release_path}}/frontend && npm install');
    run('cp {{release_path}}/frontend/resources/js/.env.example.json {{release_path}}/frontend/resources/js/.env.json');
    run('cd {{release_path}}/frontend && npm run dev');
});