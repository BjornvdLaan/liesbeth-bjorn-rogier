<?php

/**
 * This class determines which module and action to run.
 * It sets the DB connections and fires the method
 * It may also catch some severe errors that are not in the scope for the
 * modules themselves.
 * 
 * @author Rogier Slag
 * @version 1
 * @package Environment
 */
class Handler {

    private $dAction = 'login';
    private $module;
    private $db = NULL;
    
    /**
     * Constructs the Handler
     */
    public function __construct() {
        define('ACTION', isset($_GET['action']) ? $_GET['action'] : $this->dAction);
        include(IKE_APP_DIR . '/modules/' . MODULE . '/class.php');
        $m = MODULE;


        try {
            $this->conn();
            $this->module = new $m($this->db);
        } catch (Exception $e) {
            # By the time the exception arrived here, there's litte we can do
            $render = Render::getInstance();
            $render->renderError($e->renderError());
            die();
        }
    }

    
    /**
     * Fires the adequate portion based on the ACTION constant
     */
    public function fire() {
        try {
            $this->module->fire(ACTION);
        } catch (InventIDException $e) {
            $render = Render::getInstance();
            $render->renderError($e->renderError());
            die();
        } catch (Exception $e) {
            if (IKE_APP_ENV != ENV_PRODUCTION) {
                header("Content-type: text/plain");
                echo $e->getTraceAsString();
                die($e->getMessage());
            } else {
                die();
            }
        }
    }

    /**
     * This function creates the database communication
     */
    private function conn() {
        try {
            $this->db = new PDO('mysql:dbname=' . IKE_DB_NAME . ';host=' . IKE_DB_HOST, IKE_DB_USER, IKE_DB_PASS);
        } catch (PDOException $e) {
            $errCode = $e->getCode();
            if ($errCode == 1045) {
                throw new DatabaseAccessException();
            } else {
                var_dump($e);
                throw $e;
            }
        }
    }

    public static function notifyStaff(Exception $e,$file='?') {
        $m = new PhpMailer(true);
        $m->AddAddress(IKE_MAIL_TECH);
        $m->Subject = "Probleem in cronjob";
        $message = sprintf("Script %s.%sFout gevonden in %s op regel %s (code #%d) met bericht: %s.%sStacktrace: ", $file, CHAR_NL, $e->getFile(), $e->getLine(), $e->getCode(), $e->getMessage(), CHAR_NL . CHAR_NL, $e->getTraceAsString());
        $m->IsHTML(false);
        $m->AltBody = $message;
        $m->MsgHTML($message);
        $m->Send();
    }

}
