<?php

include_once "defines.php";
include_once "init.php";

\App\Core\Application::create()->handleRequest(\App\Core\HttpRequest::createFromGlobals());