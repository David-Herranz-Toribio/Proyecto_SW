<?php
require_once 'FormularioMultimedia.php';
require_once 'Playlist.php';

class FormularioPlaylist extends FormularioMultimedia{

    private $id_usuario;
    private $id_playlist; 

    public function __construct($id_usuario, $id_playlist) {
        parent::__construct('formCreatePlaylist', ['urlRedireccion' => VIEWS_PATH .'/musica/Musica.php', 'enctype' => 'multipart/form-data']);
        $this->id_usuario = $id_usuario; 
        $this->id_playlist= $id_playlist; 
    }

    protected function generaCamposFormulario(&$datos){

        if(!is_null($this->id_playlist)){
            $legend_text= <<<EOS
            <legend> <strong> Modificar Playlist </strong> </legend>
            EOS; 
            $playlist = SW\classes\Playlist::obtenerPlaylistByID($this->id_playlist); 
            $nombre = $playlist->getPlaylistNombre(); 
            $imagen = $playlist->getPlaylistImagen();
            $imagen_html = "<img src= '" . IMG_PATH . '/songImages/' . $imagen . "' width = '70' height= '70'>"; 
        }

        else {
            $legend_text= <<<EOS
            <legend> <strong>  Crear Playlist </strong>  </legend>
            EOS; 
            $nombre = ''; 
            $imagen = ''; 
            $imagen_html = ''; 
        }


        $defaulImage = IMG_PATH . '/profileImages/FotoPerfil.png';
        $procesarPath = HELPERS_PATH . '/CrearPlaylist.php';

        // Se generan los mensajes de error si existen
        $erroresCampos = self::generaErroresCampos(['imagen', 'nombre'], $this->errores, 'span', array('class' => 'error'));

        $html =<<<EOS
        <fieldset>
        <input type= 'hidden' id= 'id_user' name= 'id_user' value= $this->id_usuario> 
        <input type= 'hidden' name= 'id_playlist' value= $this->id_playlist> 
        <input type= 'hidden' name= "Imagen_antigua" value= $imagen> 
        $legend_text
            <div class="createPlaylistImage">
                <img src=$defaulImage alt="Imagen de la playlist">

                <div class="createPlaylistImageInput">
                    <label> Imagen </label>
                    <input name="imagen" type="file" accept="image/*">
                    {$erroresCampos['imagen']}
                    $imagen_html
                </div>
            </div>

            <div class="createPlaylistConfig">
                <div class="createPlaylistName">
                    <label> Nombre </label>
                    <input name="nombre" id= 'campoNombrePlaylist' type="text" required value= "$nombre">
                    <span id= 'validPlaylist'> </span> 
                    {$erroresCampos['nombre']}
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

        $this->errores = [];

        // Recoger datos
        $nombre = htmlspecialchars($datos['nombre'], ENT_QUOTES);
        $creationDate = new DateTime();
        $creationDate = $creationDate->format('Y-m-d');
        $id_usuario = isset($_SESSION['username']) ? filter_var($_SESSION['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
        $id_playlist = filter_var($datos['id_playlist'], FILTER_SANITIZE_NUMBER_INT); 
        $imagen_ant= htmlspecialchars($datos['Imagen_antigua']); 

        // Validar datos
        if(SW\classes\Playlist::existeNombrePlaylist($id_usuario, $nombre)){
            $this->errores['nombre'] = 'Ya existe una playlist con ese nombre';
        }
        // Verificar que la imagen es adecuada -> archivo imagen, peso máximo, etc...
        if(!isset($datos['imagen']) && $imagen_ant == ''){
            $imagen = 'playlistDefault.png'; 
        }
        else
            $imagen = self::compruebaImagen('imagen', '/songImages/'); 


        // Si hay errores, salimos
        if(count($this->errores) !== 0) { return; }

        
        // Crear playlist en la base de datos
        if($id_playlist != ''){
            $playlist= SW\classes\Playlist::obtenerPlaylistByID($id_playlist);
            $playlist->setPlaylistNombre($nombre); 
            $playlist->setPlaylistImagen($imagen ?? $imagen_ant);
            SW\classes\Playlist::actualizar($playlist);
        }
        else {
            $done = SW\classes\Playlist::crearPlaylistBD($_SESSION['username'], $nombre, $imagen, $creationDate);
            if(!$done){

                $html =<<<EOS
                <div class="creatingPlaylistError">
                    <h2> Ocurrió un error creando la playlist </h2>
                </div>
                EOS;

                return $html;
            }
        }
    }

}