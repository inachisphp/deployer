<?php

/**
 * This file is part of the inachis framework
 *
 * @package Inachis
 * @license https://github.com/inachisphp/inachis/blob/main/LICENSE.md
 */

namespace Deployer;

require 'recipe/common.php';
require 'recipe/symfony.php';

require __DIR__ . '/deploy/tasks/requirements.php';

set('repository', 'git@github.com:inachisphp/inachis.git');
set('keep_releases', 2);

set('shared_files', [ '.env', '.env.local', ]);
set('shared_dirs', [ 'public/imgs', 'var/{cache,log,sessions,uploads}', ]);
set('writable_dirs', [ 'public/imgs', 'var/{cache,uploads}', ]);
set('allow_anonymous_stats', false);


import('inventory.yaml');

before('deploy:prepare', 'requirements:check');
after('deploy:failed', 'deploy:unlock');
