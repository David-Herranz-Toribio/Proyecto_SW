
<?php
require_once 'FormularioMultimedia.php'; 
require_once 'Usuario.php'; 
require_once 'Post.php';

class FormularioRespuesta extends FormularioMultimedia
{
    private $id_padre; 

    public function __construct($id_padre) {
        parent::__construct('formRespuestaPost', ['urlRedireccion' => VIEWS_PATH .'/foro/Foro.php', 'enctype' => 'multipart/form-data']);
        $this->id_padre= $id_padre; 
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $erroresCampos = self::generaErroresCampos(['imagen'], $this->errores, 'span', array('class' => 'error'));
        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        <div class='responder'>
        <input type = "hidden" name = "id_padre" value = "$this->id_padre">
        <details>
            <summary>Responder </summary>
            <label><input type = "text" name = "post_text" required></label><br>
            <label>Imagen:<input type = "file" name = "image" accept = "image/*"></label>
            {$erroresCampos['imagen']}
            <br>
            <button type = "submit">Enviar respuesta</button>
        </details>
        </div> 
        EOF;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $username = filter_var($_SESSION['username'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $post_text = isset($datos['post_text']) ? htmlspecialchars($datos['post_text']) : false;  

        /*TODO Procesar imagen*/ 
        $post_image= self::compruebaImagen('image', '/postImages/'); 

        if(count($this->errores)===0){
            if($datos['id_padre'] != "") $post_father= $datos['id_padre']; 
            else $post_father = 'NULL'; 
    
            $user=  SW\classes\Usuario::buscaUsuario($username);
            $post = $user->publicarPost($post_text, $post_image, $post_father);
        }
       
    }
}