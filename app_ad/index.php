<?php
require_once dirname(__FILE__) . '/../framework/Dispatcher.php';
require_once dirname(__FILE__) . '/../app/config/config.php';

$dispatcher = new Dispatcher();
$dispatcher->setSystemRoot(APP_DIR_NAME . 'app_ad/');
$dispatcher->setError404Url(SITE_URL_KANRI . 'errpage/err404');
$dispatcher->setRootDirName('login');
$dispatcher->dispatch();
