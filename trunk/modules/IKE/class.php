<?php

class IKE extends Module {

    public function fire($action) {
        global $oModuleData;

        if (!isset($_SESSION['user_id']) &&
                !($action == 'login' ||
                $action == 'handle-login' ||
                $action == 'register' ||
                $action == 'handle-register' )
        ) {
            $action = 'login';
        }

        switch ($action) {
            case 'register':
                $this->register();
                break;
            case 'handle-register':
                $this->handleRegister();
                break;
            case 'login':
                $this->login();
                break;
            case 'handle-login':
                $this->handleLogin();
                break;
            case 'video':
                $this->video();
                break;

            default:
                var_dump($action);
                die();
                break;
        }
    }

    public function register() {
        global $oModuleData;

        $oModuleData->view = '/modules/IKE/views/register.inc.php';
    }

    public function handleRegister() {
        global $oModuleData;
        $f = new Facebook(array(
                    'appId' => IKE_FB_APP_ID,
                    'secret' => IKE_FB_APP_SECRET,
                ));
        $s = $f->getSignedRequest();
        $user = User::create($this->conn, $s);

        $oModuleData->view = '/modules/IKE/views/registrationCompleted.inc.php';
    }

    public function login() {
        global $oModuleData;

        $oModuleData->view = '/modules/IKE/views/login.inc.php';
    }

    public function handleLogin() {
        global $oModuleData;
        $user_id = User::getUserByLogin($this->conn, $_POST['username'], $_POST['password']);

        if ($user_id === NULL) {
            throw new InvalidCredentialsException;
        }

        $_SESSION['user_id'] = $user_id;
        header('Location: /video');
        die('Redirect');
    }

    public function video() {
        global $oModuleData;

        if (isset($_POST['link'])) {
            return $this->videoDisplay();
        }

        $user = User::get($this->conn, $_SESSION['user_id']);


        $oModuleData->data->user = $user;
        $oModuleData->view = '/modules/IKE/views/welcome.inc.php';
    }

    public function videoDisplay() {
        global $oModuleData;

        $postLink = parse_url($_POST['link']);
        $gets = explode('&', $postLink['query'] );
        foreach ($gets as $get) {
            list($key, $value) = explode('=', $get);
            var_dump($key,$value);
            if ($key == 'v') {
                $link = $value;
                break;
            }
        }
        
        $oModuleData->data->link = $link;

        $oModuleData->view = '/modules/IKE/views/videoResult.inc.php';
    }

}