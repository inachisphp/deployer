<?php

/**
 * This file is part of the inachis framework
 *
 * @package Inachis
 * @license https://github.com/inachisphp/inachis/blob/main/LICENSE.md
 */

// Reload PHP-FPM to pick up new code
task('php-fpm:reload', function () {
    run('sudo systemctl reload {{php_fpm_service}}');
});

// Fix filesystem permissions after symlink switch
task('deploy:permissions', function () {
    run('sudo chown -R www-data:www-data {{deploy_path}}/current');
});