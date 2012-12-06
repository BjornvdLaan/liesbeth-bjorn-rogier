<?php

class weights {

    public $song;
    protected $alike;

    public function compareSongs($songinfo) {
        $this->alike = 0;
        $this->compareArtist($songinfo['artist']);
        $this->compareBPM($songinfo['bpm']);
        $this->comparePopularity($songinfo['popularity']);
        $this->compareGenre($songinfo['genre']);
        $this->compareRating($songinfo['rating']);
    }

    public function compareArtist($artist) {
        if ($this->song['artist'] == $artist) {
            $this->alike += 1;
        }
    }

    public function compareBPM($BPM) {
        $compare = abs($this->song['bpm'] - $BPM);
        if ($compare == 0) {
            $this->alike += 3;
        } elseif ($compare >= 5) {
            $this->alike +=2;
        } elseif ($compare >= 10) {
            $this->alike +=1;
        } elseif ($compare >= 15) {
            $this->alike += 0.5;
        }
    }

    public function compareRating($rating) {
        
    }

    public function comparePopularity($pop) {
        $this->alike += $pop;
    }

    public function compareGenre($genres) {
        foreach ($genres as $genre) {
            if (in_array($genre, $this->song['genre'])) {
                $this->alike += 2;
            }
        }
    }

}

?>