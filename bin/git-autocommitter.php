#!/usr/bin/env php
<?php
/**
 * @author Mougrim <rinat@mougrim.ru>
 */
use Mougrim\GitAutocommitter\Autocommitter;
use Mougrim\GitAutocommitter\ShellHelper;
use Mougrim\GitAutocommitter\GitHelper;

// require composer autoloader
$autoloadPath = dirname(__DIR__) . '/vendor/autoload.php';
if (file_exists($autoloadPath)) {
    /** @noinspection PhpIncludeInspection */
    require_once $autoloadPath;
} else {
    /** @noinspection PhpIncludeInspection */
    require_once dirname(dirname(dirname(__DIR__))) . '/autoload.php';
}

Logger::configure(require_once __DIR__ . '/../config/logger.php');

try {
    if (!isset($argv[1])) {
        Logger::getLogger('dispatcher')->error("File name not passed");
        return;
    }
    $shellHelper = new ShellHelper();
    $gitHelper = new GitHelper($shellHelper);
    $autocommitter = new Autocommitter($gitHelper);
    $autocommitter->run($argv[1]);
} catch (Exception $exception) {
    Logger::getLogger('dispatcher')->error("Uncaught exception:", $exception);
    exit(1);
}

