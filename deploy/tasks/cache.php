<?php

/**
 * This file is part of the inachis framework
 *
 * @package Inachis
 * @license https://github.com/inachisphp/inachis/blob/main/LICENSE.md
 */

task('symfony:optimize', function () {
    run('{{bin/php}} {{release_path}}/bin/console cache:clear --env=prod');
    run('{{bin/php}} {{release_path}}/bin/console cache:warmup --env=prod');
});