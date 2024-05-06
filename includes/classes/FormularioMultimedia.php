<?php
require_once 'Formulario.php'; 

class FormularioMultimedia extends Formulario {

    const EXTENSIONES_PERMITIDAS = array('gif', 'jpg', 'jpe', 'jpeg', 'png', 'webp', 'avif');

    public function __construct($id_form, $options= array()) {
        parent::__construct($id_form, $options);
        
    }

    protected function procesaFichero($id, $url)
    {
        if ($_FILES[$id]['name'] != ''){
            $archivo_nombre = $_FILES[$id]['name'];
            $archivo_tamaño = $_FILES[$id]['size'];
            $archivo_temporal = $_FILES[$id]['tmp_name'];
        
            $directorio_destino = IMG_URL . $url;
        

            /*Comprobar que la extension está permitida*/ 
            $extension = pathinfo($archivo_nombre, PATHINFO_EXTENSION);
            $ok= in_array($extension, self::EXTENSIONES_PERMITIDAS); 

            //Comprobar que el fichero es efectivamente una imagen 
            $finfo= new finfo(FILEINFO_MIME); 
            $type = $finfo->file($archivo_temporal); 

            $ok= $ok && preg_match('/image\/.+/', $type); 

            if(!$ok){
                $this->errores["imagen"]= "El archivo tiene un nombre o tipo inadecuado"; 
            }

            if(count($this->errores) > 0){
                return -1; 
            }


            //Nombre con extension
            $image = uniqid() . '.' . $extension;
        
            //Ruta de guardado
            $ruta_destino = $directorio_destino . $image;
            move_uploaded_file($archivo_temporal, $ruta_destino);
            
            return $image; 
        }
        else return NULL; 
    }

}



