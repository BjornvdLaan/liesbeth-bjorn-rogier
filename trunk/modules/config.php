<?php

define('IKE_SERVER_NAME', gethostbyaddr("127.0.0.1"));

define('IKE_CLIENT_IP', (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : 'localhost');

define('IKE_DB_USER', 'ike');
define('IKE_DB_PASS', 'lfxnHGEFGFjhfhdbxcvmghfjdhxbvmnbx');
define('IKE_DB_HOST', 'localhost');
define('IKE_DB_NAME', 'ike');

define('IKE_DB_VERSION', '0.1');

define('IKE_APP_ENV', getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 3);
define('IKE_APP_TYPE', getenv('APPLICATION_TYPE') ? getenv('APPLICATION_TYPE') : 1);

define('IKE_APP_PROTOCOL', 'http' . (IKE_APP_SSL ? 's' : ''));

define('IKE_FB_APP_ID','404370416302248');
define('IKE_FB_APP_SECRET','9bc86e973421959f4ca4274cb1312102');


define('HASH_ALGO', 'sha512');

define('IKE_MAIL_TECH','rogier@in-ventid.nl');
?>