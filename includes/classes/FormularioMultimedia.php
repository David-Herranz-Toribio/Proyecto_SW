<?php
require_once 'Formulario.php'; 

class FormularioMultimedia extends Formulario {

    public function __construct($id_form, $options= array()) {
        parent::__construct($id_form, $options);
        
    }

    protected function procesaFichero($id, $url)
    {
        if ($_FILES[$id]['name'] != ''){
            $archivo_nombre = $_FILES[$id]['name'];
            $archivo_tipo = $_FILES[$id]['type'];
            $archivo_tamaño = $_FILES[$id]['size'];
            $archivo_temporal = $_FILES[$id]['tmp_name'];
        
            $directorio_destino = IMG_URL . $url;
        
            //Nombre con extension
            $ultimo_punto = strrpos($archivo_nombre, '.');
            $extension = substr($archivo_nombre, $ultimo_punto + 1);
            $image = uniqid() . '.' . $extension;
        
            //Ruta de guardado
            $ruta_destino = $directorio_destino . $image;
            move_uploaded_file($archivo_temporal, $ruta_destino);
            return $image; 
        }
        else return NULL; 
    }
}



