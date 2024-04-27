<?php
require_once 'Formulario.php'; 
require_once 'Usuario.php'; 
require_once 'Pedido.php';


class FormularioRegistro extends Formulario {

    public function __construct() {
        parent::__construct('formRegistro', ['urlRedireccion' =>  VIEWS_PATH .'/perfil/Perfil.php']);
    }

    protected function generaCamposFormulario(&$datos){
        $userName= $datos['username'] ?? ''; 
        $nickName= $datos['nickname'] ?? ''; 
        $email= $datos['email'] ?? ''; 
        $birthdate= $datos['birthdate'] ?? ''; 


        $htmlErroresGlobales =  self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['username', 'nickname', 'password', 'email', 'birthdate'], $this->errores, 'span', array('class' => 'error'));

        $camposForm= <<<EOF
            $htmlErroresGlobales
            <fieldset class="formRegistro">
            <legend> Registra tu nueva cuenta de usuario </legend> 
            <input hidden name="isArtist" value="0"/> 

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
            
            <label> Foto de perfil </label>
            <p></p>
                <input type = "file" name = "image" accept = "image/*">
            <button type="submit" name="register_button" > Sign In </button>
            </field> 
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
        $isArtist = boolval($datos['isArtist']);

        // La contraseña no tiene al menos 8 caracteres
        if( $password_length < 8 )
            $this->errores['password'] = 'La contraseña debe tener al menos 8 caracteres';
        
        // El email no es válido
        if( !filter_var($email, FILTER_VALIDATE_EMAIL) )
            $this->errores['email'] = 'El email no es válido';

        // El email ya está en uso
        else if( es\ucm\fdi\aw\Usuario::buscaEmailBD($email) )
            $this->errores['email'] = 'El email ya está en uso';
        
        
        // Obtener fecha actual
        $fecha_actual = new \DateTime();
        $birthdate = new \DateTime($birthdate);

        // Obtener un entero a partir de la fecha
        $fecha_num = intval(date("Ymd", strtotime($fecha_actual->format('Y-m-d'))));
        $birth_num = intval(date("Ymd", strtotime($birthdate->format('Y-m-d'))));

        // La fecha es anterior al día actual
        if( $isArtist ){

            if( $fecha_actual->diff($birthdate)->d < 1 )
                $this->errores['birthdate'] = 'La fecha debe ser anterior al dia actual';
        }
        else{

            if( $fecha_actual->diff($birthdate)->y < 18 )
                $this->errores['birthdate'] = 'Debes ser mayor de 18 años';

            if( $birth_num > $fecha_num )
                $this->errores['birthdate'] = 'La fecha debe ser anterior al dia actual';
        }

        if(count($this->errores)===0){
            $usuario= es\ucm\fdi\aw\Usuario:: buscaUsuario($username); 

            if($usuario){ //El username esta cogido 
                $this->errores[] = 'El usuario ya existe';
            }

            else { //El username esta libre 
                $num = es\ucm\fdi\aw\Pedido::numProdporUserPP($username);
                if($num)
                    $_SESSION['notif_prod'] = $num;

                $datos['karma']= 0;
                $datos['artist_members']= NULL; 
                $datos['profile_image']= NULL; 
                $datos['desc']= '';



                $usuario= es\ucm\fdi\aw\Usuario:: createUser($datos); 
                $_SESSION['username'] = $username; 
            }
        }
    }
}