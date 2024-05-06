<?php
require_once 'FormularioMultimedia.php'; 
require_once 'Usuario.php'; 
require_once 'Post.php';


class FormularioModificacionPost extends FormularioMultimedia {

    private $id_post; 

    public function __construct($id_post) {
        parent::__construct('formModificarPost', ['urlRedireccion' =>  VIEWS_PATH .'/foro/Foro.php', 'enctype' => 'multipart/form-data']);
        $this->id_post= $id_post;
    }

    protected function generaCamposFormulario(&$datos){

        $post = SW\classes\Post::buscarPostPorID($this->id_post);
        $postText= $post->getTexto(); 

        $erroresCampos = self::generaErroresCampos(['imagen'], $this->errores, 'span', array('class' => 'error'));

        $camposForm= <<<EOF
            <fieldset>
            <legend><strong> Modificacion </strong></legend>
            <input type = "hidden" name = "id" value = $this->id_post>
            Mensaje: <textarea name = "postText" required style = "resize: none;">$postText</textarea><br><br>
            <label>Imagen:<input type = "file" name = "image" accept = "image/*"></label>
            {$erroresCampos['imagen']}
            <br><br>
            <button type = "submit"> Publicar </button> 
        </fieldset>
        EOF; 

        return $camposForm;
    }

    protected function procesaFormulario(&$datos){
        $this->errores = [];

        $id = $datos['id'];
        $tx = htmlspecialchars($datos['postText']);

        $post = SW\classes\Post::buscarPostPorID($id);
       

        /*TODO Procesar imagen*/ 
        $post_image= self:: procesaFichero("image", '/postImages/'); 
        if($post_image!=NULL && $post_image!=-1){
            $post->setImagen($post_image); 
        }
        if(count($this->errores)===0){
            $post->setTexto($tx);
            SW\classes\Post::actualizar($post);
        }
    }   
}