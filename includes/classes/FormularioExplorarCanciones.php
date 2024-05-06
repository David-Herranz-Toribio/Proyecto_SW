<?php

require_once 'Formulario.php';


class FormularioExplorarCanciones extends Formulario{

    public function __construct(){
        parent::__construct('formExplorarCanciones', ['urlRedireccion' =>  VIEWS_PATH .'/musica/ExplorarCanciones.php']);
    }

    protected function generaCamposFormulario(&$datos){

        $viewPath = VIEWS_PATH . '/musica/ExplorarCanciones.php';
        $generosMusicales = ['Pop', 'Rock', 'Rap', 'Hip Hop', 'Latino', 'Jazz', 'R&B', 'K-Pop',
                            'J-Pop', 'Dubstep', 'Clásica', 'Disco', 'Funk', 'Jazz', 'Reggae', 'Metal'];

        $html =<<<EOS
        <form method='get'>
        <div class='tablaGeneros'>
        EOS;

        foreach($generosMusicales as $genero){
            $html.=<<<EOS
            <a href=$viewPath?genre=$genero>
            <div class='musicalGenre'>
                $genero
            </div>
            </a>
            EOS;
        }

        $html.=<<<EOS
        </div>
        </form>
        EOS;

        return $html;
    }

    protected function procesaFormulario(&$datos){
        
    }

}