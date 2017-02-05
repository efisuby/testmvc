<?php

require_once ROOT . DS . 'src' . DS . 'Autoload.php';

\App\Autoload::create()
    ->registerNamespace('App', ROOT . DS . 'src'. DS )
    ->register();

$pdo = new PDO(PDO_DSN, PDO_USER, PDO_PASS);
\App\Core\DB\DBPool::getInstance()->addDb('default', $pdo);
\App\Core\DB\DBPool::getInstance()->setDefault($pdo);


if (php_sapi_name() !== 'cli') {
    session_start();
}