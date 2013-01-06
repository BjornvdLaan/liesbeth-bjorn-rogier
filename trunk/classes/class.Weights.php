<?php

class Weights {

    protected $songX;
    protected $songY;
    protected $alike = array();

    public function __construct(Song $song) {
        $this->songX = $song;
    }

    public function compareSongs(Song $songToCompare) {
        if ($this->songX->id == $songToCompare->id) {
            return;
        }
        
        $this->songY = $songToCompare;
        $this->compareArtist();
        $this->compareBPM();
        $this->comparePopularity();
        $this->compareGenre();
        $this->compareDuration();
        $this->compareDanceability();
        $this->compareReleaseYear();
        
        $v = 0;
        foreach($this->alike as $c) {
            $v += $c;
        }
        return $v;
    }

    protected function compareArtist() {
        if ($this->songX->artist != $this->songY->artist) {
            $this->alike['artist'] = 1;
        }
    }

    protected function compareBPM() {
        $compare = abs($this->songX->bpm - $this->songY->bpm);
        if ($compare == 0) {
            $this->alike['bpm'] = 3;
        } elseif ($compare >= 5) {
            $this->alike['bpm'] = 2;
        } elseif ($compare >= 10) {
            $this->alike['bpm'] = 1;
        } elseif ($compare >= 15) {
            $this->alike['bpm'] = 0.5;
        } else {
            $this->alike['bpm'] = 0;
        }
    }

    protected function comparePopularity() {
        $this->alike['popularity'] = (4 * $this->songY->popularity);
    }

    protected function compareGenre() {
        $this->alike['genre'] = 0;
        foreach ($this->songY->genre as $genre) {
            if (!is_array($this->songX->genre)) {
                break;
            }
            if (in_array($genre, $this->songX->genre)) {
                $this->alike['genre'] += 2;
            }
        }
    }

    protected function compareDuration() {
        $compare = abs($this->songX->length - $this->songY->length);
        if ($compare < 15) {
            $this->alike['duration'] = 2;
        } elseif ($compare < 25) {
            $this->alike['duration'] = 1;
        } else {
            $this->alike['duration'] = 0;
        }
    }

    protected function compareDanceability() {
        if (
                $this->songY->danceability > ($this->songX->danceability - 0.05) && 
                $this->songY->danceability < ($this->songX->danceability + 0.05)) {
            
            $this->alike['danceability'] = 3;
        } elseif (
                $this->songY->danceability > ($this->songX->danceability - 0.1) && 
                $this->songY->danceability < ($this->songX->danceability + 0.1)) {
            
            $this->alike['danceability'] = 2;
        } else {
            $this->alike['danceability'] = 0;
        }
    }

    protected function compareReleaseYear() {
        $compare = abs($this->songX->releaseYear - $this->songY->releaseYear);
        if ($compare < 3) {
            $this->alike['releaseyear'] = 3;
        } elseif ($compare < 6) {
            $this->alike['releaseyear'] = 1;
        } else {
            $this->alike['releaseyear'] = 0;
        }
    }

    public function saveToDatabase(PDO $db) {
        $v = 0;

        $stMatrix = $db->prepare("
                        INSERT INTO
                            similarities_matrix
                        (`x`,y,value)
                        VALUES
                        (:x,:y,:value)
                        ");

        foreach ($this->alike as $comparison) {
            $v += $comparison;
        }

        if ($v < 8) {
            return;
        }

        $stMatrix->bindValue(':x', $this->songX->id);
        $stMatrix->bindValue(':y', $this->songY->id);
        $stMatrix->bindValue(':value', $v);
        $stMatrix->execute();

        $stMatrix->bindValue(':y', $this->songX->id);
        $stMatrix->bindValue(':x', $this->songY->id);
        $stMatrix->bindValue(':value', $v);
        $stMatrix->execute();
    }

    public static function goGadget(PDO $db) {
        $st = $db->prepare("SELECT youtube_id FROM hitjes");
        $st->execute();

        
        foreach ($st->fetchAll() as $hitje) {
            $results[] = new Song($db,$hitje_id['youtube_id']);
        }
        echo 'Loadad all data. Ready for computations' . CHAR_NL;
        $i = 0;

        foreach ($results as $songX) {
            $db->beginTransaction();
            $create = new Weights($songX);
            foreach ($results as $songY) {
                if ($songX->id <= $songY->id) {
                    continue;
                }
                $create->compareSongs($songY);
                $create->saveToDatabase($db);
            }
            $i++;
            echo $i . ' Compared a song' . CHAR_NL;
            $db->commit();
        }
    }

    public static function addSong(PDO $db, Song $song) {
        $st = $db->prepare("
            SELECT youtube_id FROM hitjes");
        $st->execute();

        foreach ($st->fetchAll() as $hitje_id) {
            $results[] = new Song($db,$hitje_id['youtube_id']);
        }

        $db->beginTransaction();
        $create = new Weights($song);
        foreach ($results as $songY) {
            $create->compareSongs($songY);
            $create->saveToDatabase($db);
        }
        $db->commit();
    }

}

?>