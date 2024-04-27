
<?php
require_once 'Formulario.php'; 
require_once 'Usuario.php'; 
require_once 'Pedido.php';

class FormularioLogin extends Formulario
{
    public function __construct() {
        parent::__construct('formLogin', ['urlRedireccion' => VIEWS_PATH .'/perfil/Perfil.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        // Se reutiliza el nombre de usuario introducido previamente o se deja en blanco
        $nombreUsuario = $datos['username'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['username', 'password'], $this->errores, 'span', array('class' => 'error'));
        $registerPath = VIEWS_PATH . '/log/SignUpUser.php';

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset class= "formLogin"">
        <legend> Login </legend>
        <label> Username </label>
        <div> 
        <input type="text" name="username">
        {$erroresCampos['username']}
        </div> 

        <label> Password </label>

        <div> 
        <input type="password" name="password">
        {$erroresCampos['password']}
        </div>

        <button id= 'sendLogin' type="submit"> Log in </button>
        <p> ¿No tienes cuenta? <a href="$registerPath"> Regístrate </a></p>
        </fieldset>
        EOF;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $username = htmlspecialchars($datos['username']);

        $password = $_POST['password'] ?? null;

        if (!$username || empty($username) ) {
            $this->errores['nombreUsuario'] = 'El nombre de usuario no puede estar vacío';
        }
        
        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( ! $password || empty($password) ) {
            $this->errores['password'] = 'El password no puede estar vacío.';
        }
        
        if (count($this->errores) === 0) {
            $usuario = es\ucm\fdi\aw\Usuario::login($username, $password);
        
            if (!$usuario) {
                $this->errores[] = "El usuario o el password no coinciden";
            } 
            else {
                $_SESSION['login'] = true;
                $_SESSION['username'] = $usuario->getUsername();
                $num = es\ucm\fdi\aw\Pedido::numProdporUserPP($username);
                if($num){
                    $_SESSION['notif_prod'] = $num;
                }
                $_SESSION['isArtist'] =  es\ucm\fdi\aw\Usuario::esArtista($username); 
            }
        }
    }
}