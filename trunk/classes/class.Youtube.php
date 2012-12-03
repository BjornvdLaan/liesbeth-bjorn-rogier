<?php

class Youtube {

    protected $video;

    public function __construct() {
        require_once 'Zend/Loader.php'; // the Zend dir must be in your include_path
        Zend_Loader::loadClass('Zend_Gdata_YouTube');
    }

    public function getDataForVideo($video_key) {
        $yt = new Zend_Gdata_YouTube();
        $this->video = $yt->getVideoEntry($video_key);
        return $this->video;
    }

    public function extractData() {
        $result = new stdClass();

        $title = $this->video->getVideoTitle();
        $aTitle = $this->splitSongTitle($title);

        $result->artist = ucwords(trim($aTitle[0]));
        $result->title = ucwords(trim($aTitle[1]));

        return $result;
    }

    public function splitSongTitle($input) {
        $title = explode('-', $input);
        if (count($title) != 2) {
            $title = explode(':', $input);
            if (count($title) != 2) {
                $title = explode(',', $input);
                if (count($title) != 2) {
                    $title = explode('|', $input);
                    if (count($title) != 2) {
                        $title = explode('/', $input);
                        if (count($title) != 2) {
                            throw new Exception('Cannot get title and artist. Sorry dude!');
                        }
                    }
                }
            }
        }
        foreach ($title as $key => $elem) {
            $title[$key] = strtolower($elem);
        }
        $stripCharacters = array('(','[','{',')',']','}','ft.');
        $max = strlen($title[1]);
        $strip = array($max);
        foreach ( $stripCharacters as $char ) {
            $x=strpos($title[1], $char);
            if ( $x !== FALSE ) {
                $strip[] = $x;
            }
        } 
        $title[1] = substr($title[1],0,min($strip));
            
        return $title;
    }

    public function getRelatedVideos() {
        $videoId = $this->video->getVideoId();
        $url = sprintf('https://gdata.youtube.com/feeds/api/videos/%s/related', $videoId);

        $yt = new Zend_Gdata_YouTube();
        return $yt->getVideoFeed($url);
    }

}
