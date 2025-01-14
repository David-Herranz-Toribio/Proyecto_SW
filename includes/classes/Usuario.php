<?php

namespace SW\classes;

class Usuario{

    private $username;
    private $nickname; 
    private $password;
    private $fotopath;
    private $desc;
    private $karma;
    private $isArtist;
    private $birthdate;
    private $email;
    private $isAdmin;



    function __construct(&$parameters){

        $this->username = $parameters['username'];
        $this->nickname = $parameters['nickname'];
        $this->email = $parameters['email'];
        $this->password = $parameters['password'];
        $this->fotopath = $parameters['profile_image'];
        $this->desc = $parameters['desc'];
        $this->karma = $parameters['karma'];
        $this->isArtist = $parameters['isArtist'];
        $this->birthdate = $parameters['birthdate'];
    }


    /*
        Registra un nuevo usuario en la Base de Datos
        Devolvemos el objeto Usuario y por el parametro errors[] los mensajes de error que se hayan generado(usuario ya existe, contraseña débil, etc...)
    */
    public static function createUser(&$parametros){

        // Parametros del usuario
        $username = $parametros['username'];
        $nickname = $parametros['nickname'];
        $email = $parametros['email'];
        $password = $parametros['password'];
        $karma =  $parametros['karma'];
        $artist = $parametros['isArtist'];
        $birth = $parametros['birthdate'];

        $profile_image = $parametros['profile_image'];

        $conection = Aplicacion::getInstance()->getConexionBd();
        $nullv = null;
        $karma = 0;
        $query = "INSERT INTO usuario (id_user, nickname, password, foto, descripcion, karma, fecha, correo) VALUES ";
        $values = "('$username', '$nickname', '$password', '$profile_image', '$nullv', $karma, '$birth', '$email'); ";
        $query .= $values;
        $conection->query($query); 

        if($conection) {
            if($artist) {
                $query = "INSERT INTO artista (id_artista) VALUES "; 
                $values = "('$username'); "; 
                $query .= $values;
                $conection->query($query); 

                if(!$conection) 
                    error_log("Error BD ({$conection->errno}): {$conection->error}");
            }

            return new Usuario($parametros); 
        }
        else 
            error_log("Error BD ({$conection->errno}): {$conection->error}");
    }

    public function actualiza(){
        
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        
        $query = sprintf(
            "UPDATE usuario SET
                nickname = '%s',
                password = '%s',
                foto = '%s',
                descripcion = '%s',
                karma = %d,
                fecha = '%s',
                correo = '%s'
            WHERE id_user = '%s'",
                $conn->real_escape_string($this->nickname),
                $conn->real_escape_string($this->password), 
                $conn->real_escape_string($this->fotopath),
                $conn->real_escape_string($this->desc),
                $this->karma,
                $this->birthdate,            
                $conn->real_escape_string($this->email),
                $conn->real_escape_string($this->username)
        );
        $result = $conn->query($query);

        if (!$result)
            error_log($conn->error);
        else if ($conn->affected_rows != 1)
            error_log("Se han actualizado '$conn->affected_rows' !");

        return $result;
    }

    public function deleteUser() {
        if($this->fotopath!="FotoPerfil.png"){
            unlink(IMG_URL . '/profileImages/' . $this->fotopath);
        } 

        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        
        $query = sprintf("DELETE FROM usuario WHERE id_user = '%s'", $this->username); 
        $result = $conn->query($query);
        
        if (!$result) {
            error_log($conn->error);
        } 
        return $result;
    }

    public function deleteArtist(){

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("UPDATE artista SET archivado = 1 WHERE id_artista = '%s'", $this->username); 
        $result = $conn->query($query);
        $conn->query("SET FOREIGN_KEY_CHECKS=0");
        $result = $conn->query($query);

        return $result;
    }

    public function publicarPost($post_text, $post_image, $post_father){
        $post = Post::crearPost($this->username, $post_text, $post_image, 0, null, $post_father, Post::generatePostDate());
        return $post->guarda();
    }

