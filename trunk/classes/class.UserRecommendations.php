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
            /*var_dump($song);
            die();*/
            $orQuery[] = $song['id'];
        }
        $query = sprintf("
            SELECT
                hitje_id,POW(1.04,count)*value as score
            FROM
                `user_hitje`
            LEFT JOIN
                similarities_matrix
                ON
                user_hitje.hitje_id = x
            WHERE
                user_id=18
                AND
                x IN (%s)
            GROUP BY x
            ORDER BY score DESC
            LIMIT 0,5",  implode(',', $orQuery));
        $st = $this->db->prepare($query);
        $st->bindValue(':id', $user_id);
        $st->execute();

        $this->userSongs = $st->fetchAll();
    }

    public function get($limit = 5) {
        //usort($this->songs, array('UserRecommendations', 'cmp'));

        $result = array();
        for ($i = 0; $i < $limit && isset($this->songs[$i]); $i++) {
            $result[] = $this->songs[$i];
        }
        return $result;
    }

    public function cmp($a, $b) {
        if ($a['weight'] == $b['weight']) {
            return 0;
        }
        return ($a['weight'] < $b['weight']) ? -1 : 1;
    }

}