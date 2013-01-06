<?php

define('MONTH',60*60*24*30);

class Echonest {

    private $artistId;
    private $trackId;
    private $artist;
    private $track;
    public static $wikipedia = '';
    public static $amazon = '';
    public static $itunes = '';
    public static $facebook = '';
    protected $datasources = array('wikipedia', 'amazon', 'itunes', 'facebook');

    public function __construct($artistId, $artist, $trackId, $track) {
        $this->artist = $artist;
        $this->artistId = $artistId;
        $this->track = $track;
        $this->trackId = $trackId;
    }

    public function getBiography() {
        if (empty($this->artistId)) {
            return;
        }

        $cache = Cached::getInstance();
        if (($data = $cache->get('biography-' . $this->artistId)) === FALSE) {
            $spotifyID = str_replace('spotify', 'spotify-WW', $this->artistId);

            $url = "http://developer.echonest.com/api/v4/artist/biographies?api_key=FILDTEOIK2HBORODV&id=%s";
            $url = sprintf($url, $spotifyID);

            $data = json_decode(file_get_contents($url));
            $data = $data->response->biographies;
            $cache->set('biography-' . $this->artistId, serialize($data));
        } else {
            var_dump('Cache hit! biography');
            $data = unserialize($data);
        }

        Echonest::$wikipedia = new EchonestInfo();
        Echonest::$amazon = new EchonestInfo();
        Echonest::$itunes = new EchonestInfo();
        Echonest::$facebook = new EchonestInfo();

        foreach ($data as $item) {
            $site = $item->site;
            if (!in_array($site, $this->datasources)) {
                continue;
            }
            Echonest::$$site->url = $item->url;
            Echonest::$$site->text = $item->text;
        }
    }

    public function getEvent() {
        if (empty($this->artist)) {
            return;
        }

        $cache = Cached::getInstance();
        if (($data = $cache->get('events-' . $this->artist)) === FALSE) {
            $url = "http://api.songkick.com/api/3.0/search/artists.json?query=%s&apikey=UD5BEug9mJxNqSob ";
            $url = sprintf($url, rawurlencode($this->artist));
            $data = json_decode(file_get_contents($url));
            $id = $data->resultsPage->results->artist[0]->id;

            $url2 = "http://api.songkick.com/api/3.0/artists/%s/calendar.json?apikey=UD5BEug9mJxNqSob";
            $url2 = sprintf($url2, $id);
            $data2 = json_decode(file_get_contents($url2));
            $events = isset($data2->resultsPage->results->event)?$data2->resultsPage->results->event:array();

            $cache->set('events-' . $this->artist, serialize($events),0,MONTH);
        } else {
            var_dump('Cache hit! event ');
            $events = unserialize($data);
        }
        return $events;
    }

    public function getHotttnesss() {
        if (empty($this->artist)) {
            return;
        }

        $cache = Cached::getInstance();
        if (($data = $cache->get('hotttnesss-' . $this->artist)) === FALSE) {
            $url = "http://developer.echonest.com/api/v4/artist/hotttnesss?api_key=YWOBBQGLJNR0XO3RG&name=%s&format=json";
            $url = sprintf($url, rawurlencode($this->artist));

            $data = json_decode(file_get_contents($url));
            $hotttnesss = isset($data->response->artist->hotttnesss) ? $data->response->artist->hotttnesss : NULL;


            $cache->set('hotttnesss-' . $this->artist, serialize($hotttnesss),0,MONTH);
        } else {
            var_dump('Cache hit! hotttnesss');
            $hotttnesss = unserialize($data);
        }

        return $hotttnesss;
    }

    public function getGenre() {
        if (empty($this->artistId)) {
            return;
        }

        $artistSpotifyId = str_replace('spotify', 'spotify-WW', $this->artistId);

        $url = "http://developer.echonest.com/api/v4/artist/terms?api_key=YWOBBQGLJNR0XO3RG&id=%s&format=json&sort=frequency";
        $url = sprintf($url, $artistSpotifyId);

        $data = json_decode(file_get_contents($url));
        if (empty($data->response->terms) || $data->response->terms === NULL) {
            return array();
        }
        return $data->response->terms;
    }

    public function getDiscography() {
        if (empty($this->artist)) {
            return;
        }

        $cache = Cached::getInstance();
        if (($data = $cache->get('songs-' . $this->artist)) === FALSE) {
            $url = "http://developer.echonest.com/api/v4/song/search?api_key=YWOBBQGLJNR0XO3RG&artist=%s&results=100";
            $url = sprintf($url, rawurlencode($this->artist));

            $data = json_decode(file_get_contents($url));

            $songs = array();
            foreach ($data->response->songs as $item) {
                $songs[] = $item->title;
            }
            
            $cache->set('songs-' . $this->artist, serialize($songs),0,MONTH);
        } else {
            var_dump('Cache hit! songs');
            $songs = unserialize($data);
        }

        return $songs;
    }

    public function getChristmas() {
        if (empty($this->artist)) {
            return;
        }

        $cache = Cached::getInstance();
        if (($data = $cache->get('xmas-' . $this->artist)) === FALSE) {
            $url = "http://developer.echonest.com/api/v4/song/search?api_key=YWOBBQGLJNR0XO3RG&format=json&artist=%s&song_type=christmas&bucket=song_type";
        $url = sprintf($url, rawurlencode($this->artist));

            $data = json_decode(file_get_contents($url));

            $songs = array();
            foreach ($data->response->songs as $item) {
                $songs[] = $item->title;
            }
            
            $cache->set('xmas-' . $this->artist, serialize($songs),0,MONTH);
        } else {
            var_dump('Cache hit! xmas');
            $songs = unserialize($data);
        }

        return $songs;
    }

    public function getBpm() {
        if (empty($this->artist) || empty($this->track)) {
            return;
        }

        $url = "http://developer.echonest.com/api/v4/song/search?api_key=YWOBBQGLJNR0XO3RG&artist=%s&title=%s&results=5&bucket=audio_summary";
        $url = sprintf($url, rawurlencode($this->artist), rawurlencode($this->track));

        $data = json_decode(file_get_contents($url));
        if (!isset($data->response->songs[0])) {
            return NULL;
        }

        return $data->response->songs[0]->audio_summary->tempo;
    }

    public function getDanceability() {
        if (empty($this->artist) || empty($this->track)) {
            return;
        }

        $url = "http://developer.echonest.com/api/v4/song/search?api_key=YWOBBQGLJNR0XO3RG&artist=%s&title=%s&results=5&bucket=audio_summary";
        $url = sprintf($url, rawurlencode($this->artist), rawurlencode($this->track));

        $data = json_decode(file_get_contents($url));
        if (!isset($data->response->songs[0])) {
            return NULL;
        }

        return $data->response->songs[0]->audio_summary->danceability;
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

}

class EchonestInfo {

    public $url;
    public $text;

    public function __construct($url = '', $text = '') {
        $this->url = $url;
        $this->text = $text;
    }

}
