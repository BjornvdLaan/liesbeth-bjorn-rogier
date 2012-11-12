<?php

interface DbComm {
    
    public static function get(PDO $db, $id);

    public static function create(PDO $db, $data);

    
}