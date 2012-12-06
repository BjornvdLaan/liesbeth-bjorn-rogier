<?php

class Echonest {

    public static $wikipedia = '';
    public static $amazon = '';
    public static $itunes = '';
    public static $facebook = '';
    protected static $datasources = array('wikipedia', 'amazon', 'itunes', 'facebook');

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

        foreach ($data->response->biographies as $item) {
            $site = $item->site;
            if (!in_array($site, Echonest::$datasources)) {
                continue;
            }
            Echonest::$$site->url = $item->url;
            Echonest::$$site->text = $item->text;
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

        return $data->response->terms;
    }

    public static function getBpm($artist, $song) {


        if (empty($artist) || empty($song) ) {
            return;
        }

        $url = "http://developer.echonest.com/api/v4/song/search?api_key=YWOBBQGLJNR0XO3RG&artist=%s&title=%s&results=5&bucket=audio_summary";
        $url = sprintf($url, rawurlencode($artist),  rawurlencode($song));

        $data = json_decode(file_get_contents($url));

        return $data->response->songs[0]->audio_summary->tempo;
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
