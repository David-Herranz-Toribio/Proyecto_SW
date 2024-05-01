<?php
require_once 'Formulario.php'; 
require_once 'Usuario.php'; 
require_once 'Post.php';


class FormularioModificacionPost extends Formulario {

    private $id_post; 

    public function __construct($id_post) {
        parent::__construct('formModificarPost', ['urlRedireccion' =>  VIEWS_PATH .'/foro/Foro.php']);
        $this->id_post= $id_post;
    }

    protected function generaCamposFormulario(&$datos){

        $post = es\ucm\fdi\aw\Post::buscarPostPorID($this->id_post);
        $postText= $post->getTexto(); 

        $camposForm= <<<EOF
            <fieldset>
            <legend><strong> Modificacion </strong></legend>
            <input type = "hidden" name = "id" value = $this->id_post>
            Mensaje: <textarea name = "postText" required style = "resize: none;">$postText</textarea><br><br>
            <label>Imagen:<input type = "file" name = "image" accept = "image/*"></label><br>
            <br>
            <button type = "submit"> Publicar </button> 
        </fieldset>
        EOF; 

        return $camposForm;
    }

    protected function procesaFormulario(&$datos){
        $this->errores = [];

        $id = $datos['id'];
        $tx = htmlspecialchars($datos['postText']);

        $post = es\ucm\fdi\aw\Post::buscarPostPorID($id);
        $post->setTexto($tx);

        /*TODO Procesar imagen*/ 

        es\ucm\fdi\aw\Post::actualizar($post);
    }   
}