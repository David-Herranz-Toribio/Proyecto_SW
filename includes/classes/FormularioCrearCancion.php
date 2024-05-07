<?php

require_once 'FormularioMultimedia.php';
require_once 'Cancion.php'; 

/*
    Formulario para crear una canción
    Campos:
        - Nombre de la canción
        - Género/s
        - Letra (opcional)
        - Archivo de audio
*/
class FormularioCrearCancion extends FormularioMultimedia{

    private $id_artista;
    private $id_playlist;

    public function __construct($id_artista, $id_playlist){
        parent::__construct('formCrearCancion', ['urlRedireccion' =>  VIEWS_PATH .'/perfil/Perfil.php', 'enctype' => 'multipart/form-data']);
        $this->id_artista = $id_artista;
        $this->id_playlist = $id_playlist;
    }

    protected function generaCamposFormulario(&$datos){

        $erroresCampos = self::generaErroresCampos(['titulo', 'fecha', 'tags', 'audio'], $this->errores, 'span', array('class' => 'error'));

        $html =<<<EOS
        <fieldset>
            <input type='hidden' name='id_artista' value='$this->id_artista'>
            <input type='hidden' name='id_playlist' value='$this->id_playlist'>

            <div class='songNameInput'>
                <label for='songNameInput'> Título: </label>
                <input type='text' id='songNameInput' name='titulo' required>
                {$erroresCampos['titulo']}
            </div>
            
            <div class='songYearInput'>
                <label for='songYearInput'> Año: </label>
                <input type='date' id='songYearInput' name="fecha">
                {$erroresCampos['fecha']}
            </div>

            <div class='songGenres'>
                <label for="genres"> Géneros: </label>
                <select id="genres" name='tags' multiple>
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
                {$erroresCampos['audio']}
            </div>

            <div class='submitSong'>
                <button> Subir canción </button>
            </div>
        </fieldset> 
        EOS;

        return $html;
    }

    protected function procesaFormulario(&$datos){

        $this->errores = [];
        /* El nombre no existe ya dentro del album */

        /* El archivo de audio de la cancion pasa los filtros */ 
        $cancion = self::compruebaMusica('ruta', '/');

        if(count($this->errores) === 0){

            // Obtener parametros
            $titulo = $datos['titulo'];
            $fecha = $datos['fecha'];
            $ruta = 'cancionPrueba.mp3';
            $tags = $datos['tags'];
            $imagen = SW\classes\Playlist::obtenerPlaylistByID($this->id_playlist)->getPlaylistImagen();

            // Crear objeto en la base de datos
            $cancion = SW\classes\Cancion::crearCancion($titulo, $imagen, $fecha, $ruta, $tags);
            $cancion->crearCancionBD();

            // Relacionar playlist y cancion en la base de datos
        }
    }
}