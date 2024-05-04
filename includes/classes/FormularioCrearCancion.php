<?php

require_once 'Formulario.php';


/*
    Formulario para crear una canción
    Campos:
        - Nombre de la canción
        - Año
        - Género/s
        - Letra (opcional)
        - Portada
        - Archivo de audio
*/
class FormularioCrearCancion extends Formulario{

    public function __construct(){
        parent::__construct('formCrearCancion', ['urlRedireccion' =>  VIEWS_PATH .'/perfil/Perfil.php']);
    }

    protected function generaCamposFormulario(&$datos){

        
    }

    protected function procesaFormulario(&$datos){
        
    }
}