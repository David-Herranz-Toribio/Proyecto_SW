<?php

require_once 'Formulario.php';


class FormularioCrearPlaylist extends Formulario{

    private $id_usuario;

    public function __construct($id_usuario) {
        parent::__construct('formCreatePlaylist', ['urlRedireccion' => VIEWS_PATH .'/musica/Musica.php']);
        $this->id_usuario = $id_usuario; 
    }

    protected function generaCamposFormulario(&$datos){

        $defaulImage = IMG_PATH . '/profileImages/FotoPerfil.png';
        $procesarPath = HELPERS_PATH . '/CrearPlaylist.php';

        // Se generan los mensajes de error si existen
        $erroresCampos = self::generaErroresCampos(['imagen', 'nombre'], $this->errores, 'span', array('class' => 'error'));

        $html =<<<EOS
        <fieldset>
        <legend> Crear Playlist </legend>
        <form action=$procesarPath method="post">

            <div class="createPlaylistImage">
                <img src=$defaulImage alt="Imagen de la playlist">

                <div class="createPlaylistImageInput">
                    <label> Imagen </label>
                    <input name="imagen" type="file">
                    {$erroresCampos['imagen']}
                </div>
            </div>

            <div class="createPlaylistConfig">
                <div class="createPlaylistName">
                    <label> Nombre </label>
                    <input name="nombre" type="text" required>
                    {$erroresCampos['nombre']}
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

        // Recoger datos
        $defaultImage = IMG_PATH . '/profileImages/FotoPerfil.png';
        $imagen = isset($_POST['imagen']) && $_POST['imagen'] ? $_POST['imagen'] : $defaultImage;
        $nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES);
        $creationDate = new DateTime();
        $creationDate = $creationDate->format('Y-m-d');
        $id_usuario = $_SESSION['username'];

        // Validar datos
        $this->errores = [];

        if(SW\classes\Playlist::existeNombrePlaylist($id_usuario, $nombre)){
            $this->errores['nombre'] = 'Ya existe una playlist con ese nombre';
        }
        // Verificar que la imagen es adecuada -> archivo imagen, peso máximo, etc...
        if(1){

        }
        // Si hay errores, salimos
        if(count($this->errores) != 0) {return;}


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