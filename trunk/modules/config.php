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

define('HASH_ALGO', 'sha512');

define('IKE_MAIL_TECH','rogier@in-ventid.nl');
?>