<?php

class UserRecommendations {

    protected $songs = array();
    protected $userSongs = array();
    private $db;

    public function __construct(PDO $db, $songs) {
        $this->db = $db;
        $this->songs = $songs;
    }

    public function compute() {
        
    }

    public function getUserHistory($user_id) {
        $orQuery = array();
        foreach ( $this->songs as $song ) {
            //var_dump($song,$this->songs);
            //die();
            $orQuery[] = $song->id;
        }
        $query = sprintf("
            SELECT
                youtube_id,POW(1.04,count)*value as score
            FROM
                `user_hitje`
            LEFT JOIN
                similarities_matrix
                ON
                user_hitje.hitje_id = x
            LEFT JOIN hitjes
                ON hitjes.id = hitje_id
            WHERE
                user_id=:id
                AND
                x IN (%s)
            GROUP BY x
            ORDER BY score DESC
            LIMIT 0,5",  implode(',', $orQuery));
        $st = $this->db->prepare($query);
        $st->bindValue(':id', $user_id);
        $st->execute();

        $this->userSongs = array();
        foreach($st->fetchAll() as $song ) {
            $this->userSongs[] = new Song($this->db,$song['youtube_id']);
        }
    }

    public function get($limit = 5) {
        $result = array();
        for ($i = 0; $i < $limit && isset($this->userSongs[$i]); $i++) {
            $result[] = $this->userSongs[$i];
        }
        return $result;
    }

    public function cmp($a, $b) {
        die('deprecated');
        if ($a['weight'] == $b['weight']) {
            return 0;
        }
        return ($a['weight'] < $b['weight']) ? -1 : 1;
    }

}