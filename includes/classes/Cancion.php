<?php

namespace SW\classes;

class Cancion{

    private $id_cancion;
    private $id_artista;
    private $titulo;
    private $imagen;
    private $fecha;
    private $likes;
    private $ruta;
    private $tags;


    public function __construct($parameters){

        $this->id_cancion = $parameters['id_cancion'];
        $this->id_artista = $parameters['id_artista'];
        $this->titulo = $parameters['titulo'];
        $this->imagen = $parameters['imagen'];
        $this->fecha = $parameters['fecha'];
        $this->likes = $parameters['likes'];
        $this->ruta = $parameters['ruta'];
        $this->tags = $parameters['tags'];
    }


    public static function crearCancion($id_artista, $titulo, $imagen, $fecha,$ruta, $tags){

        $parameters = [];
        $parameters['id_cancion'] = NULL;
        $parameters['id_artista'] = $id_artista;
        $parameters['titulo'] = $titulo;
        $parameters['imagen'] = $imagen;
        $parameters['fecha'] = $fecha;
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
            $parameters['tags'] = $fila['tags'];

            $canciones[] = new Cancion($parameters);
        }
        $rs->free();

        return $canciones;
    }


    public static function obtenerCancionesporGenero($genero){

        $canciones = [];
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf( "SELECT * FROM cancion C  WHERE C.tags LIKE  '%s'", "%" . $genero ."%");
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
            $parameters['tags'] = $fila['tags'];

            $canciones[] = new Cancion($parameters);
        }
        $rs->free();

        return $canciones;
    }


    public static function obtenerCancionesDeArtista($id_artista){
        
        $canciones = [];
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf( "SELECT * FROM cancion C WHERE C.id_artista = '%s'", $conection->real_escape_string($id_artista));
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
            $parameters['tags'] = $fila['tags'];

            $canciones[] = new Cancion($parameters);
        }
        $rs->free();

        return $canciones;
    }

    public static function obtenerCancionPorNombre($id_artista, $nombre){
            
        $cancion = false;
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf( "SELECT * FROM cancion C WHERE C.id_artista = '%s' AND C.titulo = '%s'", $conection->real_escape_string($id_artista) , $nombre);
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
            $parameters['tags'] = $fila['tags'];

            $cancion = new Cancion($parameters);
        }
        $rs->free();

        return $cancion;
    }

    // Logica de likes
    public static function insertaFav($cancion, $user){

        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO cancionfav (id_cancion,id_user) VALUES (%d, '%s')",
            $cancion->id_cancion,
            $conn->real_escape_string($user)
        );

        $result = $conn->query($query);

        if (!$result) 
            error_log($conn->error);

        return $result;
    }

    public static function borraFav($cancion, $user){

        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "DELETE FROM cancionfav WHERE (id_cancion = %d AND id_user = '%s')",
            $cancion->id_cancion,
            $conn->real_escape_string($user)
        );

        $result = $conn->query($query);

        if (!$result)  
            error_log($conn->error);

        return $result;
    }

    public function likeAsignado($id, $user){
        $result= true; 
        $conection= Aplicacion::getInstance()->getConexionBd(); 
        $query = sprintf("SELECT * FROM cancionfav C WHERE C.id_cancion = %d AND C.id_user = '%s'", $id , $conection->real_escape_string($user)); 
        $rs= $conection->query($query); 

        if($rs->num_rows == 0)
            $result = false; 

        $rs->free();
        return $result; 
    }

    public function aumentaLikes($num){
        $this->likes +=  $num;
    }

    public function guardaFav(){
        //!$this->id ? self::insertaFav($this, $this->id) : self::actualizar($this);
        return $this;
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
            $parameters['tags'] = $fila['tags'];

            $cancion = new Cancion($parameters);
        }
        $rs->free();

        return $cancion;
    }


    public static function actualizar($cancion){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
    
        $query = sprintf(
            "UPDATE cancion SET titulo= '%s', imagen= '%s', likes= %d WHERE id_cancion = %d",
            $conn->real_escape_string($cancion->titulo),
            $conn->real_escape_string($cancion->imagen),
            $cancion->likes,
            $cancion->id_cancion
        );
    
        $result = $conn->query($query);
    
        if (!$result) 
            error_log($conn->error);
        else if ($conn->affected_rows != 1) 
            error_log("Se han actualizado '$conn->affected_rows' registros!");
    
        return $result;
    }



    public function crearCancionBD(){

        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO cancion (titulo, imagen, fecha, id_artista, likes, ruta, tags) 
            VALUES ('%s','%s','%s','%s',%d,'%s', '%s')",
            $conn->real_escape_string($this->titulo), $conn->real_escape_string($this->imagen), $this->fecha, $conn->real_escape_string($this->id_artista), $this->likes, $this->ruta, $conn->real_escape_string($this->tags));

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