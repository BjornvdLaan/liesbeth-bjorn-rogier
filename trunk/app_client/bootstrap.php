<?php

/**
 * Het bestand bootstrap.php regelt het opstartproces van de 
 * website en bepaalt de module welke wordt aangeroepen evenals
 * enkele andere onderdelen.
 */

session_start();
ob_start();
date_default_timezone_set('Europe/Amsterdam');

# Standaard defaults includen
$oModuleData = new StdClass;
$oModuleData->view = '';
$oModuleData->data = new StdClass;
$oModuleData->script = array();

include ( '../modules/constants.php');
include ( '_config.php');
include ( '../modules/config.php');
include ( '../modules/sources.php');

try {
    $render = new Render();
    
    $handler = new Handler();
    $handler->fire();

    $render->render();
} catch (Exception $e) {
    ob_end_clean();
    var_dump($e->getMessage());
    echo $e->getTraceAsString();
}