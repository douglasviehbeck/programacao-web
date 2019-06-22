<?php

namespace Deployer;

//task('artisan:config:cache:docker', function () {
//    $hostname = get('hostname');
//
//    if ($hostname == 'pweb.devel') {
//        run('cd ~/docker-compose && docker exec -i docker-compose_php_devel_1 php artisan config:clear');
//        run('cd ~/docker-compose && docker exec -i docker-compose_php_devel_1 php artisan config:cache');
//    } else {
//        run('cd ~/docker-compose && docker exec -i docker-compose_php_prod_1 php artisan config:clear');
//        run('cd ~/docker-compose && docker exec -i docker-compose_php_prod_1 php artisan config:cache');
//    }
//});

//task('artisan:route:cache:docker', function () {
//    $hostname = get('hostname');
//
//    if ($hostname == 'pweb.devel') {
//        run('cd ~/docker-compose && docker exec -i docker-compose_php_devel_1 php artisan route:cache');
//    } else {
//        run('cd ~/docker-compose && docker exec -i docker-compose_php_prod_1 php artisan route:cache');
//    }
//});

task('artisan:prepare:docker', function () {
    $hostname = get('hostname');

    if ($hostname == 'pweb.devel') {
        run('docker exec -i docker-compose_php_devel_1 php artisan config:cache');
        run('docker exec -i docker-compose_php_devel_1 php artisan route:cache');
        run('docker exec -i docker-compose_php_devel_1 composer dump-autoload');

        sleep(60);

        run('docker exec -i docker-compose_php_devel_1 php artisan migrate');
    } else {
        run('docker exec -i docker-compose_php_prod_1 php artisan config:cache');
        run('docker exec -i docker-compose_php_prod_1 php artisan route:cache');
        run('docker exec -i docker-compose_php_prod_1 composer dump-autoload');

        sleep(60);

        run('docker exec -i docker-compose_php_prod_1 php artisan migrate');
    }
});

//task('artisan:migrate:docker', function () {
//    $hostname = get('hostname');
//echo
//    if ($hostname == 'pweb.devel') {
//        run('cd ~/docker-compose && docker exec -i docker-compose_php_devel_1 php artisan migrate');
//    } else {
//        run('cd ~/docker-compose && docker exec -i docker-compose_php_prod_1 php artisan migrate');
//    }
//});

task('copy:env:frontend', function () {
    $hostname = get('hostname');

    if ($hostname == 'pweb.devel') {
        run('cd ~/docker-compose && docker exec -i docker-compose_php_devel_1 cp frontend/resources/js/.env.example.json frontend/resources/js/.env.json');
    } else {
        run('cd ~/docker-compose && docker exec -i docker-compose_php_prod_1 cp frontend/resources/js/.env.example.json frontend/resources/js/.env.json');
    }
});

task('npm:install:frontend', function () {
    $hostname = get('hostname');

    if ($hostname == 'pweb.devel') {
        run('cd ~/docker-compose && docker exec -i docker-compose_php_devel_1 cd frontend; npm install');
    } else {
        run('cd ~/docker-compose && docker exec -i docker-compose_php_prod_1 cd frontend; npm install');
    }
});

task('npm:run:frontend', function () {
    $hostname = get('hostname');

    if ($hostname == 'pweb.devel') {
        run('cd ~/docker-compose && docker exec -i docker-compose_php_devel_1 cd frontend; npm run dev');
    } else {
        run('cd ~/docker-compose && docker exec -i docker-compose_php_prod_1 cd frontend; npm run dev');
    }
});

task('docker:restart', function () {
    run('cd ~/docker-compose && docker-compose down -v && docker-compose up -d');
});