<?php

class ListaGenerosMusicales {

    private static $lista = [
    'Pop', 'Rock', 'Hip Hop', 'Jazz', 'Indie' , 'Reggaeton', 
    'J-Pop', 'Dubstep', 'Clásica', 'Disco', 'Funk', 'Techno'];


    // Evitar instanciación de la clase
    private function __construct() {}

    public static function getListaGenerosMusicales(){
        return ListaGenerosMusicales::$lista;
    }

}