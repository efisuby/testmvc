<?php
define ('DS', DIRECTORY_SEPARATOR);
define ('ROOT', realpath(dirname(__FILE__)));
define ('WEB_ROOT', ROOT . DS . 'public');
define ('TEMPLATE_PATH', ROOT . DS . 'templates' . DS);
define ('UPLOAD_PATH', WEB_ROOT . DS . 'upload' . DS);
define ('UPLOAD_WEB_PATH', '/upload/');

define ('PHP_EXT', '.php');
define ('TPL_EXT', '.tpl.php');

define ('MAIN_CONTROLLER', 'main');
define ('CONTROLLER_NS_PREFIX', '\\App\\Controllers\\');
define ('ACTION_POSTFIX', 'Action');
define ('ERROR_TEMPLATE', 'errors' . DS . '500');


define ('PDO_DSN', 'mysql:host=localhost;dbname=testmvc');
define ('PDO_USER', 'testmvc');
define ('PDO_PASS', 'testmvc');