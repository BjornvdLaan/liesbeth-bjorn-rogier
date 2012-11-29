<?php

class Spotify {
    
    public static function getArtist($name) {
        $url = sprintf('http://ws.spotify.com/search/1/artist.json?q=%s',  rawurlencode($name));
        
        $result = json_decode(file_get_contents($url));
        return $result->artists[0];
    }
    
    public static function getTrack($name) {
        
    }
    
}