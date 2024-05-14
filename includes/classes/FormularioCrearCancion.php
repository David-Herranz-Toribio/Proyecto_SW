<?php
require_once 'ListaGenerosMusicales.php';
require_once 'FormularioMultimedia.php';
require_once 'Cancion.php';
require_once 'Playlist.php';

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
        parent::__construct('formCrearCancion', ['urlRedireccion' =>  VIEWS_PATH . "/musica/PlaylistView.php?id=$id_playlist", 'enctype' => 'multipart/form-data']);
        $this->id_artista = $id_artista;
        $this->id_playlist = $id_playlist;
    }

    protected function generaCamposFormulario(&$datos){

        $erroresCampos = self::generaErroresCampos(['titulo', 'fecha', 'tags', 'audio'], $this->errores, 'span', array('class' => 'error'));
        
        $opciones_musica = '';
        foreach(ListaGenerosMusicales::getListaGenerosMusicales() as $genero){
            $opciones_musica .=<<<EOS
            <option value=$genero> $genero </option>
            EOS;
        }

        $html =<<<EOS
        <fieldset>
            <input type='hidden' name='id_artista' value='$this->id_artista'>
            <input type='hidden' name='id_playlist' value='$this->id_playlist'>

            <div class='songNameInput'>
                <label for='songNameInput'> Título: </label>
                <input type='text' id='songNameInput' name='titulo' required>
                {$erroresCampos['titulo']}
            </div>
            
            <div class='songGenres'>
                <label for="genres"> Géneros: </label>
                <select id="genres" name='tags' multiple>
                    <option value="none"> ... </option>
                    $opciones_musica
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

        $playlist = SW\classes\Playlist::obtenerPlaylistByID($this->id_playlist);
        /* El archivo de audio de la cancion pasa los filtros */ 
        
        $audio = self::compruebaMusica('ruta', '/');

        // Obtener parametros
        $titulo = $datos['titulo'];
       
        $duracion = 0;
        $tags = $datos['tags'];

        $playlist = SW\classes\Playlist::obtenerPlaylistByID($this->id_playlist);

        if($playlist->comprobarNombreCancion($titulo)){
            $this->errores['titulo']= "Ya hay una canción con este título en la playlist"; 
        }
        $imagen = $playlist->getPlaylistImagen();


        if(count($this->errores)==0){
            // Crear objeto en la base de datos
            $cancion = SW\classes\Cancion::crearCancion($this->id_artista, $titulo, $imagen, $playlist->getPlaylistCreationDate(), $audio, $tags);

            $ok = $cancion->crearCancionBD();

            // Relacionar playlist y cancion en la base de datos SOLO si se ha creado correctamente la cancion
            if($ok){
                $cancion = \SW\classes\Cancion::obtenerCancionPorNombre($this->id_artista, $titulo);
                $playlist->addCancion($cancion->getIdCancion());
            }
        }

      
    }
}