<?php
if (!class_exists('DatabaseService')) include_once("services/db.php");
if (!class_exists('Genero')) include_once("services/genero.php");
if (!class_exists('Director')) include_once("services/director.php");
if (!class_exists('Actor')) include_once("services/actor.php");

class Pelicula
{
    private $db;
    public function __construct()
    {
        $this->db = new DatabaseService();
        $this->db->connect();
    }

    public function get( $conditions = [], $searchConditions = [] )
    {
        $sql = "SELECT * FROM peliculas WHERE deleted_at IS NULL";
        
        if( count( $conditions ) > 0 )
            $sql .= " AND " . implode( ' AND ', $conditions );
        
        if( count( $searchConditions ) > 0 )
            $sql .= " AND (" . implode( " OR ", $searchConditions ) . ")";
        // var_dump( $sql );
        // die();
        $result = $this->db->select( $sql );
        if( $result && count( $result ) > 0 ) 
        {
            foreach( $result as $key => $value ) 
            {
                $result[$key]['genero'] = $this->getGenero( $value[ 'genero_id' ] );
                $result[$key]['director'] = $this->getDirector( $value[ 'director_id' ] );
                $result[$key]['actores'] = $this->getActores( $value[ 'id' ] );
            }
            return $result;
        }
        return null;
    }

    public function findById( $id )
    {
        $films = $this->get( [ 'id = ' . $id ] );
        return  $films? $films[0] : null;
    }

    public function getGenero( $id )
    {
        $service = new Genero();
        return $service->get( [ 'id = ' . $id ] )[0];
    }

    public function getDirector( $id )
    {
        $service = new Director();
        return $service->get( [ 'id = ' . $id ] )[0];
    }

    public function getActores( $id )
    {
        $sql = "SELECT * FROM actores
                WHERE id IN
                    ( SELECT actor_id
                    FROM actor_pelicula
                    WHERE pelicula_id = " . $id . ")";
        $result = $this->db->select( $sql );
        if( $result && count( $result ) > 0 ) 
        {
            return $result;
        }
        return [];
    }

    public function create( $data )
    {
        $sql = "INSERT INTO peliculas
                (titulo, fecha_estreno, duracion, genero_id, director_id, descripcion)
                VALUES
                (" . $data[ 'title' ] . "," . $data[ 'release' ] . "," . $data[ 'length' ] . "," . $data[ 'genre' ] . "," . $data[ 'director' ] . "," . $data[ 'description' ] . ")";
        $filmId = $this->db->insert( $sql );
        if( $filmId ) 
        {
            $cast = "";
            foreach( explode( ",", $data[ 'cast' ] ) as $actor ) 
            {
                $cast .= $cast? "," : "";
                $cast .= "(" . $actor . "," . $filmId . ")";
            }
            $sql = "INSERT INTO actor_pelicula
                        (actor_id, pelicula_id)
                        VALUES
                        " . $cast;
            $this->db->insert( $sql );
            return $this->get( [ 'id = ' . $filmId ] )[0];
        }
    }

    public function edit( $data )
    {
        $sql = "UPDATE peliculas SET titulo=" . $data[ 'title' ] . ",
            fecha_estreno=" . $data[ 'release' ] . ",
            duracion=" . $data[ 'length' ] . ",
            genero_id=" . $data[ 'genre' ] . ",
            director_id=" . $data[ 'director' ] . ",
            descripcion=" . $data[ 'description' ] . "
            WHERE id=" . $data[ 'id' ];
        $this->db->update( $sql );

        $sql = "DELETE FROM actor_pelicula WHERE pelicula_id=" . $data[ 'id' ];
        $this->db->delete( $sql );

        $cast = "";
        foreach( explode( ",", $data[ 'cast' ] ) as $actor ) 
        {
            $cast .= $cast? "," : "";
            $cast .= "(" . $actor . "," . $data[ 'id' ] . ")";
        }
        $sql = "INSERT INTO actor_pelicula
                    (actor_id, pelicula_id)
                    VALUES
                    " . $cast;
        $this->db->insert( $sql );
        return $this->findById( $data[ 'id' ] );
    }

    public function delete( $id )
    {
        $film = $this->findById( $id );
        if( $film )
        {
            $sql = "UPDATE peliculas SET deleted_at = NOW() WHERE id=" . $id;
            $this->db->update( $sql );
        }
        return $film;
    }
}