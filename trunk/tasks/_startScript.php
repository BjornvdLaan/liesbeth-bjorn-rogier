<?php

ob_start();
date_default_timezone_set('Europe/Amsterdam');
chdir(dirname(__FILE__));

include ( '../modules/constants.php');
include ( '../modules/config.php');
include ( '../modules/sources.php');

$dbh = new PDO('mysql:dbname=ike;host=' . IKE_DB_HOST, IKE_DB_USER, IKE_DB_PASS);