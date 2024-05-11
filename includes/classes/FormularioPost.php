<?php
require_once 'FormularioMultimedia.php'; 
require_once 'Usuario.php'; 
require_once 'Post.php';

class FormularioPost extends FormularioMultimedia
{
    private $id_padre; 
    private $id_post; 

    public function __construct($id_padre, $id_post) {
        parent::__construct('formPublicaPost', ['urlRedireccion' => VIEWS_PATH .'/foro/Foro.php', 'enctype' => 'multipart/form-data']);
        $this->id_padre= $id_padre; 
        $this->id_post= $id_post; 
    }
    
    protected function generaCamposFormulario(&$datos)
    {   
        if(!is_null($this->id_post)){
            $legend_text= <<<EOS
            <legend> <strong> Modificar mensaje </strong> </legend> 
            EOS;

            $post= SW\classes\Post::buscarPostporID($this->id_post); 
            $mensaje= $post->getTexto(); 
            $imagen= $post->getImagen(); 
            $imagen_html=  "<img src='".IMG_PATH . '/postImages/'. $imagen."' width = '70' heigth = '70'>";
        }

        else {
            $legend_text= <<<EOS
            <legend> <strong> Nueva publicación </strong> </legend> 
            EOS; 
            $mensaje= ''; 
            $imagen= ''; 
            $imagen_html= ''; 
        }


        $htmlErroresGlobales =  self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['imagen'], $this->errores, 'span', array('class' => 'error'));
        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
        $legend_text
        <input type = "hidden" name = "id_post" value = $this->id_post>
        <input type = "hidden" name = "id_padre" value = $this->id_padre>
        <input type = "hidden" name = "Imagen_antigua" value = $imagen>
            Mensaje: <textarea name = "post_text"  required style = "resize: none; ">$mensaje</textarea><br><br>

            Imagen:<input type = "file" name = "image" accept = "image/*">
            {$erroresCampos['imagen']}
            $imagen_html
            <br><br><br>
            <button type="submit"> Publicar </button>
        </fieldset>
        EOF;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {   
        $this->errores= []; 
        $username = $_SESSION['username']; 
        $id= filter_var($datos['id_post'], FILTER_VALIDATE_INT);  
        $post_text = isset($datos['post_text']) ? htmlspecialchars($datos['post_text']) : false;  
        $imagen_ant= $datos['Imagen_antigua']; 
        /*TODO Procesar imagen*/ 
        $post_image= self:: compruebaImagen("image", '/postImages/'); 

        if(count($this->errores)===0){

            if($datos['id_padre'] != "") $post_father= $datos['id_padre']; 
            else $post_father = 'NULL'; 


            if($id!=''){
                $post= SW\classes\Post::buscarPostporID($id); 
                $post->setTexto($post_text); 
                $post->setImagen($post_image ?? $imagen_ant); 
                SW\classes\Post::actualizar($post); 
            }    


            else {
                $user=  SW\classes\Usuario::buscaUsuario($username);
                $post = $user->publicarPost($post_text, $post_image, $post_father);

            }
        }
    }
}