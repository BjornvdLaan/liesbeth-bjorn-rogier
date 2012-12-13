<?php

include ( '../../modules/constants.php');
include ( '../../app_client/_config.php');
include ( '../../modules/config.php');
include ( '../../modules/sources.php');
include ( '../../modules/IKE/class.php');

header('Content-type: text/plain');

$db = new PDO('mysql:dbname=' . IKE_DB_NAME . ';host=' . IKE_DB_HOST, IKE_DB_USER, IKE_DB_PASS);

Weights::goGadget($db);

echo CHAR_NL.CHAR_NL.'Done';