    /*
        Metodo que te permite seguir a un usuario
    */ 
    public function seguir ($user_a_seguir){
        $seguidor= $this->getUsername(); 
        $result= false; 

        $conn= Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("INSERT INTO seguidores(id_user, id_seguidor) VALUES"); 
        $values= "('$user_a_seguir', '$seguidor'); "; 
        $query.= $values; 

        $result= $conn->query($query);

        if(!$result){
            error_log($conn->error);
        }

        return $result; 
    }
    
    public static function obtenerListaUsuarios(){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM usuario";
        $result = $conn->query($query);
        if(!$result){
            error_log($conn->error);
            return false;
        }
        $listaUsuarios = [];
        while($row = $result->fetch_assoc()) {
            $parameters = [];
            $parameters['username'] = $row['id_user'];
            $parameters['nickname'] = $row['nickname'];
            $parameters['email'] = $row['correo'];
            $parameters['password'] = $row['password'];
            $parameters['profile_image'] = $row['foto'];
            $parameters['desc'] = $row['descripcion'];
            $parameters['karma'] = $row['karma'];
            $parameters['isArtist'] = self::esArtista($row['id_user']);
            $parameters['birthdate'] = $row['fecha'];
            $listaUsuarios[] = new Usuario($parameters);
        }
        $result->free();
        return $listaUsuarios;

    }
    public function obtenerListaSeguidos() {
        $usuario = $this->getUsername(); 
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT id_user FROM seguidores WHERE id_seguidor = '%s';", $usuario);
        $result = $conn->query($query);
        if(!$result){
            error_log($conn->error);
            return false;
        }
        $listaSeguidos = [];
        while($row = $result->fetch_assoc()) {
            $listaSeguidos[] = $row['id_user'];
        }
        $result->free();
        return $listaSeguidos;
    }

    public function obtenerListaSeguidores() {
        $usuario = $this->getUsername(); 
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT id_seguidor FROM seguidores WHERE id_user = '%s';", $usuario);
        $result = $conn->query($query);
        if(!$result){
            error_log($conn->error);
            return false;
        }
        $listaSeguidores = [];
        while($row = $result->fetch_assoc()) {
            $listaSeguidores[] = $row['id_seguidor'];
        }
        $result->free();
        return $listaSeguidores;
    }

    public function estaSiguiendo ($user){
        
        $result = true;
        $seguidor = $this->getUsername(); 
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM seguidores WHERE id_user= '%s' AND id_seguidor= '%s'", $user, $seguidor); 
        $rs = $conn->query($query); 

        if($rs->num_rows == 0)
            $result = false;
        
        $rs->free();
        return $result; 
    }

    public function dejarDeSeguir ($user_siguiendo){

        $seguidor = $this->getUsername(); 
        $result = false; 

        $conn= Aplicacion::getInstance()->getConexionBd();

        $query = sprintf("DELETE FROM seguidores WHERE (id_user = '%s' AND id_seguidor= '%s')", 
        $user_siguiendo, 
        $seguidor);  


        $result= $conn->query($query);

        if(!$result){
            error_log($conn->error);
        }

        return $result; 
    }

    public static function login($username, $password) {

        $usuario = self::buscaUsuario($username); 
        
        //El login es correcto
        if(!$usuario || !$usuario->comprueba_password($password))
            return false;

        // Si es artista, comprobar que no esta archivado
        if(self::esArtista($usuario->getUsername())){
            if(is_null(self::estaArchivado($usuario->getUsername())))
                return false;
        }

        return $usuario; 
    }

    //Comprueba si la contraseña es correcta
    public function comprueba_password($password){
        return password_verify($password, $this->password); 
    }

    //Comprueba si el usuario se trata de un artista 
    public static function esArtista($id_u) {

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM artista A WHERE A.id_artista= '%s'", $id_u); 
        $rs = $conn->query($query);  

        if(!$rs){
            return false;
        }

        $fila = $rs->fetch_assoc(); 
        if($fila)
            return true;
        else 
            return false;
    }


    public static function esAdmin($id_u) {

        $result = true;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuario WHERE id_user = '%s' AND admin = 1", $conn->real_escape_string($id_u)); 
        $rs = $conn->query($query);  

        if($rs->num_rows == 0)
            $result = false;
        
        $rs->free();
        return $result; 
    }

