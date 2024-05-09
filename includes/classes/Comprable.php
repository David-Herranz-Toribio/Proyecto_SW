<?php

namespace SW\classes;

abstract class Comprable{

    protected $id;
    protected $nombre;
    protected $descripcion;
    protected $precio;


    protected function __construct($id, $nombre, $descripcion, $precio){
        
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
     
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

    public function getPrecio(){
        return $this->precio;
    }

}
