<?php

/**
 * This class uses the actual $oModuleData object to render all data for the 
 * client
 * 
 * @author Rogier Slag
 * @version 1
 * @package Environment
 * 
 * For convenience we describe the format for the $oModuleData object is described
 * $oModuleData is an object containing the following
 *      ->input     an Input object
 *      ->shopData  an object with the configuration for the shop
 *      ->layout    an object with the layout configuration
 *      ->view      a string with the view to use
 *      ->data      an object with the module specific results
 */
class Render {

    private $header = '/views/client/general/header.inc.php';
    private $footer = '/views/client/general/footer.inc.php';
    private $views = array('general', 'plain', /*'iframe' */);

    /**
     * This function masks an E-mailaddress from spammers by inserting random things between the user and domain part
     * @param string $email The emailaddress to mask
     */
    public static function maskEmail($email) {
        $username = substr($email, 0, strpos($email, '@'));
        $domain = substr($email, strpos($email, '@'));
        return sprintf('%s<span style="display:none;">%d</span><!--%d-->%s', $username, mt_rand(0, 9999), mt_rand(0, 9999), $domain);
    }

    /**
     * The constructor for the class. It prepares
     * all neccesary variables and constants
     */
    public function __construct() {
        $this->checkView();
        if (!defined('PREFIX') && IKE_RENDER_VIEW === $this->views[0]) {
            define('PREFIX', '');
        } elseif (!defined('PREFIX')) {
            define('PREFIX', '/view/' . IKE_RENDER_VIEW);
        }
    }

    /**
     * This function renders an error 
     * @param int $errCode the errorcode to render
     */
    public function renderError($errCode = 9999) {
        global $oModuleData;
        $oModuleData->view = '/views/errors/' . $errCode . '.inc.php';
        $this->doRender();
    }

    /**
     * This function checkes how the app was called and
     * accordingly determines which view to use
     * Parts of the app may refer to the view
     */
    public function checkView() {
        if (isset($_GET['view']) && in_array($_GET['view'], $this->views)) {
            define('IKE_RENDER_VIEW', $_GET['view']);
        } else {
            define('IKE_RENDER_VIEW', $this->views[0]);
        }

        return;
    }

    /**
     * This function handles the actual rendering of 
     * the HTML for the client
     */
    public function render() {
        if (defined('IKE_RENDER_VIEW')) {
            $this->header = '/views/' . IKE_RENDER_LAYOUT . '/' . IKE_RENDER_VIEW . '/header.inc.php';
            $this->footer = '/views/' . IKE_RENDER_LAYOUT . '/' . IKE_RENDER_VIEW . '/footer.inc.php';
        }
        $this->doRender();
    }

    /**
     * This function handles the actual rendering
     */
    private function doRender() {
        # Get rid of any unneccasary output
        if (IKE_APP_ENV == ENV_PRODUCTION)
            ob_end_clean();

        global $oModuleData;

        include( IKE_APP_DIR . $this->header );
        include( IKE_APP_DIR . $oModuleData->view );
        include( IKE_APP_DIR . $this->footer );

        exit();
    }

}