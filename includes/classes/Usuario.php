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


    function __construct(&$parameters){

        $this->username = $parameters['username'];
        $this->nickname = $parameters['nickname'];
        $this->email = $parameters['email'];
        $this->password = $parameters['password'];
        $this->fotopath = $parameters['fotopath'];
        $this->desc = $parameters['desc'];
        $this->karma = $parameters['karma'];
        $this->isArtist = $parameters['isArtist'];
        $this->birthdate = $parameters['birthdate'];
    }


    public static function checkUserData($username, $password_length, $email, $birthdate, $isArtist){

        // Lista de errores
        $errores = [];

        // El usuario ya existe
        if( self::buscaUsuario($username) )
            $errores['username_usado'] = 'El usuario ya existe';

        // La contraseña no tiene al menos 8 caracteres
        if( $password_length < 8 )
            $errores['short_password'] = 'La contraseña debe tener al menos 8 caracteres';
        
        // El email no es válido
        if( !filter_var($email, FILTER_VALIDATE_EMAIL) )
            $errores['email_invalido'] = 'El email no es válido';

        // El email ya está en uso
        else if( self::buscaEmailBD($email) )
            $errores['email_en_uso'] = 'El email ya está en uso';
        
        
        // Obtener fecha actual
        $fecha_actual = new DateTime();
        $birthdate = new DateTime($birthdate);

        // Obtener un entero a partir de la fecha
        $fecha_num = intval(date("Ymd", strtotime($fecha_actual->format('Y-m-d'))));
        $birth_num = intval(date("Ymd", strtotime($birthdate->format('Y-m-d'))));

        // La fecha es anterior al día actual
        if( $isArtist ){

            if( $fecha_actual->diff($birthdate)->d < 1 )
                $errores['fecha_anterior'] = 'La fecha debe ser anterior al dia actual';
        }
        else{

            if( $fecha_actual->diff($birthdate)->y < 18 )
                $errores['fecha_mayor_edad'] = 'Debes ser mayor de 18 años';

            if( $birth_num > $fecha_num )
                $errores['fecha_anterior'] = 'La fecha debe ser anterior al dia actual';
        }

        return $errores;
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
        $artist_members = $parametros['artist_members'];

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

            return new Usuario($parameters); 
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
                $conn->real_escape_string($user->nickname),
                $conn->real_escape_string($user->password), 
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


    /*Metodo que te permite seguir a un usuario*/ 

    public function seguir ($user_a_seguir){
        $seguidor= $this->getUsername(); 
        $result= false; 

        $conn= BD::getInstance()->getConexionBd();

        $query = sprintf("INSERT INTO seguidores(id_user, id_seguidor) VALUES"); 
        $values= "('$user_a_seguir', '$seguidor'); "; 
        $query.= $values; 

        $result= $conn->query($query);

        if(!$result){
            error_log($conn->error);
        }

        return $result; 
    }

    public function estaSiguiendo ($user){
        $result= true; 
        $seguidor= $this->getUsername(); 
        $conn= BD::getInstance()->getConexionBd();

        $query= sprintf("SELECT * FROM seguidores WHERE id_user= '%s' AND id_seguidor= '%s'", $user, $seguidor); 
        $rs= $conn->query($query); 

        if($rs->num_rows == 0)
            $result = false;
        
        $rs->free();
        return $result; 
    }



    public function dejarDeSeguir ($user_siguiendo){
        $seguidor= $this->getUsername(); 
        $result= false; 

        $conn= BD::getInstance()->getConexionBd();

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
        if($usuario && $usuario->comprueba_password($password))
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
        $rs = $conn->query($query);  

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
    public static function buscaUsuario($username){

        $conn = BD::getInstance()->getConexionBd();
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

    public static function buscaNicknameBD($nickname){
        
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuario U WHERE U.nickname= '%s'", $nickname); 
        if( $conn->query($query) )
            return true;

        return false;
    }

    public static function buscaEmailBD($email){
    
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuario U WHERE U.correo= '%s'", $email);
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        if( $fila )
            return true;

        return false;
    }

    public static function buscaFechaBD($fecha){
    
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuario U WHERE U.correo= '%s'", $fecha); 
        if( $conn->query($query) )
            return true;

        return false;
    }

    public function aumentaKarma($num){
        $this->karma = $this->karma + $num;
    }
    public function setKarma($num){
        $this->karma =  $num;
    }
    public function getKarma(){
        return $this->karma;
    }
    public function getUsername(){
        return $this->username;
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

    public function getEmail(){
        return $this->email; 
    }

    public function getBirthdate(){
        return $this->birthdate; 
    }

    public function setNickname($new_nickname){
        $this->nickname = $new_nickname; 
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