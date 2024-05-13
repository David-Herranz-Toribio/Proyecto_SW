<?php
require_once 'Formulario.php';
require_once 'Playlist.php';


class FormularioAddCancion_Playlist extends Formulario{

    private $id_cancion;
    private $playlists;

    public function __construct($idCancion, $playlists){
        parent::__construct('formAddCancion_Playlist', ['urlRedireccion' => VIEWS_PATH . '/musica/Musica.php']);
        $this->id_cancion = $idCancion;
        $this->playlists = $playlists;
    }

    protected function generaCamposFormulario(&$datos){

        // Mostrar las playlists del usuario, excepto la de favoritos
        $html =<<<EOS
        <fieldset>
            <label> Selecciona una de tus playlists: </label><br>
            <select name='playlist'>
        EOS;

        foreach($this->playlists as $playlist){
            if($playlist->getPlaylistNombre() != SW\classes\Playlist::$DEFAULT_PLAYLIST){

                $html .=<<<EOS
                <option value={$playlist->getIdPlaylist()}> {$playlist->getPlaylistNombre()} </option>
                EOS;
            }
        }

        $html .=<<<EOS
            </select>
            <button name="addSong"> Añadir a playlist </button>
        </fieldset>
        EOS;

        return $html;
    }

    protected function procesaFormulario(&$datos){

        $playlistID = $datos['playlist'];
        $playlist = SW\classes\Playlist::obtenerPlaylistByID($playlistID);

        // Solo si la canción no está ya en la playlist
        if(!$playlist->existeCancion($this->id_cancion))
            $playlist->addCancion($this->id_cancion);
    }

}