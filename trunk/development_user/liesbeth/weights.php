<?php

class weights {

    public $song;
    protected $alike;

    public function compareSongs($songinfo) {
        $this->compareArtist($songinfo['artist']);
        $this->compareBPM($songinfo['bpm']);
        $this->comparePopularity($songinfo['popularity']);
        $this->compareGenre($songinfo['genre']);
        $this->compareRating($songinfo['rating']);
    }

    public function compareArtist($artist) {
        if ($this->song['artist'] == $artist) {
            $this->alike['artist'] = 1;
        }
    }

    public function compareBPM($BPM) {
        $compare = abs($this->song['bpm'] - $BPM);
        if ($compare == 0) {
            $this->alike['bpm'] = 3;
        } elseif ($compare >= 5) {
            $this->alike['bpm'] =2;
        } elseif ($compare >= 10) {
            $this->alike['bpm'] =1;
        } elseif ($compare >= 15) {
            $this->alike['bpm'] = 0.5;
        } else{
            $this->alike['bpm'] = 0;
        }
    }

    public function compareRating($rating) {
        
    }

    public function comparePopularity($pop) {
        $this->alike['popularity'] = $pop;
    }

    public function compareGenre($genres) {
        foreach ($genres as $genre) {
            if (in_array($genre, $this->song['genre'])) {
                $this->alike['genre'] += 2;
            }
        }
    }

}

?>