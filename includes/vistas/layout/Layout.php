<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= CSS_PATH ?>/estilos.css">
    <link id= "estilo" rel="stylesheet" href="<?= CSS_PATH ?>/estiloOscuro.css">
    <link rel="shortcut icon" href="<?=IMG_PATH ?>/2MelodyLogo.png" />
    <title> 2Music </title>

    <script type="text/javascript" src="<?= JS_PATH?>/jquery-3.7.1.min.js"> </script> 
    <script type="text/javascript" src="<?= JS_PATH?>/eventos.js"> </script> 
    <script type="text/javascript" src="<?= JS_PATH?>/playerLogic.js"> </script> 
</head>

<body>
    <script>peticionAjaxSus("<?= HELPERS_PATH?>/ComprobarSuscripcion.php", {});</script>
    <div class="container">

    <?php require_once 'Cabecera.php'; ?>
    <main id='content'>
        <?= $content ?>
    </main>
    <?php require_once 'Sidebar.php'; ?>
     
    </div> 

    <script type="text/javascript" src="<?= JS_PATH ?>/cambioModo.js">  </script> <!-- Script para el cambio de modo --> 
    <script type="text/javascript" src="<?= JS_PATH ?>/validaciones.js"> </script>  <!-- Script para las validaciones de formularios -->

</body>
</html>