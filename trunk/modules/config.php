<?php

define('ID_SERVER_NAME', gethostbyaddr("127.0.0.1"));

define('ID_CLIENT_IP', (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : 'localhost');

define('ID_DB_USER', 'shop');
define('ID_DB_PASS', 'pD52hQTfLcBKaZ4hEvDHBccdQHT7hnFY');
define('ID_DB_HOST', 'alfa.in-ventid.nl');
if (defined('SHOP_NAME')) {
    define('ID_DB_NAME', 'shop_' . SHOP_NAME);
}
define('ID_DB_VERSION', '0.1');

define('ID_APP_ENV', getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 3);
define('ID_APP_TYPE', getenv('APPLICATION_TYPE') ? getenv('APPLICATION_TYPE') : 1);

define('ID_APP_PROTOCOL', 'http' . (ID_APP_SSL ? 's' : ''));
define('ID_CDN', ID_APP_PROTOCOL . '://static.in-ventid.nl');

define('HASH_ALGO', 'sha512');

define('ID_MAIL_TECH','rogier@in-ventid.nl');
?>