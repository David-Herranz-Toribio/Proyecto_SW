<?php

namespace SW\classes;

class Cancion{

    private $id_cancion;
    private $id_artista;
    private $titulo;
    private $imagen;
    private $fecha;
    private $duracion;
    private $likes;
    private $ruta;
    private $tags;


    public function __construct($parameters){

        $this->id_cancion = $parameters['id_cancion'];
        $this->id_artista = $parameters['id_artista'];
        $this->titulo = $parameters['titulo'];
        $this->imagen = $parameters['imagen'];
        $this->fecha = $parameters['fecha'];
        $this->duracion = $parameters['duracion'];
        $this->likes = $parameters['likes'];
        $this->ruta = $parameters['ruta'];
        $this->tags = $parameters['tags'];
    }


    public static function crearCancion($id_artista, $titulo, $imagen, $fecha, $duracion, $ruta, $tags){

        $parameters = [];
        $parameters['id_cancion'] = NULL;
        $parameters['id_artista'] = $id_artista;
        $parameters['titulo'] = $titulo;
        $parameters['imagen'] = $imagen;
        $parameters['fecha'] = $fecha;
        $parameters['duracion'] = $duracion;
        $parameters['likes'] = 0;
        $parameters['ruta'] = $ruta;
        $parameters['tags'] = $tags;

        return new Cancion($parameters);
    }

    public static function getSongsFromPlaylistID($id_playlist){

        $canciones = [];
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf( "SELECT * FROM cancion C JOIN play_cancion P ON C.id_cancion = P.id_cancion WHERE P.id_playlist = '%d'", $id_playlist);
        $rs = $conection->query($query);

        if(!$rs){
            return false;
        }

        while($fila = $rs->fetch_assoc()){

            $parameters = [];
            $parameters['id_cancion'] = $fila['id_cancion'];
            $parameters['titulo'] = $fila['titulo'];
            $parameters['imagen'] = $fila['imagen'];
            $parameters['fecha'] = $fila['fecha'];
            $parameters['id_artista'] = $fila['id_artista'];
            $parameters['likes'] = $fila['likes'];
            $parameters['ruta'] = $fila['ruta'];
            $parameters['duracion'] = $fila['duracion'];
            $parameters['tags'] = $fila['tags'];

            $canciones[] = new Cancion($parameters);
        }
        $rs->free();

        return $canciones;
    }


    public static function obtenerCancionesporGenero($genero){
        $canciones = [];
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf( "SELECT * FROM cancion C  WHERE C.tags LIKE  '%s' ", "%" . $genero ."%");
        $rs = $conection->query($query);

        if(!$rs){
            return false;
        }

        while($fila = $rs->fetch_assoc()){

            $parameters = [];
            $parameters['id_cancion'] = $fila['id_cancion'];
            $parameters['titulo'] = $fila['titulo'];
            $parameters['imagen'] = $fila['imagen'];
            $parameters['fecha'] = $fila['fecha'];
            $parameters['id_artista'] = $fila['id_artista'];
            $parameters['likes'] = $fila['likes'];
            $parameters['ruta'] = $fila['ruta'];
            $parameters['duracion'] = $fila['duracion'];
            $parameters['tags'] = $fila['tags'];

            $canciones[] = new Cancion($parameters);
        }
        $rs->free();

        return $canciones;
    }


    public static function obtenerCancionesDeArtista($id_artista){
        
        $canciones = [];
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf( "SELECT * FROM cancion C WHERE C.id_artista = '%s'", $id_artista);
        $rs = $conection->query($query);
        
        if(!$rs)
            return false;

        while($fila = $rs->fetch_assoc()){

            $parameters = [];
            $parameters['id_cancion'] = $fila['id_cancion'];
            $parameters['titulo'] = $fila['titulo'];
            $parameters['imagen'] = $fila['imagen'];
            $parameters['fecha'] = $fila['fecha'];
            $parameters['id_artista'] = $fila['id_artista'];
            $parameters['likes'] = $fila['likes'];
            $parameters['ruta'] = $fila['ruta'];
            $parameters['duracion'] = $fila['duracion'];
            $parameters['tags'] = $fila['tags'];

            $canciones[] = new Cancion($parameters);
        }
        $rs->free();

        return $canciones;
    }

