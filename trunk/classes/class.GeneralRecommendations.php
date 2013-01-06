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
            ORDER BY 
                value DESC
            LIMIT
                0,50");
        $st->bindValue(':x',$this->song->id);
        $st->execute();
        
        $res = array();
        foreach ( $st->fetchAll() as $s ) {
            $res[] = new Song($db, $s['youtube_id']);
        }
        
        $this->resultSet = $res;
        
        return $res;
    }
    
}