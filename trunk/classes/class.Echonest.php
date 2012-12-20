<?php

class Echonest {

    public static $wikipedia = '';
    public static $amazon = '';
    public static $itunes = '';
    public static $facebook = '';
    protected static $datasources = array('wikipedia', 'amazon', 'itunes', 'facebook');
    private static $artist;
    private static $song;
    private static $json;

    public static function getBiography($spotifyID) {
        if (empty($spotifyID)) {
            return;
        }

        $spotifyID = str_replace('spotify', 'spotify-WW', $spotifyID);

        $url = "http://developer.echonest.com/api/v4/artist/biographies?api_key=FILDTEOIK2HBORODV&id=%s";
        $url = sprintf($url, $spotifyID);

        $data = json_decode(file_get_contents($url));

//header('content-type: text/plain');
        Echonest::$wikipedia = new EchonestInfo();
        Echonest::$amazon = new EchonestInfo();
        Echonest::$itunes = new EchonestInfo();
        Echonest::$facebook = new EchonestInfo();

        //var_dump($data->response);
        foreach ($data->response->biographies as $item) {
            $site = $item->site;
            if (!in_array($site, Echonest::$datasources)) {
                continue;
            }
            Echonest::$$site->url = $item->url;
            Echonest::$$site->text = $item->text;
        }
    }

    public static function getEvent($artist) {

        if (empty($artist)) {
            return;
        }

        $url = "http://ws.audioscrobbler.com/2.0/?method=artist.getevents&artist=%s&api_key=82483b62640fc8a01bfde8be06a4e1c7&format=json";
        $url = sprintf($url, rawurlencode($artist));

        $data = json_decode(file_get_contents($url));
        if (!isset($data->events)||!isset($data->events->event)) {
            $tmp = array();
        } elseif (is_object($data->events->event)) {
            $tmp = array($data->events->event);
        } else {

            $tmp = $data->events->event;
        }

        $res = array();
        $visited = array();
        foreach ($tmp as $event) {
            if (isset($event->website) && !in_array($event->title, $visited)) {
                $res[] = $event;
                $visited[] = $event->title;
            }
        }

        return $res;
    }

    public static function getHotttnesss($artist) {


        if (empty($artist)) {
            return;
        }

        $url = "http://developer.echonest.com/api/v4/artist/hotttnesss?api_key=YWOBBQGLJNR0XO3RG&name=%s&format=json";
        $url = sprintf($url, rawurlencode($artist));

        $data = json_decode(file_get_contents($url));
        if (!isset($data->response->artist->hotttnesss)) {
            return null;
        }

        return $data->response->artist->hotttnesss;
    }

    public static function getHotttnesssIcon($hotttnesss) {
        if (!isset($hotttnesss)) {
            return;
        }

        if ($hotttnesss < 0.3) {
            return "<button class='btn'><i class='fam-weather-snow'></i></button>";
        } elseif ($hotttnesss < 0.5) {
            return "<button class='btn'><i class='fam-weather-clouds'></i></button>";
        } elseif ($hotttnesss < 0.75) {
            return "<button class='btn'><i class='fam-weather-cloudy'></i></button>";
        } else {
            return "<button class='btn'><i class='fam-weather-sun'></i></button>";
        }
    }

    public static function getGenre($artistSpotifyId) {


        if (empty($artistSpotifyId)) {
            return;
        }

        $artistSpotifyId = str_replace('spotify', 'spotify-WW', $artistSpotifyId);

        $url = "http://developer.echonest.com/api/v4/artist/terms?api_key=YWOBBQGLJNR0XO3RG&id=%s&format=json&sort=frequency";
        $url = sprintf($url, $artistSpotifyId);

        $data = json_decode(file_get_contents($url));
        if (empty($data->response->terms) || $data->response->terms === NULL) {
            return array();
        }
        return $data->response->terms;
    }

    public static function getDiscography($artist) {


        if (empty($artist)) {
            return;
        }

        $url = "http://developer.echonest.com/api/v4/song/search?api_key=YWOBBQGLJNR0XO3RG&artist=%s&results=100";
        $url = sprintf($url, rawurlencode($artist));

        $data = json_decode(file_get_contents($url));

        $songs = array();
        foreach ($data->response->songs as $item) {
            $songs[] = $item->title;
        }

        return $songs;
    }

    public static function getChristmas($artist) {


        if (empty($artist)) {
            return;
        }

        $url = "http://developer.echonest.com/api/v4/song/search?api_key=YWOBBQGLJNR0XO3RG&format=json&artist=%s&song_type=christmas&bucket=song_type";
        $url = sprintf($url, rawurlencode($artist));

        $data = json_decode(file_get_contents($url));

//return $data->response->songs;

        $xmas = array();
        foreach ($data->response->songs as $item) {
            $xmas[] = $item->title;
        }

        return $xmas;
    }

    public static function getBpm($artist, $song) {
        if (empty($artist) || empty($song)) {
            return;
        }

        if (self::$artist == $artist && self::$song == $song) {
            return self::$json->response->songs[0]->audio_summary->tempo;
        }

        $url = "http://developer.echonest.com/api/v4/song/search?api_key=YWOBBQGLJNR0XO3RG&artist=%s&title=%s&results=5&bucket=audio_summary";
        $url = sprintf($url, rawurlencode($artist), rawurlencode($song));

        $data = json_decode(file_get_contents($url));
        if (!isset($data->response->songs[0])) {
            return NULL;
        }

        self::$json = $data;
        self::$artist = $artist;
        self::$song = $song;
        return $data->response->songs[0]->audio_summary->tempo;
    }

    public static function getDanceability($artist, $song) {
        if (empty($artist) || empty($song)) {
            return;
        }

        if (self::$artist == $artist && self::$song == $song) {
            return self::$json->response->songs[0]->audio_summary->danceability;
        }

        $url = "http://developer.echonest.com/api/v4/song/search?api_key=YWOBBQGLJNR0XO3RG&artist=%s&title=%s&results=5&bucket=audio_summary";
        $url = sprintf($url, rawurlencode($artist), rawurlencode($song));

        $data = json_decode(file_get_contents($url));
        if (!isset($data->response->songs[0])) {
            return NULL;
        }

        self::$json = $data;
        self::$artist = $artist;
        self::$song = $song;
        return $data->response->songs[0]->audio_summary->danceability;
    }

}

class EchonestInfo {

    public $url;
    public $text;

    public function __construct($url = '', $text = '') {
        $this->url = $url;
        $this->text = $text;
    }

}
