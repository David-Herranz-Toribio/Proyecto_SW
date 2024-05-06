<?php
require_once 'FormularioMultimedia.php'; 
require_once 'Usuario.php'; 
require_once 'Pedido.php';
require_once 'Playlist.php';

class FormularioRegistro extends FormularioMultimedia {

    private $isArtist; 

    public function __construct($isArtist) {
        parent::__construct('formRegistro', ['urlRedireccion' =>  VIEWS_PATH .'/perfil/Perfil.php', 'enctype' => 'multipart/form-data']);
        $this->isArtist= $isArtist;
    }

    protected function generaCamposFormulario(&$datos){

        $userName= $datos['username'] ?? ''; 
        $nickName= $datos['nickname'] ?? ''; 
        $email= $datos['email'] ?? ''; 
        $birthdate= $datos['birthdate'] ?? ''; 


        $htmlErroresGlobales =  self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['username', 'nickname', 'password', 'email', 'birthdate', 'imagen'], $this->errores, 'span', array('class' => 'error'));


        $opciones_de_artista= ''; 
        $link_a_artista= ''; 

        if($this->isArtist== true){
            $opciones_de_artista = <<<EOS
            <label> Musical genre: </label>
            <select name="artist_members" size = "6">
                <option> ----</option>
                <option value="Pop"> Pop </option>
                <option value="Rock"> Rock </option>
                <option value="Rap"> Rap </option>
                <option value="Hip Hop"> Hip Hop </option>
                <option value="Latino"> Latino </option>
                <option value="Jazz"> Jazz </option>
                <option value="R&B"> R&B </option>
                <option value="K-Pop"> K-Pop </option>
                <option value="J-Pop"> J-Pop </option>
                <option value="Dubstep"> Dubstep </option>
                <option value="Clásica"> Clásica </option>
                <option value="Disco"> Disco </option>
                <option value="Funk"> Funk </option>
                <option value="Jazz"> Jazz </option>
                <option value="Reggae"> Reggae </option>
                <option value="Metal"> Metal </option>
            </select>
            EOS; 
        }

        else {
            $enlace = VIEWS_PATH . '/log/SignUpArtist.php';
            $link_a_artista= <<<EOS
            <p> Eres un artista? <a href= $enlace> Crea tu cuenta aquí </a></p>
            EOS; 

        }

        $camposForm =<<<EOF
            $htmlErroresGlobales
            <fieldset class="formRegistro">
            <legend> Registra tu nueva cuenta de usuario </legend> 
    
            <label> Nickname </label>
            <div> 
            <input required type="text" name= "nickname" value= "$nickName"/>
            {$erroresCampos['nickname']}
            </div> 


            <label> Username (Ej: paco03) </label>
            <div> 
            <input required type="text" name="username" value= "$userName"/>
            {$erroresCampos['username']}
            </div>

            <label> Email </label>
            <div> 
            <input required type="text" name="email" value= "$email"/>
            {$erroresCampos['email']}
            </div> 

            <label> Password </label>
            <div> 
            <input required type="password" name="password"/>
            </div> 
            {$erroresCampos['password']}
            <label> Birthdate </label>
            <div> 
            <input required type="date" name="birthdate" value= $birthdate>
            {$erroresCampos['birthdate']}
            </div> 
            
            $opciones_de_artista 

            <label> Foto de perfil </label>
            <div> 
                <input type = "file" name = "image" accept = "image/*">
                {$erroresCampos['imagen']}
            </div> 
            <button type="submit" name="register_button" > Sign In </button>
            </field> 

            $link_a_artista
        EOF; 

        return $camposForm;
    }

    protected function procesaFormulario(&$datos){

        $this->errores = [];

        $username =  htmlspecialchars($datos['username']);
        $nickname = htmlspecialchars($datos['nickname']);
        $email = htmlspecialchars($datos['email']);
        $datos['password'] = password_hash($datos['password'], PASSWORD_DEFAULT);
        $password_length = strlen($datos['password']);
        $birthdate = $datos['birthdate'];

        // La contraseña no tiene al menos 8 caracteres
        if( $password_length < 8 )
            $this->errores['password'] = 'La contraseña debe tener al menos 8 caracteres';
        
        // El email no es válido
        if( !filter_var($email, FILTER_VALIDATE_EMAIL) )
            $this->errores['email'] = 'El email no es válido';

        // El email ya está en uso
        else if( SW\classes\Usuario::buscaEmailBD($email) )
            $this->errores['email'] = 'El email ya está en uso';
        
        
        // Obtener fecha actual
        $fecha_actual = new \DateTime();
        $birthdate = new \DateTime($birthdate);

        // Obtener un entero a partir de la fecha
        $fecha_num = intval(date("Ymd", strtotime($fecha_actual->format('Y-m-d'))));
        $birth_num = intval(date("Ymd", strtotime($birthdate->format('Y-m-d'))));

        // La fecha es anterior al día actual
        if( $this->isArtist ){

            if( $fecha_actual->diff($birthdate)->d < 1 )
                $this->errores['birthdate'] = 'La fecha debe ser anterior al dia actual';
        }
        else{

            if( $fecha_actual->diff($birthdate)->y < 18 )
                $this->errores['birthdate'] = 'Debes ser mayor de 18 años';

            if( $birth_num > $fecha_num )
                $this->errores['birthdate'] = 'La fecha debe ser anterior al dia actual';
        }

        $datos['profile_image']= self::procesaFichero('image', '/profileImages/'); 

        if($datos['profile_image'] === NULL){ //No se ha subido foto de perfil 
            $datos['profile_image'] = 'FotoPerfil.png'; //Se pone una foto de perfil por defecto
        } 

        if(count($this->errores) === 0){
            $usuario = SW\classes\Usuario::buscaUsuario($username); 
            if($usuario){ //El username ya está en uso
                $this->errores[] = 'El usuario ya existe';
            }
    
            else { //El username esta libre 
    
                $num = SW\classes\Pedido::numProdporUserPP($username);
                if($num)
                    $_SESSION['notif_prod'] = $num;
    
                if($this->isArtist == true)
                    $_SESSION['isArtist'] = true; 
    
                $datos['artist_members'] = NULL; 
                
                $datos['karma'] = 0;
                $datos['desc'] = '';
                $datos['isArtist'] = $this->isArtist; 
                
                // Crear usuario en la base de datos
                $usuario = SW\classes\Usuario::createUser($datos);
    
                // Crear playlist por defecto -> Favoritos
                SW\classes\Playlist::crearPlaylistPorDefecto($username, $fecha_actual->format('Y-m-d'));
    
                // Iniciar sesión
                $_SESSION['username'] = $username; 
            }
        }


       
    }

}