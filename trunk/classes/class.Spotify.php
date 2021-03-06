<?php

class Spotify {

    protected $json;

    public static function getArtist($name) {
        $url = sprintf('http://ws.spotify.com/search/1/artist.json?q=%s', rawurlencode($name));

        $result = json_decode(file_get_contents($url));
        if (!isset($result->artists[0])) {
            $result = new StdClass;
            $result->href = '';
            $result->popularity = '';
            return $result;
        }
        return $result->artists[0]->href;
    }
    
    public static function getLinkArtist($artist_id) {
        $id = substr($artist_id, strlen('spotify-artist:'));
        $url = sprintf('http://open.spotify.com/artist/%s', $id);
        return $url;
    }
    

    public static function getAlbums($artist_id) {
        if ($artist_id === '') {
            return array();
        }
        $url = sprintf(' http://ws.spotify.com/lookup/1/.josn?uri=%s&extras=albumdetail', $artist_id);

        $result = json_decode(file_get_contents($url));
        return $result->albums;
    }

    public function __construct($name, $artistID) {
        $this->json = NULL;
        $url = sprintf('http://ws.spotify.com/search/1/track.json?q=%s', rawurlencode($name));

        $result = json_decode(file_get_contents($url));
        foreach ($result->tracks as $track) {
            foreach ($track->artists as $artist) {
                if (isset($artist->href) && $artist->href == $artistID) {
                    $this->json = $track;
                }
            }
        }
    }

    public function getTrack() {
        if (isset($this->json->href)) {
            return $this->json->href;
        }
        return NULL;
    }
    
    public static function getLinkTrack($track_id) {
        $id = substr($track_id, 14);
        $url = sprintf('http://open.spotify.com/track/%s', $id);
        return $url;
    }
    
    public function getReleaseYear() {
        if (isset($this->json->album->released)) {
            return $this->json->album->released;
        }
        return NULL;
    }

    public function getPopularity() {
        if (isset($this->json->popularity)) {
            return $this->json->popularity;
        }
        return NULL;
    }

    public function getLength() {
        if (isset($this->json->length)) {
            return $this->json->length;
        }
        return NULL;
    }

}
