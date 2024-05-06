<?php

require_once 'Formulario.php';


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
class FormularioCrearCancion extends Formulario{

    public function __construct(){
        parent::__construct('formCrearCancion', ['urlRedireccion' =>  VIEWS_PATH .'/perfil/Perfil.php']);
    }

    protected function generaCamposFormulario(&$datos){

        $html =<<<EOS
        <form>
            <div class='songImageInput'>
                <label for='songImageInput'> Subir portada: </label>
                <input type='file' id='songImageInput' name='songImage'>
            </div>

            <div class='songNameInput'>
                <label for='songNameInput'> Nombre de la canción: </label>
                <input type='text' id='songNameInput' name='songImage' required>
            </div>
            
            <div class='songYearInput'>
                <label for='songYearInput'> Año: </label>
                <input type='text' id='songYearInput' name='songYear'>
            </div>

            <div class='songGenres'>
                <label for="genres"> Choose genres: </label>
                <select id="genres" name="genres[]" multiple>
                    <option value="pop"> ... </option>
                    <option value="rock"> Rock </option>
                    <option value="pop"> Pop </option>
                    <option value="jazz"> Jazz </option>
                    <option value="hiphop"> Hip Hop </option>
                    <option value="country"> Country </option>
                </select>
            </div>

            <div class='songLyrics'>
                <label for='songLyrics'> Letra: </label>
                <textarea id='songLyrics' name='songLyrics' rows='4' cols='50'></textarea>
            </div>

            <div class='songAudioFile'>
                <label for='songAudioFileInput'> Audio audio: </label>
                <input type='file' id='songAudioFileInput   ' name='songAudioFile'>
            </div>

            <div class='submitSong'>
                <button> Subir canción </button>
            </div>
        </form>
        EOS;

        return $html;
    }

    protected function procesaFormulario(&$datos){
        
    }
}