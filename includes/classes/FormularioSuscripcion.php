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

    public function __construct($id_usuario) {
        parent::__construct('formSuscripcion',['urlRedireccion' => VIEWS_PATH .'/tienda/Suscripcion.php']);
        $this->id_usuario = $id_usuario;
    }

    protected function generaCamposFormulario(&$datos){


        // Se generan los mensajes de error si existen NO EXISTEN
        
        
        $html =<<<EOS
        <div id="suscripciones">
            <div class="tipo_suscripcion">
                <h3> Prueba (Testeing del final) </h3>
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
                <h3> Anual (1 Anyo) </h3>
                <div>
                    <button type="submit" name="tipo_suscripcion" value="anual"> Crear </button>
                </div>
            </div>
        </div>
        EOS;

        return $html;
    }

    protected function procesaFormulario(&$datos){

        // Obtener datos
        $tipo = htmlspecialchars($_POST['tipo_suscripcion']);
        $id_usuario = $_SESSION['username'];
        $today = new DateTime();
        

        // Validar datos
        $this->errores = [];
        $today_num = intval(date("Ymd", strtotime($today->format('Y-m-d'))));
        $date_num = intval(date("Ymd", strtotime($creationDate->format('Y-m-d'))));

        if( $tipo == 'mensual' || $tipo == 'anual'){
            $done = SW\classes\Producto::insertarSuscripcion($_SESSION['username'], $tipo, $today->format('Y-m-d'));
            $_SESSION['suscripcion'] = $tipo;
        }

    }

}