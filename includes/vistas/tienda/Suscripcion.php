<?php

require_once '../../Config.php';
require_once HELPERS_URL . '/TiendaHelper.php';
require_once CLASSES_URL . '/FormularioSuscripcion.php';    

$yo = isset($_SESSION['username']) ? $_SESSION['username'] : null;


if(!$yo){
    header('Location: '. VIEWS_PATH . '/log/Login.php');
    exit();
}
$content = "<section class='default'>";

if(isset($_SESSION['suscripcion']) ){
    $content .= <<<EOS2
                 <h1>¡Ya tienes una suscripción activa!</h1>
                 <p>Si deseas cambiar tu suscripción, primero cancela la actual</p>
                 <p>Si deseas cancelar tu suscripción, ve a tu perfil</p> 

                <div class="timer" id="timer">
                    Tiempo restante: <span id="time">00:00:00</span>
                </div>
                <script>
                    // Solicitar la hora del servidor una sola vez al cargar la página
                startTimer("2024-12-30T23:59:59");
                function startTimer(serverTime) {
                        const countDownDate = new Date("2024-12-31T23:59:59").getTime();
                        let now = new Date(serverTime).getTime();

                        // Actualizar el contador cada segundo
                        const interval = setInterval(function() {
                            now += 1000; // Simplemente incrementar la hora localmente
                            const distance = countDownDate - now;

                            let days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                            document.getElementById("time").innerHTML = days + "d " + hours + "h " +
                                minutes + "m " + seconds + "s ";

                            if (distance < 0) {
                                clearInterval(interval);
                                document.getElementById("timer").innerHTML = "¡Tiempo expirado!";
                            }
                        }, 1000);
                    }
                    </script>
                EOS2;

    $form= new formularioSuscripcion($yo,'archivarSuscripcion');

}else{

    $content .= <<<EOS
    <div>
        <h1>2Melody Premium</h1>
    </div>
    <h2>Experiencia sin límites</h2>
    <p>Con 2Melody Premium podrás disfrutar de todas tus canciones sin interrupciones, así como grandes
    descuentos en los productos de tus artistas favoritos, personalización avanzada y mucho más</p>
    
    EOS;
    
    $form= new formularioSuscripcion($yo,'añadirSuscripcion');

}

$content .= $form->gestiona();


$content .= "</section>";



require_once LAYOUT_URL;