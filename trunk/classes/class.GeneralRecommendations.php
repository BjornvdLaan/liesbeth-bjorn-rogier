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
                y
            FROM
                similarities_matrix
            WHERE
                x=:x
            ORDER BY 
                value DESC
            LIMIT
                0,50");
        $st->bindValue(':x',$this->song['id']);
        $st->execute();
        
        $this->resultSet = $st->fetchAll();
        return $this->resultSet;
    }
    
}