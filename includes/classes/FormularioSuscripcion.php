<?php

require_once 'Formulario.php';
require_once 'Usuario.php'; 


/*

    Formulario para crear un album == Playlist
    Campos:
        - Portada
        - Nombre del album
        - Año
*/
class FormularioSuscripcion extends Formulario{

    private $id_usuario;
    private $modo;

    public function __construct($id_usuario, $modo) {
        parent::__construct('formSuscripcion',[ 'urlRedireccion' => VIEWS_PATH .'/tienda/Suscripcion.php']);
        $this->id_usuario = $id_usuario;
        $this->modo = $modo;

    }

    protected function generaCamposFormulario(&$datos){


        // Se generan los mensajes de error si existen NO EXISTEN
        //$htmlErroresGlobales =  self::generaListaErroresGlobales($this->errores);
        
        $html =<<<EOS
        
        <div id="suscripciones">
            <div class="tipo_suscripcion">
                <h3> Prueba (30 seg) </h3>
                <h4> [Gratis] </h4>

                <div>
                    <button type="submit" name="tipo_suscripcion" value="prueba"> Crear </button>
                </div>
            </div>
            <div class="tipo_suscripcion">
                <h3> Mensual (1 Mes) </h3>
                <h4> [500 &#9834] </h4>

                <div>
                    <button type="submit" name="tipo_suscripcion" value="mensual"> Crear </button>
                </div>
            </div>
            <div class="tipo_suscripcion">
                <h3> Anual (1 Año) </h3>
                <h4> [1500 &#9834] </h4>

                <div>
                    <button type="submit" name="tipo_suscripcion" value="anual"> Crear </button>
                </div>
            </div>
        </div>
        EOS;
        if($this->modo == 'eliminarSuscripcion'){
            $html = <<<EOS
            <div>
                <button id="botonEliminarSus" type="submit" name="eliminar" value="eliminar"> Cancelar Suscripcion </button>
            </div>
            EOS;
        }
        return $html;
    }

    protected function procesaFormulario(&$datos){
        $username = filter_var($_SESSION['username'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // Obtener datos
        if($this->modo == 'eliminarSuscripcion'){
            $eliminar = isset($datos['eliminar']) ?? htmlspecialchars($datos['eliminar']);
            if($eliminar == 'eliminar'){
                $done = SW\classes\Suscripcion::eliminarSuscripcion($username);
                $_SESSION['isSub'] = null;
            }
        }else if($this->modo == 'añadirSuscripcion'){
            $tipo = isset($datos['tipo_suscripcion']) ? htmlspecialchars($datos['tipo_suscripcion']) : null;
            $id_usuario = $username;
            $today = new DateTime();
            

            // Comprobar que el tipo de suscripcion es correcto
            if( $tipo == 'mensual' || $tipo == 'anual' || $tipo == 'prueba'){
                $user = SW\classes\Usuario::buscaUsuario($username);
                if($tipo == 'mensual'){
                    if ($user->getKarma() >= 500){
                        $user->setKarma($user->getKarma() - 500);
                        $today->add(new \DateInterval('P1M'));
                    }
                    else
                        $this->errores["precio"]= "No tienes suficeintes corcheas"; 
                }else if($tipo == 'anual'){
                    if ($user->getKarma() >= 1500){
                        $user->setKarma($user->getKarma() - 1500);
                        $today->add(new \DateInterval('P1Y'));
                    }
                    else
                        $this->errores["precio"]= "No tienes suficeintes corcheas";
                }else{
                    $today->add(new \DateInterval('PT30S'));
                }
                $user->actualiza();
                if ($this->errores["precio"] !== "No tienes suficeintes corcheas" ){
                    $done = SW\classes\Suscripcion::insertarSuscripcion($username, $tipo, $today->format('Y-m-d H:i:s'));
                    $_SESSION['isSub'] = $tipo;
                }
            }

        }

    }

}