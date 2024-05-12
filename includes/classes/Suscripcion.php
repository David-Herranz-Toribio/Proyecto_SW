<?php

namespace SW\classes;
require_once 'Comprable.php';


class Suscripcion extends Comprable{


    private $fecha;


    private function __construct($id, $nombre, $fecha, $descripcion){
        $precio = 0;
        if($nombre == 'mensual'){
            $precio = 5;
        }else if($nombre == 'anual'){
            $precio = 50;
        }
        parent::__construct($id, $nombre, $descripcion, $precio);
        $this->fecha = $fecha;    
    }

    public static function crearSuscripcion($id, $nombre, $fecha, $descripcion){
        return new Suscripcion($id, $nombre, $fecha, $descripcion);
    }

    public static function tieneSub($id_u) {

        $result = true;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM suscripcion WHERE id_user = '%s'", $conn->real_escape_string($id_u)); 
        $rs = $conn->query($query);  

        if($rs->num_rows == 0)
            $result = null;
        else{
            $fecha = $rs->fetch_assoc()['fecha_fin'];
            if($fecha < date('Y-m-d H:i:s')){
                $result = null;
                self::eliminarSuscripcion($id_u);
            }
        }

        $rs->free();
        return $result; 
    }

    public static function actualizarSuscripcion($fecha){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "DELETE FROM suscripcion WHERE fecha_fin < '%s'",
            $conn->real_escape_string($fecha)
        );

        $result = $conn->query($query);

        if (!$result)  
            error_log($conn->error);

        return $result;
        
   
    }

    public static function insertarSuscripcion($username, $nombre, $fecha){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();

        $fecha_fin = new \DateTime($fecha);
        
        $query = sprintf(
            "INSERT INTO suscripcion (id_user, tipo, fecha_fin)
                       VALUES ('%s','%s', '%s')",
            $conn->real_escape_string($username),
            $conn->real_escape_string($nombre),
            $conn->real_escape_string($fecha_fin->format('Y-m-d H:i:s'))
        );

        $result = $conn->query($query);

        if (!$result)  
            error_log($conn->error);

        return $result;
    }

    public static function getFechaExpiracion($username){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf(
            "SELECT fecha_fin FROM suscripcion WHERE id_user = '%s'",
            $conn->real_escape_string($username)
        );

        $rs = $conn->query($query);

        if (!$rs)  
            error_log($conn->error);
        if ($rs->num_rows > 0)
            $result = $rs->fetch_assoc()['fecha_fin'];
        return $result;
    }

    public static function eliminarSuscripcion($username){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf(
            "DELETE FROM suscripcion WHERE id_user = '%s'",
            $conn->real_escape_string($username)
        );

        $result = $conn->query($query);

        if (!$result)  
            error_log($conn->error);

        return $result;
    }


    public function getId(){
        return $this->id;
    }

    public function getNombre(){
        return $this->nombre;
    }
}
