<?php

require_once 'Formulario.php';
require_once 'Playlist.php';

class FormularioCrearPlaylist extends Formulario{

    private $id_usuario;

    public function __construct($id_usuario) {
        parent::__construct('formCreatePlaylist', ['urlRedireccion' => VIEWS_PATH .'/musica/Musica.php']);
        $this->id_usuario = $id_usuario; 
    }

    protected function generaCamposFormulario(&$datos){

        $defaulImage = IMG_PATH . '/profileImages/FotoPerfil.png';
        $procesarPath = HELPERS_PATH . '/CrearPlaylist.php';

        $html =<<<EOS
        <fieldset>
        <legend> Crear Playlist </legend>
        <form action=$procesarPath method="post">

            <div class="createPlaylistImage">
                <img src=$defaulImage alt="Imagen de la playlist">

                <div class="createPlaylistImageInput">
                    <label> Imagen </label>
                    <input name="imagen" type="file">
                </div>
            </div>

            <div class="createPlaylistConfig">
                <div class="createPlaylistName">
                    <label> Nombre </label>
                    <input name="nombre" type="text" required>
                </div>
            </div>

            <div>
                <button type="submit"> Crear </button>
            </div>
        </form>
        </fieldset>
        EOS;

        return $html;
    }

    protected function procesaFormulario(&$datos){

        $imagen = isset($_POST['imagen']) && $_POST['imagen'] ? $_POST['imagen'] : IMG_PATH . '/profileImages/FotoPerfil.png';
        $nombre = $_POST['nombre'];
        $creationDate = new DateTime();
        $creationDate = $creationDate->format('Y-m-d');

        // Crear playlist en la base de datos
        $done = SW\classes\Playlist::crearPlaylistBD($_SESSION['username'], $nombre, $imagen, $creationDate);
        if(!$done){

            $html =<<<EOS
            <div class="creatingPlaylistError">
                <h2> Ocurrió un error creando la playlist </h2>
            </div>
            EOS;

            return $html;
        }

        header('Location: ' . VIEWS_PATH . '/musica/Musica.php');
        exit();
    }

}