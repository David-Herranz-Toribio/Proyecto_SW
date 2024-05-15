<?php

require_once 'FormularioMultimedia.php';
require_once 'Playlist.php';


/*

    Formulario para crear un album == Playlist
    Campos:
        - Portada
        - Nombre del album
        - Año
*/
class FormularioCrearAlbum extends FormularioMultimedia{

    private $id_usuario;

    public function __construct($id_usuario) {
        parent::__construct('formCreateAlbum', ['urlRedireccion' => VIEWS_PATH .'/musica/Musica.php',  'enctype' => 'multipart/form-data']);
        $this->id_usuario = $id_usuario;
    }

    protected function generaCamposFormulario(&$datos){

        $defaulImage = IMG_PATH . '/profileImages/FotoPerfil.png';
        $procesarPath = HELPERS_PATH . '/CrearPlaylist.php';

        // Se generan los mensajes de error si existen
        $erroresCampos = self::generaErroresCampos(['imagen', 'nombre', 'fecha'], $this->errores, 'span', array('class' => 'error'));
        
        $html =<<<EOS
        <fieldset>
        <legend> Crear Album </legend>
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

                <div class="createPlaylistYear">
                    <label> Fecha </label>
                    <input name="date" type="date" required>
                    {$erroresCampos['fecha']}
                </div>
            </div>

            <div>
                <button type="submit"> Crear </button>
            </div>
        </fieldset>
        EOS;

        return $html;
    }

    protected function procesaFormulario(&$datos){
        
        // Validar datos
        $this->errores = [];
        // Obtener datos
        $defaulImage = IMG_PATH . '/profileImages/FotoPerfil.png';
        $nombre = htmlspecialchars($datos['nombre']);
        $id_usuario = filter_var($_SESSION['username'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $creationDate = new \DateTime($datos['date']);
        $today = new \DateTime();

        $imagen = !isset($datos['imagen']) ? self::compruebaImagen($nombre ,'imagen', '/songImages/') : 'FotoPerfil.png';


        
        

     
        $today_num = intval(date("Ymd", strtotime($today->format('Y-m-d'))));
        $date_num = intval(date("Ymd", strtotime($creationDate->format('Y-m-d'))));

        if(SW\classes\Playlist::existeNombrePlaylist($id_usuario, $nombre)){
            $this->errores['nombre'] = 'Ya existe un album con ese nombre';
        }
        if($date_num > $today_num){
            $this->errores['fecha'] = 'La fecha debe ser anterior al dia actual';
        }
        if(0){
            $this->errores['imagen'] = 'La imagen no es válida';
        }
        if(count($this->errores) != 0) { return; }

        
        // Crear album en la base de datos
        $done = SW\classes\Playlist::crearPlaylistBD($_SESSION['username'], $nombre, $imagen, $creationDate->format('Y-m-d'));
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