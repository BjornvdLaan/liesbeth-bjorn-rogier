<?php

class IKE extends Module {

    public function fire($action) {
        global $oModuleData;

        /*if (!isset($_SESSION['user_id']) &&
                !($action == 'login' ||
                $action == 'handle-login' ||
                $action == 'register' ||
                $action == 'handle-register' )
        ) {
            $action = 'login';
        }*/

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

        $_SESSION['user_id'] = 18;
        if (isset($_POST['link'])) {
            return $this->videoDisplay($_POST['link']);
        }

        $user = User::get($this->conn, $_SESSION['user_id']);


        $oModuleData->data->user = $user;
        $oModuleData->data->URL = 'e.g. http://www.youtube.com/.......';
        $oModuleData->view = '/modules/IKE/views/welcome.inc.php';
    }

    public function videoDisplay($link) {
        global $oModuleData;
        $youtube = new Youtube;
        $database  = new Database($this->conn);
        //$sparql = new Sparql;

        $link = $this->getLinkFromURL($link);

        $oModuleData->data->spotify = new stdClass();
        $oModuleData->data->youtube = new stdClass();
        $videoData = $youtube->getDataForVideo($link);
        $oModuleData->data->video = $youtube->extractData();
        $oModuleData->data->youtube->related = $youtube->getRelatedVideos();
        
        $oModuleData->data->spotify->artist = Spotify::getArtist($oModuleData->data->video->artist);
        $spotifyID = $oModuleData->data->spotify->artist->href;
        $oModuleData->data->spotify->track = Spotify::getTrack($oModuleData->data->video->title, $spotifyID);
        
        
        $oModuleData->data->link = $link;
        $oModuleData->data->URL = htmlspecialchars($_POST['link']);
        Echonest::getBiography($spotifyID);
        $oModuleData->data->xmas = Echonest::getChristmas($oModuleData->data->video->artist);
        $oModuleData->data->allsongs = Echonest::getDiscography($oModuleData->data->video->artist);
        $oModuleData->view = '/modules/IKE/views/videoResult.inc.php';
        
        $song = new stdClass();
        $song->spotifyID = $oModuleData->data->spotify->track;
        $song->artist = $oModuleData->data->video->artist;
        $song->name = $oModuleData->data->video->title;
        $song->genre = Echonest::getGenre($spotifyID);
        $song->bpm = Echonest::getBpm($song->artist, $song->name);
        $song->rating = '';
        $song->popularity = $oModuleData->data->spotify->artist->popularity;
        $database->addSongToDatabase($song);
        $database->addSongToUser($song->spotifyID,$_SESSION['user_id']);
        //var_dump($videoData);
    }

    protected function getLinkFromURL($link) {
        $postLink = parse_url($link);
        $gets = explode('&', $postLink['query']);
        foreach ($gets as $get) {
            list($key, $value) = explode('=', $get);
            if ($key == 'v') {
                return $value;
                break;
            }
        }
    }
}
