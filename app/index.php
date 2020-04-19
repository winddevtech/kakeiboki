<?php
require_once dirname(__FILE__) . '/../framework/Dispatcher.php';
require_once 'config/config.php';

$dispatcher = new Dispatcher();
$dispatcher->setSystemRoot(APP_DIR_NAME . 'app/');
$dispatcher->setError404Url(SITE_URL  .'errpage/err404');
$dispatcher->setRootDirName('login');
$dispatcher->dispatch();
