<?php

class IKE extends Module {

    public function fire($action) {
        global $oModuleData;

        //$_SESSION['user_id'] = 18;
        if (!isset($_SESSION['user_id']) &&
                !($action == 'login' ||
                $action == 'handle-login' ||
                $action == 'register' ||
                $action == 'handle-register' )
        ) {
            $action = 'login';
        }

        switch ($action) {
            case 'tests':
            case 'test':
                $this->video();
                $this->test();
                break;
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
            case 'dislike':
                $this->dislike();
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
        $userRecommend = new UserRecommendations($this->conn, $related->get($this->conn));
        $userRecommend->getUserHistory($_SESSION['user_id']);
        $oModuleData->data->recommendations = $userRecommend->get();
        var_dump(count($oModuleData->data->recommendations));
        if (count($oModuleData->data->recommendations) < 6) {
            $x = $related->get($this->conn);
            for ($i = count($oModuleData->data->recommendations), $j = 0; $i < 6 && isset($x[$i]);) {
                if (!in_array($x[$j], $oModuleData->data->recommendations)) {
                    $oModuleData->data->recommendations[] = $x[$j];
                    $i++;
                }
                $j++;
            }
        }
        $oModuleData->script[] = '$(".dislike").click(function() { $.post("/dislike",{"youtube_id": $(this).attr("youtube_id")},function(data) { alert("Het nummer wordt verwijderd uit de lijst."); location.reload(); }); });';
        $oModuleData->data->test = FALSE;
    }

    public function test() {
        global $oModuleData;

        if (GETData::getInstance()->get('link') !== NULL) {
            $vids = Song::getRandom($this->conn,6);
            for ($i = 0; $i < 6; $i++) {
                $oModuleData->data->recommendations[] = $vids[$i];
            }
            shuffle($oModuleData->data->recommendations);
            $oModuleData->data->test = TRUE;
            $oModuleData->script[] = 'show = false; $("#youtube_show").click( function() { if(!show) { $(".yt").css("background-color","red"); show = true; } else { $(".yt").css("background-color",""); show=false; } });';
        }
    }

    public function dislike() {
        $id = $_POST['youtube_id'];

        $st = $this->conn->prepare("
            INSERT INTO
                user_dislikes
            (user_id,hitje_id)
            VALUES
                (:user,(SELECT id FROM hitjes WHERE youtube_id=:youtube))");
        $st->bindValue(':user', $_SESSION['user_id']);
        $st->bindValue(':youtube', $id);
        $st->execute();

        die('success');
    }

}
