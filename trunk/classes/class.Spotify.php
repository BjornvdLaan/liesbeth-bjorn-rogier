<?php

class Spotify {
    
    public static function getArtist($name) {
        $url = sprintf('http://ws.spotify.com/search/1/artist.json?q=%s',  rawurlencode($name));
        
        $result = json_decode(file_get_contents($url));
        if ( !isset($result->artist[0]) ) {
            $result = new StdClass;
            $result->href = 'Not found';
            $result->popularity = 'Not found';
            return $result;
        }
        return $result->artists[0];
    }
    
    public static function getTrack($name) {
        
    }
    
}