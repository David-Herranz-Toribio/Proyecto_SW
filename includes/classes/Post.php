<?php

namespace SW\classes;
require_once HELPERS_URL . '/PostHelper.php';

class Post{

    private $id;
    private $autor;
    private $texto;
    private $imagen;
    private $num_likes;
    private $tags;
    private $fecha_publicacion;
    private $post_origen;

    private function __construct($id, $user, $text, $img, $likes, $tags, $origen, $date){
        
        $this->id = $id;
        $this->autor = $user;
        $this->texto = $text;
        $this->imagen = $img;
        $this->num_likes = $likes;
        $this->post_origen = $origen;
        $this->tags = $tags;
        $this->fecha_publicacion = $date;
     
    }

    public static function crearPost($username, $text, $img, $likes, $tags, $father_post, $date){
        return new Post(null, $username, $text, $img, $likes, $tags, $father_post, $date);
    }
    

    public static function obtenerPostsDeUsuario($username){

        $result = [];
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf( "SELECT * FROM post P WHERE P.id_user = '%s' ORDER BY P.fecha DESC", $username);
        $rs = $conection->query($query);
        
        while($fila = $rs->fetch_assoc()){
            $result[] = new Post($fila['id_post'],$fila['id_user'], $fila['texto'], $fila['imagen'], $fila['likes'], $fila['origen'],$fila['tags'],  $fila['fecha']);
        }
        $rs->free();

        return $result;
    }

    public static function obtenerPostsFavPorUser($username){

        $result = [];
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT P.id_post, P.id_user AS post_user, P.texto, P.imagen, P.likes, P.origen, P.tags, P.fecha FROM post P 
                          JOIN postfav F ON P.id_post = F.id_post WHERE F.id_user = '%s' ORDER BY P.fecha DESC",
                         $username);
        $rs = $conection->query($query);
    
        while($fila = $rs->fetch_assoc()){
            $result[] = new Post($fila['id_post'],$fila['post_user'], $fila['texto'], $fila['imagen'], $fila['likes'], $fila['origen'],$fila['tags'],  $fila['fecha']);
        }
        $rs->free();
        
