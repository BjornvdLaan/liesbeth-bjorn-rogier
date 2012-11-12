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

    private $dAction = '1';
    private $module;
    private $db = NULL;
    private $data;

    /**
     * Constructs the Handler
     * @global Render $render
     */
    public function __construct() {
        define('ACTION', isset($_GET['action']) ? $_GET['action'] : $this->dAction);
        include(ID_APP_DIR . '/modules/' . MODULE . '/class.php');
        $m = MODULE;


        try {
            $this->conn();
            $this->data();
            $this->module = new $m($this->db, $this->data);
        } catch (Exception $e) {
            # By the time the exception arrived here, there's litte we can do
            global $render;
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
            global $render;
            $render->renderError($e->renderError());
            die();
        } catch (Exception $e) {
            if (ID_APP_ENV != ENV_PRODUCTION) {
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
            $this->db = new PDO('mysql:dbname=' . ID_DB_NAME . ';host=' . ID_DB_HOST, ID_DB_USER, ID_DB_PASS);
        } catch (PDOException $e) {
            $errCode = $e->getCode();
            if ($errCode == 1049) {
                throw new ShopNotFoundException();
            } elseif ($errCode == 1045) {
                throw new DatabaseAccessException();
            } else {
                var_dump($e);
                throw $e;
            }
        }
    }

    /**
     * This function formats the GET querystring to an array
     */
    private function data() {
        $str = $_SERVER['REQUEST_URI'];
        $str = substr($str, strpos($str, '?') + 1);
        $array = explode('&', $str);

        foreach ($array as $value) {
            $value = explode('=', $value, 2);
            if (count($value) != 2)
                continue;

            $this->data[$value[0]] = $value[1];
        }
    }

    public static function notifyStaff(Exception $e,$file='?') {
        $m = new PhpMailer(true);
        $m->AddAddress(ID_MAIL_TECH);
        $m->Subject = "Probleem in cronjob";
        $message = sprintf("Script %s.%sFout gevonden in %s op regel %s (code #%d) met bericht: %s.%sStacktrace: ", $file, CHAR_NL, $e->getFile(), $e->getLine(), $e->getCode(), $e->getMessage(), CHAR_NL . CHAR_NL, $e->getTraceAsString());
        $m->IsHTML(false);
        $m->AltBody = $message;
        $m->MsgHTML($message);
        $m->Send();
    }

}