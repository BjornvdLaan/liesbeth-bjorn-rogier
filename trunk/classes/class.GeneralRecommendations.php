<?php

class GeneralRecommendations {
    
    protected $song;
    protected $resultSet = NULL;
    
    public function __construct($song) {
        $this->song = $song;
    }
    
    public function get(PDO $db) {
        if ( $this->resultSet !== NULL ) {
            return $this->resultSet;
        }
        $st = $db->prepare("
            SELECT
                youtube_id
            FROM
                similarities_matrix
            LEFT JOIN
                hitjes
            ON
            	hitjes.id = y
            WHERE
                x=:x
                AND
                hitjes.id NOT IN (SELECT hitje_id FROM user_dislikes WHERE user_id=:user)
                AND
                hitjes.spotify_id IS NOT NULL
            ORDER BY 
                value DESC
            LIMIT
                0,50");
        $st->bindValue(':x',$this->song->id);
        $st->bindValue(':user',$_SESSION['user_id']);
        
        $st->execute();
        
        $res = array();
        foreach ( $st->fetchAll() as $s ) {
            $res[] = new Song($db, $s['youtube_id']);
        }
        
        $this->resultSet = $res;
        
        return $res;
    }
    
}