        return $result;
    }
    

    public static function obtenerListaDePosts($origen_aux = 'NULL'){

        $post = [];
        $conection = Aplicacion::getInstance()->getConexionBd();

        if($origen_aux == 'NULL')
            $operation = 'IS';
        else 
            $operation = '=';

        $query = "SELECT * FROM post P 
                    WHERE P.origen $operation $origen_aux 
                    AND P.id_post NOT IN (SELECT pp.id_post FROM producto_post pp)
                    AND P.id_post NOT IN (SELECT cp.id_post FROM cancion_post cp) 
                    ORDER BY P.fecha ASC";

        $rs = $conection->query($query);

        while($fila = $rs->fetch_assoc()){
            $post[] = new Post($fila['id_post'],$fila['id_user'], $fila['texto'], $fila['imagen'], $fila['likes'], $fila['origen'],$fila['tags'],  $fila['fecha']);
        }
        $rs->free();
        
        return $post;
    }

        public static function obtenerListaDeReseñas($tipo, $id){

        $post = [];
        $conection = Aplicacion::getInstance()->getConexionBd();

  
        if($tipo == 'producto')
            $select= "AND P.id_post  IN (SELECT pp.id_post FROM producto_post pp WHERE pp.id_prod = $id)";
        else if($tipo == 'cancion')
            $select= "AND P.id_post  IN (SELECT cp.id_post FROM cancion_post cp WHERE cp.id_cancion = $id)";


        $query = "SELECT * FROM post P WHERE P.origen IS NULL  
                    $select 
                    ORDER BY P.fecha ASC";

        $rs = $conection->query($query);

        while($fila = $rs->fetch_assoc()){
            $post[] = new Post($fila['id_post'],$fila['id_user'], $fila['texto'], $fila['imagen'], $fila['likes'], $fila['origen'],$fila['tags'],  $fila['fecha']);
        }
        $rs->free();
        
        return $post;
    }

    public static function buscarPostPorUsuario($user){

        $result = [];
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM post P JOIN usuario U ON P.id_user = U.id_user WHERE U.id_user = '%s';", $user); 
        $rs = $conection->query($query);

        while($fila = $rs->fetch_assoc()){
            $result[] = new Post($fila['id_post'],$fila['id_user'], $fila['texto'], $fila['imagen'], $fila['likes'], $fila['origen'],$fila['tags'],  $fila['fecha']);
        }
        $rs->free();

        return $result;
    }

    public static function generatePostDate(){

        $date = getdate();
        $day = $date['mday'];
        $month = $date['mon'];
        $year = $date['year'];

        return $year  . "-" .$month . "-" . $day;
    }

    public static function likeAsignado($id, $user){

        $result = true ;
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM postfav P WHERE P.id_post  = %d AND P.id_user  = '%s'",$id , $user);
        $rs = $conection->query($query);

        if($rs->num_rows == 0)
            $result = false;
        
        $rs->free();

        return $result;
    }


    public static function buscarPostPorID($id){
       
        $conection = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM post P WHERE P.id_post = %d",  $id);
        $rs = $conection->query($query);
        $result = NULL;

        while($fila = $rs->fetch_assoc()){
            $result = new Post($fila['id_post'],$fila['id_user'], $fila['texto'], $fila['imagen'], $fila['likes'], $fila['origen'],$fila['tags'],  $fila['fecha']);
        }
        $rs->free();

        return $result;
    }
    public static function insertaProdPost($prod, $post){

        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO producto_post (id_prod, id_post) VALUES (%d, %d)",
            $prod,
            $post
        );

        $result = $conn->query($query);

        if (!$result) 
            error_log($conn->error);

        return $result;
    }
    public static function insertaCancionPost($cancion, $post){

        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO cancion_post (id_cancion, id_post) VALUES (%d, %d)",
            $cancion,
            $post
        );

        $result = $conn->query($query);

        if (!$result) 
            error_log($conn->error);

        return $result;
    }
    public static function insertaFav($post, $user){

        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO postfav (id_post,id_user) VALUES (%d, '%s')",
            $post->id,
            $user
        );

        $result = $conn->query($query);

        if (!$result) 
            error_log($conn->error);

        return $result;
    }

    public static function borraFav($post, $user){

        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "DELETE FROM postfav WHERE (id_post = %d AND id_user = '%s')",
            $post->id,
            $user
        );

        $result = $conn->query($query);

        if (!$result)  
            error_log($conn->error);

        return $result;
    }

    public function borrarPost(){

        if(file_exists(IMG_URL . '/postImages/' . $this->imagen)){
            unlink(IMG_URL . '/postImages/' . $this->imagen); 
        }
        
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "DELETE FROM post WHERE (id_post = %d)",
            $this->id,
        );
        echo $query;

        $result = $conn->query($query);

        if (!$result)  
            error_log($conn->error);

        return $result;
    }
    private static function inserta($post){

        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO post (id_user, texto, imagen, likes, origen, tags, fecha)
                       VALUES ('%s','%s','%s', %d, %s, '%s', '%s')",
            $post->autor,
            $conn->real_escape_string($post->texto),
            is_null($post->imagen) ? 'NULL' : $conn->real_escape_string($post->imagen),
            $post->num_likes,
            is_null($post->post_origen) ? 'NULL' : $post->post_origen,
            $post->tags,
            $conn->real_escape_string($post->fecha_publicacion)
        );

        $result = $conn->query($query);

        if ($result) {
            $post->id = $conn->insert_id;
            $result = $post;
        }
        else 
            error_log($conn->error);

        return $result;
    }

    public static function actualizar($post){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf(
            "UPDATE post SET texto = '%s', imagen = '%s', likes = %d, tags = '%s', fecha = '%s' WHERE id_post = %d",
            $conn->real_escape_string($post->texto),
            is_null($post->imagen) ? 'NULL' : $post->imagen,
            $post->num_likes,
            $post->tags, 
            self::generatePostDate(),
            $post->id
        );
    
        $result = $conn->query($query);
    
        if (!$result) 
            error_log($conn->error);
        else if ($conn->affected_rows != 1) 
            error_log("Se han actualizado '$conn->affected_rows' registros!");
    
        return $result;
    }

    public function guarda(){

        if (!$this->id) 
            self::inserta($this);
        else 
            self::actualizar($this);

        return $this;
    }

    public function guardaFav(){
        !$this->id ? self::insertaFav($this, $this->id) : self::actualizar($this);
        return $this;
    }

    public function aumentaLikes($num){
        $this->num_likes +=  $num;
    }


    public function setTexto($texto) {
        $this->texto = $texto;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    public function setTags($tags) {
        $this->tags = $tags;
    }

    public function setLikes($num) {
        $this->num_likes = $num;
    }

    public function getId(){
        return $this->id;
    }

    public function getAutor(){
        return $this->autor;
    }

    public function getTexto(){
        return $this->texto;
    }

    public function getImagen(){
        return $this->imagen;
    }
    
    public function getLikes(){
        return $this->num_likes;
    }

    public function getTags(){
        return $this->tags;
    }

    public function getFecha(){
        return $this->fecha_publicacion;
    }

    public function getPadre(){
        return $this->post_origen;
    }
}