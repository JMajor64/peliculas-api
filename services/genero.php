<?php

if (!class_exists('DatabaseService')) include("services/db.php");

class Genero
{
    private $db;
    public function __construct()
    {
        $this->db = new DatabaseService();
        $this->db->connect();
    }

    public function get( $conditions = [] )
    {
        $sql = "SELECT * FROM generos";
        
        if( count( $conditions ) > 0 )
            $sql .= " WHERE " . implode( ' AND ', $conditions );

        $result = $this->db->select( $sql );
        if( $result && count( $result ) > 0 ) return $result;
        return null;
    }
}