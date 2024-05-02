<?php
require_once 'FormularioMultimedia.php'; 
require_once 'Usuario.php'; 
require_once 'Post.php';

class FormularioPost extends FormularioMultimedia
{
    private $id_padre; 

    public function __construct($id_padre) {
        parent::__construct('formPublicaPost', ['urlRedireccion' => VIEWS_PATH .'/foro/Foro.php', 'enctype' => 'multipart/form-data']);
        $this->id_padre= $id_padre; 
    }
    
    protected function generaCamposFormulario(&$datos)
    {

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        <fieldset>
        <legend ><strong> Nueva Publicación </strong></legend>
            <input type = "hidden" name = "id_padre" value = "$this->id_padre">
            Mensaje: <textarea name = "post_text" required style = "resize: none; "></textarea><br><br>
            Imagen:<input type = "file" name = "image" accept = "image/*">
            <br><br><br>
            <button type="submit"> Publicar </button>
        </fieldset>
        EOF;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $username = $_SESSION['username']; 
        $post_text = isset($datos['post_text']) ? htmlspecialchars($datos['post_text']) : false;  

        /*TODO Procesar imagen*/ 
        $post_image= self:: procesaFichero("image", '/postImages/'); 

        if($datos['id_padre'] != "") $post_father= $datos['id_padre']; 
        else $post_father = 'NULL'; 

        $user=  SW\classes\Usuario::buscaUsuario($username);
        $post = $user->publicarPost($post_text, $post_image, $post_father);
    }
}