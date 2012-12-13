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
        $this->alike['popularity'] = $pop;
    }

    protected function compareGenre($genres) {
        $this->alike['genre'] = 0;
        foreach ($genres as $genre) {
            if (in_array($genre, $this->songX['genre'])) {
                $this->alike['genre'] += 2;
            }
        }
    }

    public function saveToDatabase(PDO $db) {
        $v = 0;

        /*$stValue = $db->prepare("
                        INSERT INTO
                            similarities_value
                        (`x`,`y`,`key`,points)
                        VALUES
                        (:x,:y,:key,:points)
                        ");*/
        $stMatrix = $db->prepare("
                        INSERT INTO
                            similarities_matrix
                        (`x`,y,value)
                        VALUES
                        (:x,:y,:value)
                        ");

        foreach ($this->alike as $key => $comparison) {
            $v += $comparison;
            /*$stValue->bindValue(':x', $this->songX['id']);
            $stValue->bindValue(':y', $this->songY['id']);
            $stValue->bindValue(':key', $key);
            $stValue->bindValue(':points', $comparison);
            $stValue->execute();

            $stValue->bindValue(':y', $this->songX['id']);
            $stValue->bindValue(':x', $this->songY['id']);
            $stValue->bindValue(':key', $key);
            $stValue->bindValue(':points', $comparison);
            $stValue->execute();*/
        }
        $stMatrix->bindValue(':x', $this->songX['id']);
        $stMatrix->bindValue(':y', $this->songY['id']);
        $stMatrix->bindValue(':value', $v);
        //$stMatrix->bindValue(':v', $db->lastInsertId());
        $stMatrix->execute();

        $stMatrix->bindValue(':y', $this->songX['id']);
        $stMatrix->bindValue(':x', $this->songY['id']);
        $stMatrix->bindValue(':value', $v);
        //$stMatrix->bindValue(':v', $db->lastInsertId());
        $stMatrix->execute();
        
        /*var_dump($stMatrix->errorInfo());
        die();*/
    }

    public static function goGadget(PDO $db) {
        $st = $db->prepare("
            SELECT id,name,artist,bpm,rating,popularity FROM hitjes");
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
                //echo $i . ' Compared a sub song'.CHAR_NL;
            }
            $i++;
            echo $i . ' Compared a song' . CHAR_NL;
            $db->commit();
        }
    }

}

?>