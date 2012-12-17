<?php

class Weights {

    protected $songX;
    protected $songY;
    protected $alike;

    public function __construct($song) {
        $this->songX = $song;
    }

    public function compareSongs($songinfo) {
        if ($this->songX['id'] == $songinfo['id']) {
            return;
        }
        $this->songY = $songinfo;
        $this->compareArtist($songinfo['artist']);
        $this->compareBPM($songinfo['bpm']);
        $this->comparePopularity($songinfo['popularity']);
        $this->compareGenre($songinfo['genre']);
        $this->compareRating($songinfo['rating']);
        $this->compareDuration($songinfo['duration']);
        $this->compareDanceability($songinfo['danceability']);
        $this->compareReleaseYear($songinfo['releaseyear']);
    }

    protected function compareArtist($artist) {
        if ($this->songX['artist'] != $artist) {
            $this->alike['artist'] = 1;
        }
    }

    protected function compareBPM($BPM) {
        $compare = abs($this->songX['bpm'] - $BPM);
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

    protected function compareRating($rating) {
        $this->alike['rating'] = 0;
    }

    protected function comparePopularity($pop) {
        $this->alike['popularity'] = (4 * $pop);
    }

    protected function compareGenre($genres) {
        $this->alike['genre'] = 0;
        foreach ($genres as $genre) {
            if (in_array($genre, $this->songX['genre'])) {
                $this->alike['genre'] += 2;
            }
        }
    }

    protected function compareDuration($duration) {
        $compare = abs($this->songX['duration'] - $duration);
        if ($compare < 15) {
            $this->alike['duration'] = 2;
        } elseif ($compare < 25) {
            $this->alike['duration'] = 1;
        } else {
            $this->alike['duration'] = 0;
        }
    }

    protected function compareDanceability($dance) {
        if ($dance > ($this->songX['danceability'] - 0.05) && $dance < ($this->songX['danceability'] + 0.05)) {
            $this->alike['danceability'] = 3;
        } elseif ($dance > ($this->songX['danceability'] - 0.1) && $dance < ($this->songX['danceability'] + 0.1)) {
            $this->alike['danceability'] = 2;
        } else {
            $this->alike['danceability'] = 0;
        }
    }

    protected function compareReleaseYear($year) {
        $compare = abs($this->songX['releaseyear'] - $year);
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

        $stMatrix->bindValue(':x', $this->songX['id']);
        $stMatrix->bindValue(':y', $this->songY['id']);
        $stMatrix->bindValue(':value', $v);
        $stMatrix->execute();

        $stMatrix->bindValue(':y', $this->songX['id']);
        $stMatrix->bindValue(':x', $this->songY['id']);
        $stMatrix->bindValue(':value', $v);
        $stMatrix->execute();
    }

    public static function goGadget(PDO $db) {
        $st = $db->prepare("
            SELECT id,name,artist,bpm,rating,popularity,danceability,length as duration,releaseYear as releaseyear FROM hitjes");
        $st->execute();

        $stGenre = $db->prepare("SELECT genre FROM hitjes_genre WHERE hitje_id=:id");
        $results = array();

        foreach ($st->fetchAll() as $hitje) {
            $stGenre->bindValue(':id', $hitje['id']);
            $stGenre->execute();
            $hitje['genre'] = $stGenre->fetchAll();
            $results[] = $hitje;
        }
        echo 'Loadad all data. Ready for computations' . CHAR_NL;
        $i = 0;

        foreach ($results as $songX) {
            $db->beginTransaction();
            $create = new Weights($songX);
            foreach ($results as $songY) {
                if ($songX['id'] <= $songY['id']) {
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

    public static function addSong(PDO $db, $song) {
        $st = $db->prepare("
            SELECT id,name,artist,bpm,rating,popularity,danceability,length as duration,releaseYear as releaseyear FROM hitjes");
        $st->execute();

        $stGenre = $db->prepare("SELECT genre FROM hitjes_genre WHERE hitje_id=:id");
        $results = array();

        foreach ($st->fetchAll() as $hitje) {
            $stGenre->bindValue(':id', $hitje['id']);
            $stGenre->execute();
            $hitje['genre'] = $stGenre->fetchAll();
            $results[] = $hitje;
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