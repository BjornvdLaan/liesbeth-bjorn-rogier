<?php

class Spotify {
    
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
    
    public static function getTrack($name) {
        
    }
    
    public static function getAlbums($artist_id) {
        if ( $artist_id === '' ) {
            return array();
        }
        $url = sprintf(' http://ws.spotify.com/lookup/1/.josn?uri=%s&extras=albumdetail',  $artist_id);
        
        $result = json_decode(file_get_contents($url));
        return $result->albums;
    }
    
}
