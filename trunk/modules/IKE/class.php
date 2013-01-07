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

        $oModuleData->data = new stdClass();
        $oModuleData->data->user = User::get($this->conn, $_SESSION['user_id']);
        
        $get = GETData::getInstance();
        if ($get->get('link') !== NULL) {
            return $this->videoDisplay($get->get('link'));
        }

        $oModuleData->data->URL = 'e.g. http://www.youtube.com/.......';
        $oModuleData->view = '/modules/IKE/views/welcome.inc.php';
    }

    public function videoDisplay($link) {
        error_reporting(-1);
        # Initiate the defaults
        global $oModuleData;
        
        # Get the song data
        $song = new Song($this->conn, Youtube::getIdFromLink($link));
        $song->addSongToUser(User::get($this->conn, $_SESSION['user_id']));
        $oModuleData->data->song = $song;
        
        
        $spotifyArtistId = Spotify::getArtist($song->artist);
        $oModuleData->data->spotifyArtistId = $spotifyArtistId;
        $spotify = new Spotify($song->name, $spotifyArtistId);
        
        $echonest = new Echonest($spotifyArtistId, $song->artist, NULL, NULL);
        
        $oModuleData->data->spotify = $spotify;
                
        $oModuleData->data->link = Youtube::getIdFromLink($link);
        $oModuleData->data->URL = rawurldecode(htmlspecialchars(GETData::getInstance()->get('link')));
        $echonest->getBiography($spotifyArtistId);
        
        
        $oModuleData->data->xmas = $echonest->getChristmas();
        $oModuleData->data->allsongs = $echonest->getDiscography();
        $oModuleData->data->events = $echonest->getEvent();  
        $oModuleData->data->spotifyLinkArtist = Spotify::getLinkArtist($spotifyArtistId);
        $oModuleData->data->spotifyLinkTrack = Spotify::getLinkTrack($spotify->getTrack());
        $oModuleData->view = '/modules/IKE/views/videoResult.inc.php';
        
        $related = new GeneralRecommendations($song);
        $userRecommend = new UserRecommendations($this->conn,$related->get($this->conn));
        $userRecommend->getUserHistory($_SESSION['user_id']);
        $oModuleData->data->recommendations = $userRecommend->get();
        if ( count($oModuleData->data->recommendations) < 5) {
            for ( $i = count($oModuleData->data->recommendations); $i <= 5 && isset($oModuleData->data->related[$i]); $i++) {
                $oModuleData->data->recommendations[] = $oModuleData->data->related[$i];
            }
        }
    }
}
