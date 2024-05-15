<?php
require_once 'Formulario.php'; 

class FormularioMultimedia extends Formulario {

    const EXTENSIONES_IMAGEN = array('gif', 'jpg', 'jpe', 'jpeg', 'png', 'webp', 'avif');
    const EXTENSIONES_SONIDO = array('mp3', 'wav', 'ogg'); 

    public function __construct($id_form, $options= array()) {
        parent::__construct($id_form, $options);
        
    }

    protected function compruebaImagen($idUser, $id, $url)
    {
        
        if ($_FILES[$id]['name'] != ''){
            $archivo_nombre = $_FILES[$id]['name'];
            $archivo_tamaño = $_FILES[$id]['size']/1024;
            $archivo_temporal = $_FILES[$id]['tmp_name'];

            /* Comprobar que la extension está permitida */ 
            $extension = pathinfo($archivo_nombre, PATHINFO_EXTENSION);
            $ok = in_array($extension, self::EXTENSIONES_IMAGEN); 

            //Comprobar que el fichero es efectivamente una imagen 
            $finfo = new finfo(FILEINFO_MIME); 
            $type = $finfo->file($archivo_temporal); 

            $ok = $ok && preg_match('/image\/.+/', $type); 

            if(!$ok){
                $this->errores["imagen"] = "El archivo tiene un nombre o tipo inadecuado"; 
            }

            if(count($this->errores) > 0){
                return -1; 
            }

            // Nombre con extension
            $directorio_destino = IMG_URL . $url;
            $imagen = uniqid() . '.' . $extension;
            $ruta_destino = $directorio_destino . $imagen;
            move_uploaded_file($archivo_temporal, $ruta_destino);

            return $imagen; 
        }
        else
            return NULL; 
    }


    protected function compruebaMusica($id, $url){

        if($_FILES[$id]['name'] != ''){

            $archivo_nombre = $_FILES[$id]['name'];
            $archivo_tamaño_mb = ($_FILES[$id]['size']/1024) /1024;
            $archivo_temporal = $_FILES[$id]['tmp_name'];
            $directorio_destino = AUDIO_URL . $url;

            /* Comprobar que la extension está permitida */ 
            $extension = pathinfo($archivo_nombre, PATHINFO_EXTENSION);
            $ok = in_array($extension, self::EXTENSIONES_SONIDO); 


            //Comprobar que el fichero es efectivamente uno de tipo audio
            $finfo = new finfo(FILEINFO_MIME); 
            $type = $finfo->file($archivo_temporal); 
 
            $ok = $ok && preg_match('/audio\/.+/', $type);

            if(!$ok){
                $this->errores["audio"] = "El archivo tiene un nombre o tipo inadecuado"; 
            }

            else {
                if($archivo_tamaño_mb>40){
                    $this->errores["audio"]= "El archivo pesa demasiado"; 
                }
            }

            if(count($this->errores) > 0){
                return false; 
            }

          
            //Nombre con extension
            $cancion = uniqid() . '.' . $extension;
        
            //Ruta de guardado
            $ruta_destino = $directorio_destino . $cancion;
            move_uploaded_file($archivo_temporal, $ruta_destino);
            
            return $cancion; 
        }

        else{
            $this->errores["audio"] = 'Se requiere un archivo válido (.mp3 o .wav)';
            return false; 
        }

    }

}



