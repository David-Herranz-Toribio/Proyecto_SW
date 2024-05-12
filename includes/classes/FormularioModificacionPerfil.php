<?php
require_once 'FormularioMultimedia.php'; 
require_once 'Usuario.php'; 
require_once 'Pedido.php';


class FormularioModificacionPerfil extends FormularioMultimedia {

    public function __construct() {
        parent::__construct('formModificar', ['urlRedireccion' =>  VIEWS_PATH .'/perfil/Perfil.php', 'enctype' => 'multipart/form-data']);
    }

    protected function generaCamposFormulario(&$datos){
        $user= SW\classes\Usuario:: buscaUsuario($_SESSION['username']);  

        $userName= $user->getUsername(); 
        $nickName= $user->getNickname();  
        $desc= $user->getDescrip(); 
        $email= $user->getEmail(); 
        $imagen= $user->getPhoto(); 

        $htmlErroresGlobales =  self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['username', 'nickname', 'password', 'desc', 'email','imagen'], $this->errores, 'span', array('class' => 'error'));

        $camposForm= <<<EOF
            <input type= 'hidden' name= "ImagenAntigua" value= '$imagen'> 
            $htmlErroresGlobales
            <fieldset class= "formRegistro">
            <legend> Modifica tu cuenta </legend> 

            <input hidden name="id_user" value= "$userName">
             
            <input hidden name="isArtist" value="0"> 

            <label> Nickname </label>

            <div> 
            <input type="text" name= "modify_nickname" value= "$nickName">
            </div> 

            <label> Descripcion </label> 

            <div> 
            <input type="text" name= "modify_descrip" value= "$desc">
            {$erroresCampos['desc']}
            </div> 
            
            <label> Email </label>
            <div> 
            <input type="text" name="modify_email" value= "$email">
            <span id= 'validEmail'> </span> 
            {$erroresCampos['email']}
            </div> 

            <label> Password </label>
            
            <div> 
            <input type="password" name="modify_password" id='campoPassword'>
            {$erroresCampos['password']}
            <span id= 'validPassword'> </span> 
            </div> 
            <label> Modificar foto de perfil </label>
            <input type = "file" name = "image" accept = "image/*">
        
            <button type="submit" name="register_button" > Modificar </button>
            </fieldset>
        EOF; 

        return $camposForm;
    }

    protected function procesaFormulario(&$datos){
        $this->errores = [];

        $nickname = htmlspecialchars($datos['modify_nickname']);
        $descripcion= htmlspecialchars($datos['modify_descrip']); 
        $email = htmlspecialchars($datos['modify_email']);
        $imagen_ant= htmlspecialchars($datos['ImagenAntigua']); 
        $password_length = strlen($datos['modify_password']);
        $password = $datos['modify_password'];


        /*TODO comprobar errores en los datos*/
        $usu_mod= SW\classes\Usuario::buscaUsuario($_SESSION['username']); 

        if($nickname) $usu_mod->setNickname($nickname);

        if($descripcion) $usu_mod->setDescrip($descripcion); 

        if($email){
            if( !filter_var($email, FILTER_VALIDATE_EMAIL) )
                $this->errores['email'] = 'El email no es válido';

            else if( SW\classes\Usuario::buscaEmailBD($email))
                if($email!=$usu_mod->getEmail()) $this->errores['email'] = 'El email ya está en uso';
                
            else  $usu_mod->setEmail($email);
            
        }

        if($password){
            if($password_length < 8){
                $this->errores['password'] = 'La contraseña debe tener al menos 8 caracteres';
            }    
            else {
                $password= password_hash($password, PASSWORD_DEFAULT);
                $usu_mod->setPassword($password);
            }
        } 

        $fotoPerfil= self::compruebaImagen('image', '/profileImages/'); 

        if(count($this->errores)===0){
            $usu_mod->setPhoto($fotoPerfil ?? $imagen_ant); 
            $usu_mod->actualiza(); 
        }
    }
}