<?php

/**
 * This file is part of the inachis framework
 *
 * @package Inachis
 * @license https://github.com/inachisphp/inachis/blob/main/LICENSE.md
 */

desc('Deploy Symfony 7.3 Application');
task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:shared',
    'deploy:writable',

    'deploy:symlink',

    'symfony:optimize',

    'php-fpm:reload',
    'deploy:cleanup',
    'deploy:permissions',
]);