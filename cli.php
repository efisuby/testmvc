#!/usr/local/bin/php
<?php

include_once "defines.php";
include_once "init.php";

function help($argv) { ?>
Need some help?

<?= $argv ?> <ACTION> [action args]

    Actions:
        createUser <login> <password>
        dropUser <login>
<?php
    die();
}

$appScript = array_shift($argv); // No more app name

if ($argc == 1) {
    help($appScript);
}

$action = array_shift($argv); // no more action


switch ($action) {
    case 'createUser':
        if (count($argv) != 2) {
            help($appScript);
        }

        echo 'Prepare model' . PHP_EOL;
        $user = \App\Models\User::create();
        $user->setLogin($argv[0]);
        $user->setNewPassword($argv[1]);
        echo 'Save in db' . PHP_EOL;
        $user->save();
        echo 'Verify' . PHP_EOL;

        $dbUser = \App\Models\User::get($user->getId());
        echo 'Result: ' . var_export($dbUser->validatePassword($argv[1]), true) . PHP_EOL;
        break;
}