<?php

class ListaGenerosMusicales {


    private static $lista = [
    'Pop', 'Rock', 'Rap', 'Hip Hop', 'Latino', 'Jazz', 'R&B', 'K-Pop', 
    'J-Pop', 'Dubstep', 'Clásica', 'Disco', 'Funk', 'Jazz', 'Reggae', 'Metal'
    ];

    // Evitar instanciación de la clase
    private function __construct() {}


    public static function getListaGenerosMusicales(){
        return ListaGenerosMusicales::$lista;
    }

}