<?php

/**
 * This file is part of the inachis framework
 *
 * @package Inachis
 * @license https://github.com/inachisphp/inachis/blob/main/LICENSE.md
 */

namespace Deployer;

/**
 *  This file:
 *   - Reads composer.json to extract:
 *       - required php version (e.g. ">=8.4")
 *       - required extensions (ext-json, ext-mbstring, ...)
 *   - Checks remote PHP version
 *   - Checks that all required PHP extensions are installed
 *
 *  Add this to deploy.php:
 *       require __DIR__ . '/deploy/requirements.php';
 *       before('deploy:prepare', 'requirements:check');
 */

namespace Deployer;

/**
 * Load required PHP version + ext-* from composer.json
 */
task('requirements:load', function () {
    $path = get('local_composer_json', 'composer.json');

    if (!file_exists($path)) {
        throw new \RuntimeException("composer.json not found at: {$path}");
    }

    $composer = json_decode(file_get_contents($path), true);

    if (!$composer) {
        throw new \RuntimeException("composer.json is invalid JSON.");
    }

    $requires = $composer['require'] ?? [];
    $extensions = [];

    foreach ($requires as $package => $version) {
        if (str_starts_with($package, 'ext-')) {
            $extensions[] = $package; // example: ext-json
        }
    }

    // Save for other tasks
    set('required_php_version', $requires['php'] ?? null);
    set('required_php_extensions', $extensions);

    writeln("<info>Loaded PHP requirements from composer.json</info>");
});

/**
 * Check remote PHP version meets the composer requirement
 */
task('requirements:check_php_version', function () {
    $required = get('required_php_version');

    if (!$required) {
        writeln("<comment>No PHP version requirement found in composer.json</comment>");
        return;
    }

    $remoteVersion = run('php -r "echo PHP_VERSION;"');

    if (!version_compare($remoteVersion, $required, '>=')) {
        throw new \RuntimeException(
            "❌ Remote PHP version {$remoteVersion} does not satisfy composer requirement {$required}"
        );
    }

    writeln("<info>✔ PHP version OK ({$remoteVersion})</info>");
});

/**
 * Check all required PHP extensions are installed on the remote host
 */
task('requirements:check_extensions', function () {
    $requiredExts = get('required_php_extensions');

    if (empty($requiredExts)) {
        writeln("<comment>No required PHP extensions found in composer.json</comment>");
        return;
    }

    foreach ($requiredExts as $ext) {
        $name = str_replace('ext-', '', $ext);

        $loaded = run("php -r \"echo extension_loaded('{$name}') ? 'yes' : 'no';\"");

        if ($loaded !== 'yes') {
            throw new \RuntimeException("❌ Missing required PHP extension: {$ext}");
        }

        writeln("<info>✔ Extension loaded: {$ext}</info>");
    }
});

/**
 * Master task: run all requirement checks
 */
task('requirements:check', [
    'requirements:load',
    'requirements:check_php_version',
    'requirements:check_extensions',
]);
