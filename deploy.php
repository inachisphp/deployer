<?php

/**
 * This file is part of the inachis framework
 *
 * @package Inachis
 * @license https://github.com/inachisphp/inachis/blob/main/LICENSE.md
 */

namespace Deployer;

require 'recipe/symfony.php';

//host('prod')
//    ->setHostname('example.com')
//    ->setUser('deployer')
//    ->set('deploy_path', '/var/www/app');

require __DIR__ . '/deploy/tasks/requirements.php';
//require __DIR__ . '/deploy/tasks.php';

before('deploy:prepare', 'requirements:check');