    public static function compruebaUsuario($username, $correo){

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuario U WHERE U.id_user = '%s' OR U.correo = '%s'", $username, $correo); 
        $rs = $conn->query($query); 
        $result = false; 

        if($rs){
            $fila = $rs->fetch_assoc(); 

            if($fila) {

                //Comprobar si el usuario es artista 
                $artista = self::esArtista($fila['id_user']);

                //Parametros de la clase Usuario
                $parameters = [];
                $parameters['username'] = $fila['id_user'];
                $parameters['nickname'] = $fila['nickname'];
                $parameters['email'] = $fila['correo'];
                $parameters['password'] = $fila['password'];
                $parameters['fotopath'] = $fila['foto'];
                $parameters['desc'] = $fila['descripcion'];
                $parameters['karma'] = $fila['karma'];
                $parameters['isArtist'] = $artista;
                $parameters['birthdate'] = $fila['fecha'];

                $result = new Usuario($parameters);
            }

            $rs->free(); 
        }

        return $result; 
    } 

    //Metodo que busca en la base de datos un usuario por su nombre 
    public static function  buscaUsuario($username){

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuario U WHERE U.id_user= '%s'", $username); 
        $rs = $conn->query($query); 
        $result = false; 

        if($rs){
            $fila = $rs->fetch_assoc(); 

            if($fila){
                //Comprobar si el usuario es artista 
                $artista = self::esArtista($fila['id_user']);

                //Parametros de la clase Usuario
                $parameters = [];
                $parameters['username'] = $fila['id_user'];
                $parameters['nickname'] = $fila['nickname'];
                $parameters['email'] = $fila['correo'];
                $parameters['password'] = $fila['password'];
                $parameters['profile_image'] = $fila['foto'];
                $parameters['desc'] = $fila['descripcion'];
                $parameters['karma'] = $fila['karma'];
                $parameters['isArtist'] = $artista;
                $parameters['birthdate'] = $fila['fecha'];

                $result = new Usuario($parameters);
            }

            $rs->free(); 
        }

        return $result; 
    }   

    public static function buscaNicknameBD($nickname){
        
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuario U WHERE U.nickname= '%s'", $nickname); 
        if( $conn->query($query) )
            return true;

        return false;
    }

    public static function buscaEmailBD($email){
    
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuario U WHERE U.correo= '%s'", $email);
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        if( $fila )
            return true;

        return false;
    }

    public static function buscaFechaBD($fecha){
    
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuario U WHERE U.fecha= '%s'", $fecha); 
        if( $conn->query($query) )
            return true;

        return false;
    }

    public static function estaArchivado($id_user){

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM artista WHERE id_artista = '%s' AND archivado = 1", $id_user); 
        $rs = $conn->query($query);  

        $result = $rs->fetch_assoc();
        if(is_null($result))
            return false;
        
        $rs->free();
        return true; 
    }

    public function aumentaKarma($num){
        $this->karma = $this->karma + $num;
    }

    public function setKarma($num){
        $this->karma = $num;
    }

    public function getKarma(){
        return $this->karma;
    }

    public function getUsername(){
        return $this->username;
    }

    public function isArtist(){
        return $this->isArtist;
    }
    public function isAdmin(){
        return $this->isAdmin;
    }

    public function getDescrip(){
        return $this->desc; 
    }

    public function getNickname(){
        return $this->nickname;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getPhoto(){
        return $this->fotopath;
    }

    public function getEmail(){
        return $this->email; 
    }

    public function getBirthdate(){
        return $this->birthdate; 
    }

    public function setNickname($new_nickname){
        $this->nickname = $new_nickname; 
    }

    public function setPhoto($new_photo){
        $this->fotopath = $new_photo;
    }

    public function setEmail($new_email){
        $this->email = $new_email; 
    }

    public function setBirthdate($new_birthdate){
        $this->birthdate = $new_birthdate; 
    }

    public function setPassword($new_password){
        $this->password = $new_password; 
    }

    public function setDescrip($new_desc){
        $this->desc = $new_desc; 
    }

}