    public static function obtenerCancionPorNombre($id_artista, $nombre){
            
        $cancion = false;
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf( "SELECT * FROM cancion C WHERE C.id_artista = '%s' AND C.titulo = '%s'", $id_artista, $nombre);
        $rs = $conection->query($query);
        
        if(!$rs)
            return false;

        if($fila = $rs->fetch_assoc()){

            $parameters = [];
            $parameters['id_cancion'] = $fila['id_cancion'];
            $parameters['titulo'] = $fila['titulo'];
            $parameters['imagen'] = $fila['imagen'];
            $parameters['fecha'] = $fila['fecha'];
            $parameters['id_artista'] = $fila['id_artista'];
            $parameters['likes'] = $fila['likes'];
            $parameters['ruta'] = $fila['ruta'];
            $parameters['duracion'] = $fila['duracion'];
            $parameters['tags'] = $fila['tags'];

            $cancion = new Cancion($parameters);
        }
        $rs->free();

        return $cancion;
    }


    public static function obtenerCancionPorID($id_cancion){
            
        $cancion = false;
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf( "SELECT * FROM cancion C WHERE C.id_cancion = '%d'", $id_cancion);
        $rs = $conection->query($query);
        
        if(!$rs)
            return false;

        if($fila = $rs->fetch_assoc()){

            $parameters = [];
            $parameters['id_cancion'] = $fila['id_cancion'];
            $parameters['titulo'] = $fila['titulo'];
            $parameters['imagen'] = $fila['imagen'];
            $parameters['fecha'] = $fila['fecha'];
            $parameters['id_artista'] = $fila['id_artista'];
            $parameters['likes'] = $fila['likes'];
            $parameters['ruta'] = $fila['ruta'];
            $parameters['duracion'] = $fila['duracion'];
            $parameters['tags'] = $fila['tags'];

            $cancion = new Cancion($parameters);
        }
        $rs->free();

        return $cancion;
    }




    public function crearCancionBD(){

        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO cancion (titulo, imagen, fecha, id_artista, likes, ruta, duracion, tags) 
            VALUES ('%s','%s','%s','%s','%s','%s', '%s', '%s')",
            $this->titulo, $this->imagen, $this->fecha, $this->id_artista, $this->likes, $this->ruta, $this->duracion, $this->tags);

        $result = $conn->query($query);

        if (!$result)
            return false;

        return true;
    }


    public function borrarCancion(){
        unlink(AUDIO_URL . '/' . $this->ruta); 
        $result= false; 
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query= sprintf("DELETE FROM cancion WHERE id_cancion= %d", $this->id_cancion); 

        $result= $conn->query($query); 

        if(!$result)
            error_log($conn->error); 

        return $result; 
    }

    /* Pasar la duracion de la canción de, por ejemplo, 137 segundos a 2:17 */
    public function transformDuration(){

        $minutes = intdiv($this->duracion, 60);
        $seconds = $this->duracion - (60 * $minutes);
        if($seconds < 10)
            $seconds = '0' . $seconds;

        return $minutes . ':' . $seconds;
    }

    public function getIdCancion(){
        return $this->id_cancion;
    }

    public function getIdArtista(){
        return $this->id_artista;
    }

    public function getCancionTitulo(){
        return $this->titulo;
    }

    public function getCancionImagen(){
        return $this->imagen;
    }

    public function getCancionFecha(){
        return $this->fecha;
    }

    public function getCancionDuracion(){
        return $this->duracion;
    }

    public function getCancionLikes(){
        return $this->likes;
    }

    public function getCancionRuta(){
        return $this->ruta;
    }

    public function getCancionTags(){
        return $this->tags;
    }

}