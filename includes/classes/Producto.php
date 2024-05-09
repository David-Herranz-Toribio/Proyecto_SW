<?php

namespace SW\classes;
require_once 'Comprable.php';

class Producto extends Comprable{

   
    private $imagen;
    private $autor;
    private $stock;


    private function __construct($id, $nombre, $descripcion, $imagen, $autor, $stock, $precio){
        parent::__construct($id, $nombre, $descripcion, $precio);
        $this->imagen = $imagen;
        $this->autor = $autor;
        $this->stock = $stock;
     
    }

    public static function crearProducto($id, $nombre, $descripcion, $imagen, $autor, $stock, $precio){
        return new Producto($id, $nombre, $descripcion, $imagen, $autor, $stock, $precio);
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
        
        $prod_cant = new \stdClass();
        while($fila = $rs->fetch_assoc()){
            $prod_cant->producto = self::crearProducto($fila['id_prod'],$fila['nombre'], $fila['descripcion'], 
                                            $fila['imagen'], $fila['id_artista'], $fila['stock'], $fila['precio']);
            $prod_cant->cantidad = $fila['cantidad'];
            $result[] = $prod_cant;
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

    public function getImagen(){
        return $this->imagen;
    }

    public function getAutor(){
        return $this->autor;
    }
    
    public function getStock(){
        return $this->stock;
    }


}
