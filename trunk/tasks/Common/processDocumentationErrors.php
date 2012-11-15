<?php

/**
 * Formats the errors.xml file nicely
 */
chdir(dirname(__FILE__));

define('IKE_APP_DIR', '/home/ike/public_html');
define('IKE_APP_URI', 'ike.rogierslag.nl');
define('IKE_APP_NAME', 'Webshop in-ventID');
define('IKE_APP_MOUNT', '');   # Wat hier staat ook in .htaccess regel 13,64,65 zetten!
define('IKE_APP_SSL', false);
define('ID_APP_VERSION', '0.1');

define('ID_VIEWGENERAL_ONLY', FALSE);
define('ID_RENDER_LAYOUT', 'shop');

define('ID_BOUNDARY_LOAD', 10);

define('ID_LOAD_ACTIVE', false);
define('ID_LOAD_IP', '0.0.0.0');

include('../_startScript.php');
ob_end_clean();

$i = 0;

$n = new simple_html_dom(file_get_contents('/home/ike/docs/IKE_errors.xml'));
$files = $n->find('checkstyle file');
ob_start();
foreach ( $files as $file ) {
    $name = $file->__get('name');
    foreach ( $file->find('error') as $error ) {
        echo sprintf('%s found on line %d in file %s: %s'.CHAR_R.CHAR_NL,
                ucfirst($error->__get('severity')),
                $error->__get('line'),
                $name,
                $error->__get('message'));
        $i++;
    }
    echo CHAR_R.CHAR_NL;
}
$data = ob_get_clean();

$html = sprintf('<html><head><title>%s</title></head><body><p>%s</p></body></html>',
        'IKE Webapp Documentatie verbeteringen',
        nl2br($data, FALSE));

file_put_contents('/home/ike/docs/IKE_errors.html', $html);
file_put_contents('/home/ike/docs/IKE_count.txt',$i);

die(0);