<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

date_default_timezone_set("Asia/Vladivostok");

//set_error_handler("var_dump");

$application = new \Dudoserovich\ModifyChat\Application();

setcookie("typeNoty", null, time() - 3600);
setcookie("messageNoty", null, time() - 3600);

$application->run();