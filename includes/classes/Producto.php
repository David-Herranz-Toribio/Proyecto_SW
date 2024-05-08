<?php

namespace SW\classes;

class Producto{

    private $id;
    private $nombre;
    private $descripcion;
    private $imagen;
    private $autor;
    private $stock;
    private $precio;
    private $cantidadPP;//Cantidad de productos por pedido


    private function __construct($id, $nombre, $descripcion, $imagen, $autor, $stock, $precio, $cantidadPP){
        
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->imagen = $imagen;
        $this->autor = $autor;
        $this->stock = $stock;
        $this->precio = $precio;
        $this->cantidadPP = $cantidadPP;
     
    }

    public static function crearProducto($id, $nombre, $descripcion, $imagen, $autor, $stock, $precio, $cantidadPP = NULL){
        return new Producto($id, $nombre, $descripcion, $imagen, $autor, $stock, $precio, $cantidadPP);
    }
    
    public static function insertarSuscripcion($username, $tipo, $fecha){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();

        $fecha_fin = new \DateTime($fecha);
        if($tipo == 'mensual'){
            $fecha_fin->add(new \DateInterval('P1M'));
        }else if($tipo == 'anual'){
            $fecha_fin->add(new \DateInterval('P1Y'));
        }

        $query = sprintf(
            "INSERT INTO suscripcion (id_user, tipo, fecha_fin)
                       VALUES ('%s','%s', '%s')",
            $conn->real_escape_string($username),
            $conn->real_escape_string($tipo),
            $conn->real_escape_string($fecha_fin->format('Y-m-d'))
        );

        $result = $conn->query($query);

        if (!$result)  
            error_log($conn->error);

        return $result;
    }

    public static function archivarSuscripcion($username){
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
    public static function obtenerProductosDeArtista($username){

        $result = [];
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf( "SELECT * FROM producto P WHERE P.id_artista = '%s'", $username);
        $rs = $conection->query($query);
        
        while($fila = $rs->fetch_assoc()){
            $result[] = self::crearProducto($fila['id_prod'],$fila['nombre'], $fila['descripcion'], 
                                            $fila['imagen'], $fila['id_artista'], $fila['stock'], $fila['precio']);
        }
        $rs->free();

        return $result;
    }

    public static function obtenerProductoporId($id){
        $result = [];
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM producto WHERE id_prod = ". $id;
        $rs = $conection->query($query);
        
        $fila = $rs->fetch_assoc();
        $result = self::crearProducto($fila['id_prod'],$fila['nombre'], $fila['descripcion'], 
                                            $fila['imagen'], $fila['id_artista'], $fila['stock'], $fila['precio']);
        
        $rs->free();

        return $result;
    }

    public static function obtenerListaDeProductos(){
        $result = [];
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM producto";
        $rs = $conection->query($query);
        
        while($fila = $rs->fetch_assoc()){
            $result[] = self::crearProducto($fila['id_prod'],$fila['nombre'], $fila['descripcion'], 
                                            $fila['imagen'], $fila['id_artista'], $fila['stock'], $fila['precio']);
        }
        $rs->free();

        return $result;
    }

    public static function obtenerProductosDePedido($id){
        $result = [];
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf( "SELECT * FROM producto P JOIN pedido_prod PP ON P.id_prod = PP.id_prod WHERE PP.id_pedido = %d", $id);
        $rs = $conection->query($query);
        
        while($fila = $rs->fetch_assoc()){
            $result[] = self::crearProducto($fila['id_prod'],$fila['nombre'], $fila['descripcion'], 
                                            $fila['imagen'], $fila['id_artista'], $fila['stock'], $fila['precio'], $fila['cantidad']);
        }
        $rs->free();

        return $result;
    }



    public static function buscarProductoPorID($id){

        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM producto P WHERE P.id_prod = %d",  $id);
        $rs = $conection->query($query);
       
        while($fila = $rs->fetch_assoc()){
            $result = self::crearProducto($fila['id_prod'], $fila['nombre'], $fila['descripcion'], 
                                          $fila['imagen'], $fila['id_artista'], $fila['stock'], $fila['precio']);
        }
        $rs->free();

        return $result;
    }

    public static function LupaNombreProductoExistentes($productos, $textoBusqueda) {
        $result = [];
        foreach ($productos as $producto) {
            if (stripos($producto->getNombre(), $textoBusqueda) !== false) { 
                $result[] = $producto; 
            }
        }
        return $result;
    }

    public function borrarProducto(){
        if ($this->imagen != 'FotoMerch.png')
            unlink(IMG_URL . '/prodImages/'. $this->imagen);

        
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM producto WHERE id_prod = %d", $this->id);



        $result = $conn->query($query);

        if (!$result)  
            error_log($conn->error);

        return $result;
    }

    public static function inserta($producto){

        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf(
            "INSERT INTO producto (nombre, descripcion, imagen, id_artista, stock, precio)
                       VALUES ('%s','%s', '%s', '%s', %d, %d)",
            $conn->real_escape_string($producto->nombre),
            $conn->real_escape_string($producto->descripcion),
            is_null($producto->imagen) ? 'NULL' : $conn->real_escape_string($producto->imagen),
            $conn->real_escape_string($producto->autor),
            $producto->stock,
            $producto->precio,
        );

        $result = $conn->query($query);

        if ($result) {
            $producto->id = $conn->insert_id;
            $result = $producto;
        }
        else 
            error_log($conn->error);

        return $result;
    }

    public static function actualiza($producto){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
    
        $query = sprintf(
            "UPDATE producto SET nombre = '%s', descripcion = '%s', imagen = '%s', stock = %d, precio = %f WHERE id_prod = %d",
            $conn->real_escape_string($producto->nombre),
            $conn->real_escape_string($producto->descripcion),
            $conn->real_escape_string($producto->imagen),
            $producto->stock,
            $producto->precio,
            $producto->id
        );
    
        $result = $conn->query($query);
    
        if (!$result) 
            error_log($conn->error);
        else if ($conn->affected_rows != 1) 
            error_log("Se han actualizado '$conn->affected_rows' registros!");
    
        return $result;
    }

    public function guarda(){

        if (!$this->id) 
            self::inserta($this);
        else 
            self::actualiza($this);

        return $this;
    }

    
    public function setStock($valor){
        $this->stock = $valor;
    }

    public function getId(){
        return $this->id;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

    public function getImagen(){
        return $this->imagen;
    }

    public function getAutor(){
        return $this->autor;
    }
    
    public function getStock(){
        return $this->stock;
    }

    public function getPrecio(){
        return $this->precio;
    }
    public function getCantidadPP(){
        return $this->cantidadPP;
    }
}
