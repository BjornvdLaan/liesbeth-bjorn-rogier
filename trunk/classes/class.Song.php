<?php

class Song {

    protected $db;
    public $id;
    public $spotify_id;
    public $artist;
    public $name;
    public $bpm;
    public $popularity;
    public $length;
    public $releaseYear;
    public $danceability;
    public $youtube_id;
    public $genre;
    public $source = 'ike';

    public function __construct(PDO $db, $youtube_id) {
        $this->db = $db;

        $st = $this->db->prepare("
            SELECT
                id,
                spotify_id,
                artist,
                name,
                bpm,
                popularity,
                length,
                releaseYear,
                danceability,
                youtube_id
            FROM
                hitjes
            WHERE
                youtube_id=:id");
        $st->bindValue(':id', $youtube_id);
        $st->execute();

        if ($st->rowCount() !== 1) {
            # Song not found, fetch it and add it to the database
            $data = $this->fetchSong($youtube_id);
            $this->id = $this->addSong($data);
            
            $this->spotify_id = $data->spotify_id;
            $this->artist = $data->artist;
            $this->name = $data->name;
            $this->bpm = $data->bpm;
            $this->popularity = $data->popularity;
            $this->length = $data->length;
            $this->releaseYear = $data->releaseYear;
            $this->danceability = $data->danceability;
            $this->youtube_id = $data->youtube_id;
            $this->genre = array();
            foreach ( $data->genre as $genre ) {
                $this->genre[] = $genre->name;
            }
            
            Weights::addSong($this->db, $this);
            
        } else {
            # Song found, add data to properties
            $result = $st->fetch();

            $this->id = $result['id'];
            $this->spotify_id = $result['spotify_id'];
            $this->artist = $result['artist'];
            $this->name = $result['name'];
            $this->bpm = $result['bpm'];
            $this->popularity = $result['popularity'];
            $this->length = $result['length'];
            $this->releaseYear = $result['releaseYear'];
            $this->danceability = $result['danceability'];
            $this->youtube_id = $result['youtube_id'];
            
            # Get genre information
            $stGenre = $this->db->prepare("
                SELECT
                    genre 
                FROM
                    hitjes_genre 
                WHERE
                    hitje_id=:id");
            $stGenre->bindValue(':id', $this->id);
            $stGenre->execute();
            
            $this->genre = array();
            foreach ( $stGenre->fetchAll() as $genre ) {
                $this->genre[] = $genre['genre'];
            }
        }
    }

    private function fetchSong($youtube_id) {
        # Youtube
        $youtube = new Youtube();
        $youtube->getDataForVideo($youtube_id);
        $r = $youtube->extractData();
        $artistName = $r->artist;
        $trackName = $r->title;
        $artistId = Spotify::getArtist($artistName);
        
        # Spotify
        $spotify = new Spotify($trackName, $artistId);
        # Echonest
        $echonest = new Echonest($artistId, $artistName, $spotify->getTrack(), $trackName);
        
        $song = new StdClass();
        $song->spotify_id = $spotify->getTrack();
        $song->artist = $artistName;
        $song->name = $trackName;
        $song->bpm = $echonest->getBpm();
        $song->popularity = $spotify->getPopularity();
        $song->length = $spotify->getLength();
        $song->releaseYear = $spotify->getReleaseYear();
        $song->danceability = $echonest->getDanceability();
        $song->genre = $echonest->getGenre();
        $song->youtube_id = $youtube_id;
        
        return $song;
    }

    private function addSong(StdClass $song) {
        $st= $this->db->prepare("INSERT INTO
                hitjes
            (
                spotify_id,
                name,
                artist,
                bpm,
                popularity,
                length,
                releaseYear,
                danceability,
                youtube_id
            )
            VALUES
            (
                :spotify,
                :name,
                :artist,
                :bpm,
                :popularity,
                :length,
                :releaseYear,
                :danceability,
                :youtube
            )
            ");
        $st->bindValue(':spotify', !empty($song->spotify_id) ? $song->spotify_id : NULL);
        $st->bindValue(':name', $song->name);
        $st->bindValue(':artist', $song->artist);
        $st->bindValue(':bpm', $song->bpm);
        $st->bindValue(':popularity', $song->popularity);
        $st->bindValue(':length', $song->length);
        $st->bindValue(':releaseYear', $song->releaseYear);
        $st->bindValue(':danceability', $song->danceability);
        $st->bindValue(':youtube', $song->youtube_id);

        $st->execute();
        $id = $this->db->lastInsertId();
        
        $st = $this->db->prepare("
            INSERT INTO hitjes_genre
            (hitje_id,genre,frequency,weight)
            VALUES
            (:hitje,:genre,:freq,:weight)
            ");
        if (is_array($song->genre)) {
            foreach ($song->genre as $genre) {

                $st->bindValue(':hitje', $id);
                $st->bindValue(':genre', $genre->name);
                $st->bindValue(':freq', $genre->frequency);
                $st->bindValue(':weight', $genre->weight);
                $st->execute();
            }
        }
        
        return $id;
    }
    
    public function addSongToUser(User $user) {
        $st = $this->db->prepare("
            SELECT
                hitje_id
            FROM
                user_hitje
            WHERE
                user_id=:user
                AND
                hitje_id=:id
            ");
        $st->bindValue(':user', $user->getId());
        $st->bindValue(':id', $this->id);
        $st->execute();

        if ($st->rowCount() == 1) {
            # Update the playcount
            $st = $this->db->prepare("
                UPDATE
                    user_hitje
                SET
                    count=count+1
                WHERE
                    hitje_id=:id
                    AND
                    user_id=:user");
            $st->bindValue(':user', $user->getId());
            $st->bindValue(':id', $this->id);
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
                    :id,
                    1
                )");
            $st->bindValue(':user', $user->getId());
            $st->bindValue(':id', $this->id);
        }
        $st->execute();
    }

}