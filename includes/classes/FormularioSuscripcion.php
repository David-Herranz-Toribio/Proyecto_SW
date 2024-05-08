<?php

require_once 'Formulario.php';


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
        
        
        $html =<<<EOS
        <div id="suscripciones">
            <div class="tipo_suscripcion">
                <h3> Prueba (Testing) </h3>
                <div>
                    <button type="button" name="tipo_suscripcion" value="prueba"> Crear </button>
                </div>
            </div>
            <div class="tipo_suscripcion">
                <h3> Mensual (1 Mes) </h3>
                <div>
                    <button type="submit" name="tipo_suscripcion" value="mensual"> Crear </button>
                </div>
            </div>
            <div class="tipo_suscripcion">
                <h3> Anual (1 Año) </h3>
                <div>
                    <button type="submit" name="tipo_suscripcion" value="anual"> Crear </button>
                </div>
            </div>
        </div>
        EOS;
        if($this->modo == 'archivarSuscripcion'){
            $html = <<<EOS
            <div>
                <button type="submit" name="archivar" value="archivar"> Archivar </button>
            </div>
            EOS;
        }
        return $html;
    }

    protected function procesaFormulario(&$datos){

        // Obtener datos
        if($this->modo == 'archivarSuscripcion'){
            $archivar = isset($datos['archivar']) ?? htmlspecialchars($datos['archivar']);
            if($archivar == 'archivar'){
                $done = SW\classes\Producto::archivarSuscripcion($_SESSION['username']);
                $_SESSION['suscripcion'] = null;
            }
        }else if($this->modo == 'añadirSuscripcion'){
            $tipo = isset($datos['tipo_suscripcion']) ?? htmlspecialchars($datos['tipo_suscripcion']);
            $id_usuario = $_SESSION['username'];
            $today = new DateTime();
            

            // Comprobar que el tipo de suscripcion es correcto
            if( $tipo == 'mensual' || $tipo == 'anual'){
                $done = SW\classes\Producto::insertarSuscripcion($_SESSION['username'], $tipo, $today->format('Y-m-d'));
                $_SESSION['suscripcion'] = $tipo;
            }
        }

    }

}