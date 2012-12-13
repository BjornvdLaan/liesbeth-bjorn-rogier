<?php

class Spotify {
    
    static public $json;

        public static function getArtist($name) {
        $url = sprintf('http://ws.spotify.com/search/1/artist.json?q=%s',  rawurlencode($name));
        
        $result = json_decode(file_get_contents($url));
        if ( !isset($result->artists[0]) ) {
            $result = new StdClass;
            $result->href = '';
            $result->popularity = '';
            return $result;
        }
        return $result->artists[0];
    }
    
    public static function getTrack($name,$artistID) {
        $url = sprintf('thtp://ws.spotify.com/search/1/track.json?q=%s', rawurlencode($name));
        
        $result = json_decode(file_get_contents($url));
        foreach($result->tracks as $track) {
            foreach ( $track->artists as $artist) {
                if ( isset($artist->href) && $artist->href == $artistID ) {
                    Spotify::$json = $track;
                    return $track->href;
                }
            }
        }
        return '';
    }
    
    public static function getAlbums($artist_id) {
        if ( $artist_id === '' ) {
            return array();
        }
        $url = sprintf(' http://ws.spotify.com/lookup/1/.josn?uri=%s&extras=albumdetail',  $artist_id);
        
        $result = json_decode(file_get_contents($url));
        return $result->albums;
    }
    
    public static function getReleaseYear() {
        return isset(Spotify::$json->album->released)?(Spotify::$json->album->released):NULL;
    }
    public static function getPopularity() {
        return isset(Spotify::$json->popularity)?(Spotify::$json->popularity):NULL;
    }
    
}
