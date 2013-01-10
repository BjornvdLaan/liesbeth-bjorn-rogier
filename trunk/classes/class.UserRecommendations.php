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
            $orQuery[] = $song->id;
        }
        
        $query = sprintf("
            SELECT
                youtube_id,value as score
            FROM
                hitjes
            LEFT JOIN
                similarities_matrix
                ON
                hitjes.id = x
            LEFT JOIN 
                `user_hitje`
                ON hitjes.id = hitje_id
            WHERE
                user_id=:id
                AND
                x IN (%s)
                AND
                hitjes.spotify_id IS NOT NULL
            GROUP BY x
            ORDER BY score DESC",  implode(',', $orQuery));
        var_dump($query);
        $st = $this->db->prepare($query);
        $st->bindValue(':id', $user_id);
        $st->execute();

        $this->userSongs = array();
        foreach($st->fetchAll() as $song ) {
            $this->userSongs[] = new Song($this->db,$song['youtube_id']);
        }
    }

    public function get($limit = 6) {
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