
<?php
require_once 'Formulario.php'; 
require_once 'Usuario.php'; 
require_once 'Post.php';

class FormularioRespuesta extends Formulario
{
    private $id_padre; 

    public function __construct($id_padre) {
        parent::__construct('formRespuestaPost', ['urlRedireccion' => VIEWS_PATH .'/foro/Foro.php']);
        $this->id_padre= $id_padre; 
    }
    
    protected function generaCamposFormulario(&$datos)
    {

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        <div class='responder'>
        <input type = "hidden" name = "id_padre" value = "$this->id_padre">
        <details>
            <summary>Responder &#10149; </summary>
            <label>Respuesta:<input type = "text" name = "post_text" required></label><br>
            <label>Imagen:<input type = "file" name = "image" accept = "image/*"></label><br>
            <button type = "submit">Enviar respuesta</button>
        </details>
        </div> 
        EOF;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $username = $_SESSION['username']; 
        $post_text = isset($datos['post_text']) ? htmlspecialchars($datos['post_text']) : false;  

        /*TODO Procesar imagen*/ 

        if($datos['id_padre'] != "") $post_father= $datos['id_padre']; 
        else $post_father = 'NULL'; 

        $user=  SW\classes\Usuario::buscaUsuario($username);
        $post = $user->publicarPost($post_text, $post_image, $post_father);
    }
}