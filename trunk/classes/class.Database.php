<?php

class Database {
    
    protected $db = NULL;
    
    public function __construct(PDO $db) {
        $this->db = $db;
    }
    
    public function addSongToDatabase( $song ) {
        $st = $this->db->prepare("
            SELECT
                id
            FROM
                hitjes
            WHERE
                spotify_id=:id
            ");
        $st->bindValue(':id', $song->spotifyID);
        $st->execute();
        
        if ( $st->rowCount() > 0 ) {
            return;
        }
        
        $st = $this->db->prepare("
            INSERT INTO
                hitjes
            (
                spotify_id,
                name,
                artist,
                bpm,
                rating,
                popularity
            )
            VALUES
            (
                :spotify,
                :name,
                :artist,
                :bpm,
                :rating,
                :popularity
            )
            ");
        $st->bindValue(':spotify', $song->spotifyID);
        $st->bindValue(':name', $song->name);
        $st->bindValue(':artist', $song->artist);
        $st->bindValue(':bpm', $song->bpm);
        $st->bindValue(':rating', $song->rating);
        $st->bindValue(':popularity', $song->popularity);
        $st->execute();
        
        $id = $this->db->lastInsertId();
        $st = $this->db->prepare("
            INSERT INTO hitjes_genre
            (hitje_id,genre,frequency,weight)
            VALUES
            (:hitje,:genre,:freq,:weight)
            ");
        foreach($song->genre as $genre) {
            $st->bindValue(':hitje', $id );
            $st->bindValue(':genre',$genre->name);
            $st->bindValue(':freq',$genre->frequency);
            $st->bindValue(':weight',$genre->weight);
            $st->execute();
        }
    }
    
    public function getRelatedSongs($limit,$id) {
        $st = $this->db->prepare("
            SELECT
                x
            FROM
                similarities_matrix
            WHERE
                y=:id
            ORDER BY
                value DESC
            LIMIT 0,:limit
            ");
        $st->bindValue(':id', $id);
        $st->bindValue(':limit', $limit);
        $st->execute();
        
        return $st->fetchAll();
    }
    
    public function addSongToUser($song,$user) {
        $st = $this->db->prepare("
            SELECT
                hitje_id
            FROM
                user_hitje
            WHERE
                user_id=:user
                AND
                hitje_id=(SELECT id FROM hitjes WHERE spotify_id=:spotify)
            ");
        $st->bindValue(':user', $user);
        $st->bindValue(':spotify', $song);
        $st->execute();
        
        if ( $st->rowCount() == 1 ) {
            # Update the playcount
            $st = $this->db->prepare("
                UPDATE
                    user_hitje
                SET
                    count=count+1
                WHERE
                    hitje_id=(SELECT id FROM hitjes WHERE spotify_id=:spotify)
                    AND
                    user_id=:user");
            $st->bindValue(':user', $user);
            $st->bindValue(':spotify',$song);
        } else {
            # Add new
            $st = $this->db->prepare("
                INSERT INTO
                    user_hitje
                (
                    user_id,
                    hitje_id,
                    count
                )
                VALUES
                (
                    :user,
                    (SELECT id FROM hitjes WHERE spotify_id=:spotify),
                    1
                )");
            $st->bindValue(':user', $user);
            $st->bindValue(':spotify', $song);
        }
        $st->execute();
    }
}