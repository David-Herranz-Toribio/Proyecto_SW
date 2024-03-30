<?php

require_once 'BD.php';
require_once 'Post.php';

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


    function __construct($user, $nickname, $pass, $fotopath, $desc, $karma, $isArtist, $birth, $email){
        
        $this->username = $user;
        $this->nickname = $nickname;
        $this->password = $pass;
        $this->fotopath = $fotopath;
        $this->desc = $desc;
        $this->karma = $karma;
        $this->isArtist = $isArtist;
        $this->birthdate = $birth;
        $this->email = $email;
    }


    //Registra un nuevo usuario en la Base de Datos 
    public static function createUser($username, $nickname, $password, $email, $birth, $artist, $artist_members){

        /*Primero compruebo si ya existe un usuario con el mismo username*/ 
        $user_buscado = self::compruebaUsuario($username, $email);

        if($user_buscado){ //Ya existia un usuario con ese nombre 
            /* TODO
                Mostrar error 
                ¿Usar lo de redirigir? 
            */
            return NULL; 
        }
        else {
            $conection = BD::getInstance()->getConexionBd();
            $nullv = null;
            $karma = 0;
            $query = "INSERT INTO usuario (id_user, nickname, password, foto, descripcion, karma, fecha, correo) VALUES ";
            $values = "('$username', '$nickname', '$password', '$nullv', '$nullv', $karma, '$birth', '$email'); ";
            $query .= $values;
            $conection->query($query);

            $result = false; 

            if($conection) {
                if($artist) {
                    $query = "INSERT INTO artista (id_artista, integrantes) VALUES "; 
                    $values = "('$username', '$artist_members'); "; 
                    $query .= $values; 
    
                    $conection->query($query); 
    
                    if(!$conection) 
                        error_log("Error BD ({$conection->errno}): {$conection->error}");
                }   
               return new Usuario($username, $nickname, $password, $nullv, $nullv, $karma, $artist, $birth, $email,); 
            }
            else 
                error_log("Error BD ({$conection->errno}): {$conection->error}");
        }
    }

    public static function actualiza($user){
        
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        
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
                $user->nickname, 
                $user->password,
                $user->fotopath,
                $user->desc,
                $user->karma,
                $user->birthdate,            
                $user->email,
                $user->username
        );
        $result = $conn->query($query);

        if (!$result)
            error_log($conn->error);
        else if ($conn->affected_rows != 1)
            error_log("Se han actualizado '$conn->affected_rows' !");

        return $result;
    }

    public function publicarPost($post_text, $post_image, $post_father){
        $post = Post::crearPost($this->username, $post_text, $post_image, 0, null, $post_father, Post::generatePostDate());
        return $post->guarda();
    }

    public static function login($username, $password) {

        $usuario = self::buscaUsuario($username); 
        
        if($usuario && $usuario->comprueba_password($password)) //El login es correcto 
            return $usuario; 

        return false; 
    }

    //Comprueba si la contraseña es correcta
    public function comprueba_password($password){
        return password_verify($password, $this->password); 
    }

    //Comprueba si el usuario se trata de un artista 
    public static function esArtista($id_u) {

        $conn= BD::getInstance()->getConexionBd();
        $query= sprintf("SELECT * FROM artista A WHERE A.id_artista= '%s'", $conn->real_escape_string($id_u)); 
        $rs= $conn->query($query); 
        $result= false; 

        if($rs) {
            $fila= $rs->fetch_assoc(); 

            if($fila)
                return 1; 
            else 
                return 0; 
        }
        else 
            error_log("Error BD ({$conn->errno}): {$conn->error}");
    }
    public static function compruebaUsuario($username, $correo){

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuario U WHERE U.id_user = '%s' OR U.correo = '%s'", $username, $correo); 
        $rs = $conn->query($query); 
        $result = false; 

        if($rs){
            $fila = $rs->fetch_assoc(); 

            if($fila) {
                //Comprobar si el usuario es artista 
                $artista = self::esArtista($fila['id_user']); 
                $result = new Usuario($fila['id_user'], $fila['nickname'], $fila['password'], $fila['foto'],
                                      $fila['descripcion'], $fila['karma'], $artista, $fila['fecha'], $fila['correo']);
            }

            $rs->free(); 
        }

        return $result; 
    } 


    //Metodo que busca en la base de datos un usuario por su nombre 
    public static function buscaUsuario($username){

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuario U WHERE U.id_user= '%s'", $username); 
        $rs = $conn->query($query); 
        $result = false; 

        if($rs){
            $fila = $rs->fetch_assoc(); 

            if($fila) {
                //Comprobar si el usuario es artista 
                $artista = self::esArtista($fila['id_user']); 
                $result = new Usuario($fila['id_user'], $fila['nickname'], $fila['password'], $fila['foto'],
                                      $fila['descripcion'], $fila['karma'], $artista, $fila['fecha'], $fila['correo']);
            }

            $rs->free(); 
        }

        return $result; 
    }

    public function aumentaKarma($num){
        $this->karma = $this->karma + $num;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getNickname(){
        return $this->nickname;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getEmail(){
        return $this->email; 
    }

    public function getBirthdate() {
        return $this->birthdate; 
    }

    public function setNickname($new_nickname){
        $this->nickname= $new_nickname; 
    }

    public function setEmail($new_email){
        $this->email= $new_email; 
    }

    public function setBirthdate($new_birthdate){
        $this->birthdate= $new_birthdate; 
    }

    public function setPassword($new_password){
        $this->password= $new_password; 
    }

}

