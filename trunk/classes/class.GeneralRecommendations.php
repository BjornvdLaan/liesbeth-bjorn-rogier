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
                name, artist, youtube_id, hitjes.id
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
        
        $this->resultSet = $st->fetchAll();
        return $this->resultSet;
    }
    
}