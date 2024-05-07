<?php

require_once 'FormularioMultimedia.php';
require_once 'Cancion.php'; 

/*
    Formulario para crear una canción
    Campos:
        - Portada
        - Nombre de la canción
        - Año
        - Género/s
        - Letra (opcional)
        - Archivo de audio
*/
class FormularioCrearCancion extends FormularioMultimedia{

    private $id_artista; 

    public function __construct($id_artista){
        parent::__construct('formCrearCancion', ['urlRedireccion' =>  VIEWS_PATH .'/perfil/Perfil.php', 'enctype' => 'multipart/form-data']);
        $this->id_artista= $id_artista; 
    }

    protected function generaCamposFormulario(&$datos){

        $erroresCampos = self::generaErroresCampos(['cancion','imagen'], $this->errores, 'span', array('class' => 'error'));

        $html =<<<EOS
            <fieldset>
            <input type= 'hidden' name= "id_artista" value= "$this->id_artista">  
            <div class='songImageInput'>
                <label for='songImageInput'> Portada: </label>
                <input type='file' id='songImageInput' name='imagen'>
                {$erroresCampos['imagen']}
            </div>

            <div class='songNameInput'>
                <label for='songNameInput'> Título: </label>
                <input type='text' id='songNameInput' name='titulo' required>
            </div>
            
            <div class='songYearInput'>
                <label for='songYearInput'> Año: </label>
                <input type='text' id='songYearInput' name="fecha">
            </div>

            <div class='songGenres'>
                <label for="genres"> Géneros: </label>
                <select id="genres" name="tags" multiple>
                    <option value="pop"> ... </option>
                    <option value="rock"> Rock </option>
                    <option value="pop"> Pop </option>
                    <option value="jazz"> Jazz </option>
                    <option value="hiphop"> Hip Hop </option>
                    <option value="country"> Country </option>
                </select>
            </div>

            <div class='songAudioFile'>
                <label for='songAudioFileInput'> Audio:  </label>
                <input type='file' id='songAudioFileInput' name="ruta">
                {$erroresCampos['cancion']}
            </div>

            <div class='submitSong'>
                <button> Subir canción </button>
            </div>
        </fieldset> 
        EOS;

        return $html;
    }

    protected function procesaFormulario(&$datos){
        $this->errores= [];
        

        /*La portada de la cancion pasa los filtros*/ 
        $portada= self:: compruebaImagen('imagen', '/songImages/'); 
        /*El archivo de audio de la cancion pasa los filtros*/ 
        
        $cancion= self:: compruebaMusica('ruta', '/'); 
        if(count($this->errores)===0){ //NO HAY ERRORES AL PROCESAR EL FORMULARIO
            $cancion= SW\classes\Cancion:: crearCancion($datos);
        }
    }
}