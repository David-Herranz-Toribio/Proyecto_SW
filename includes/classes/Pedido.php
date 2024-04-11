<?php
namespace es\ucm\fdi\aw;

require_once 'Aplicacion.php';

class Pedido{

    private $id;
    private $autor;
    private $estado;
    private $total;
    private $fecha;


    private function __construct($id, $autor, $estado, $total, $fecha){
        $this->id = $id;
        $this->autor = $autor;
        $this->estado = $estado;
        $this->total = $total;
        $this->fecha = $fecha;
    }

    public static function crearPedido($id, $autor, $estado, $total, $fecha){
        return new Pedido($id, $autor, $estado, $total, is_null($fecha) ? self::generateDate() : $fecha);
    }


    public static function buscarPedidoPorUser($id){

        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM pedido P WHERE P.id_user = '%s' AND P.estado = 'En proceso'" ,  $id);
        $rs = $conection->query($query);
        
        $fila = $rs->fetch_assoc();
        if ($fila)
            $result = self::crearPedido($fila['id_pedido'], $fila['id_user'], $fila['estado'], 
                                        $fila['total'], $fila['fecha']);
        else
            $result = false;
        
        $rs->free();

        return $result;
    }
    
    public static function actualiza($pedido){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
    
        $query = sprintf(
            "UPDATE pedido SET  estado = '%s', total = %f, fecha = '%s' WHERE id_pedido = %d",
            $conn->real_escape_string($pedido->estado),
            $pedido->total,
            self::generateDate(),
            $pedido->id
        );
        
    
        $result = $conn->query($query);
    
        if (!$result) 
            error_log($conn->error);
        else if ($conn->affected_rows != 1) 
            error_log("Se han actualizado '$conn->affected_rows' registros!");
    
        return $pedido;
    }

    public static function inserta($pedido){

        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO pedido (id_user, estado, total, fecha) VALUES ('%s', '%s', %d, '%s')",
            $pedido->autor,
            $pedido->estado,
            $pedido->total,
            self::generateDate()
        );

        $result = $conn->query($query);

        if ($result) {
            $pedido->id = $conn->insert_id;
            $result = $pedido;
        }
        else 
            error_log($conn->error);

        return $result;
    }


    public static function quitarProductoPP($producto, $id_pedido){

        $id_prod = $producto->getId();
        $cantidad = self::consultaPP($id_pedido, $id_prod);
        $conn = Aplicacion::getInstance()->getConexionBd();
        $result = false;

        if($cantidad == 1){
            $query = sprintf( "DELETE FROM pedido_prod WHERE id_pedido = %d AND id_prod = %d ", $id_pedido, $id_prod );
            $result = true;
        }else             
            $query = sprintf("UPDATE pedido_prod SET cantidad = %d WHERE id_pedido = %d AND id_prod = %d ", $cantidad - 1, $id_pedido, $id_prod );

        $rs = $conn->query($query);

        if (!$rs)  
            error_log($conn->error);


        return $result;

    }

    public static function insertaPP($id_ped, $id_prod, $cant){

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO pedido_prod (id_pedido, id_prod, cantidad) VALUES (%d, %d, %d)",
            $id_ped, 
            $id_prod, 
            $cant
        );
        $result = $conn->query($query);

        if (!$result)
            error_log($conn->error);

        return $result;
    }

    //Busca en la tabla pedido_prod un pedido y un producto con ids y si lo encuentra devuelve la cantidad de productos asignados
    public static function consultaPP($id_ped, $id_prod){

        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM pedido_prod P WHERE P.id_pedido = %d AND P.id_prod = %d", $id_ped, $id_prod);
        $rs = $conection->query($query);
        
        $fila = $rs->fetch_assoc();
        if ($fila)
            $result = $fila['cantidad'];
        else
            $result = false;
        
        $rs->free();

        return $result;
    }

    public static function numProdporUserPP($username){

        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT COUNT(*) AS num FROM pedido_prod PP JOIN pedido P ON PP.id_pedido = P.id_pedido WHERE P.id_user = '%s' AND P.estado = 'En proceso'", $username);
        $rs = $conection->query($query);
        
        $fila = $rs->fetch_assoc();
        if ($fila)
            $result = $fila['num'];
        else
            $result = false;
        
        $rs->free();

        return $result;
    }
    
    public static function actualizaPP($id_ped, $id_prod, $cant){
        
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
    
        $query = sprintf(
            "UPDATE pedido_prod SET cantidad = %d WHERE id_pedido = %d AND id_prod = %d",
            $cant,
            $id_ped,
            $id_prod
        );
    
        $result = $conn->query($query);
    
        if (!$result) 
            error_log($conn->error);
        else if ($conn->affected_rows != 1) 
            error_log("Se han actualizado '$conn->affected_rows' registros!");
    
        return $result;
    }



    private static function generateDate(){

        $date = getdate();
        $day = $date['mday'];
        $month = $date['mon'];
        $year = $date['year'];

        return  $year ."-" . $month  .  "-" .$day;
    }

    public function setId($value){
         $this->id = $value;
    }

    public function setAutor($value){
         $this->autor = $value;
    }

    public function setEstado($value){
         $this->estado = $value;
    }

    public function setTotal($value){
         $this->total = $value;
    }
    
    public function setFecha($value){
         $this->fecha = $value;
    }

    public function getId(){
        return $this->id;
    }

    public function getAutor(){
        return $this->autor;
    }

    public function getEstado(){
        return $this->estado;
    }

    public function getTotal(){
        return $this->total;
    }
    
    public function getFecha(){
        return $this->fecha;
    }

}