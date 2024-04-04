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


    public static function checkUserData($username, $email, $birthdate, $isArtist){

        // Lista de errores
        $errores = [];

        // El usuario ya existe
        if(self::buscaUsuario($username))
            $errores['username'] = 'El usuario ya existe';

        // El email no es válido
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            $errores['email'] = 'El email no es válido';

        // El email ya está en uso
        else if(self::buscaEmailBD($email) == null)
            $errores['email'] = 'El email ya está en uso';
        
        
        // Obtener fecha actual
        $fecha_actual = new DateTime();
        $birthdate = new DateTime($birthdate);

        // Obtener un entero a partir de la fecha
        $fecha_num = intval(date("Ymd", strtotime($fecha_actual->format('Y-m-d'))));
        $birth_num = intval(date("Ymd", strtotime($birthdate->format('Y-m-d'))));
        

        // La fecha es anterior al día actual
        if( $isArtist && $fecha_actual->diff($birthdate)->d < 1 && $birth_num < $fecha_num ){
            $errores['birthdate'] = 'La fecha debe ser anterior al día actual';
        }
        // La fecha verifica que el usuario tiene más de 18 años
        else if( !$isArtist && $fecha_actual->diff($birthdate)->y < 18 && $birth_num < $fecha_num ){
            $errores['birthdate'] = 'Debe tener más de 18 años para crear una cuenta';
        }

        return $errores;
    }

    /*
        Registra un nuevo usuario en la Base de Datos
        Devolvemos el objeto Usuario y por el parametro errors[] los mensajes de error que se hayan generado(usuario ya existe, contraseña débil, etc...)
    */
    public static function createUser($username, $nickname, $password, $email, $birth, $artist, $artist_members){

        $conection = BD::getInstance()->getConexionBd();
        $nullv = null;
        $karma = 0;
        $query = "INSERT INTO usuario (id_user, nickname, password, foto, descripcion, karma, fecha, correo) VALUES ";
        $values = "('$username', '$nickname', '$password', '$nullv', '$nullv', $karma, '$birth', '$email'); ";
        $query .= $values;
        $conection->query($query);

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
                $conn->real_escape_string($user->password),
                $conn->real_escape_string($user->nickname), 
                $conn->real_escape_string($user->fotopath),
                $conn->real_escape_string($user->desc),
                $user->karma,
                $user->birthdate,            
                $conn->real_escape_string($user->email),
                $conn->real_escape_string($user->username)
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
        $result = false; 

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

    public static function buscaUsernameBD($username){
    
        return null;
    }

    public static function buscaNicknameBD($nickname){
    
        return null;
    }

    public static function buscaEmailBD($email){
    
        return null;
    }

    public static function buscaBirthdateBD($birthdate){
    
        return null;
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