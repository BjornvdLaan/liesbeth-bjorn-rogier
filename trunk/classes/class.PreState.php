<?php

/**
 * This class runs all necessary checks to
 * ensure the states of the client and server
 * are valid prestates for execution.
 *
 * In case some prestate is invalid, the class
 * functions try to resolve this before exiting
 *
 * In case this fails the class itself will
 * generate an error and refuse futher processing.
 * 
 * @author Rogier Slag
 * @version 1
 * @todo add more useful checks
 * @package Environment
 */
class PreState {

    public function __construct() {
        if (
                PreState::checkSSL() &&
                PreState::noOutput()
        ) {
            return true;
        } else {
            PreState::quit();
        }
    }

    /**
     * This function checks whether the app requests SSL
     * If it does while the request was without SSL
     * it will redirect the user to a SSLEnabled version
     */
    private function checkSSL() {
        if (ID_APP_SSL && isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != "on") {
            $url = sprintf('%s://%s%s',ID_APP_PROTOCOL,ID_APP_URI,ID_APP_MOUNT);
            header("Location: $url");
            PreState::quit(1001);
        }
        return true;
    }

    /**
     * This function checks whether the app yet has no output
     * If it has output before the render this may indicate
     * a problem on production level
     */
    private function noOutput() {
        $content = ob_get_contents();
        if (ID_APP_ENV < ENV_PRODUCTION && $content != '') {
            echo 'WARNING: UNEXPECTED OUTPUT GENERATED' . CHAR_NL;
            return true;
        } elseif (ID_APP_ENV < ENV_PRODUCTION) {
            return true;
        } elseif ($content != '') {
            PreState::quit(1002);
        }
        return true;
    }

    /**
     * This function monitors the current server load. In case
     * it gets out of hand the server denies the request and
     * notifies a loadbalancer if necessary
     */
    private function checkLoad() {
        $current = sys_getloadavg();
        if ($current[0] > ID_BOUNDARY_LOAD) {
            # An unacceptable load state was detected
            if (ID_LOAD_ACTIVE) {
                # Notify loadbalancer
                CommLoadBal::send(ID_LOAD_IP, array('state' => 'max', 'app' => ID_APP_URI));
                # Redirect back to loadbalancer
                header('Location: ' . ID_APP_PROTOCOL . ID_APP_URI . REQUEST_URI);
                header('HTTP/1.1 503 Too busy, redirecting back to loadbalancer');
                exit();
            } else {
                PreState::quit(1003);
            }
        }
        return true;
    }

    /**
     * This function only gets called if a check
     * failed to succeed and this check could not
     * handle the situation
     *
     * This function does not use the Render.class
     * as there might be a change in that class that
     * ultimately led to the error
     */
    private static function quit($errCode = 1000) {
        # Clear the user buffer
        if (ID_APP_ENV == ENV_PRODUCTION) {
            ob_end_clean();
        }

        include(ID_APP_DIR . '/views/general/header.inc.php');
        include(ID_APP_DIR . '/views/failure/' . $errCode . '.inc.php');
        include(ID_APP_DIR . '/views/general/footer.inc.php');

        # TODO
        # Trigger some sort of error to the DB
        error_log('Error #' . $errCode . ' detected');

        exit();
    }

}