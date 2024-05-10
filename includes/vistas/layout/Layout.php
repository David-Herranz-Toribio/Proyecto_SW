<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= CSS_PATH ?>/estilos.css">
    <link id= "estilo" rel="stylesheet" href="<?= CSS_PATH ?>/estiloOscuro.css">
    <link rel="shortcut icon" href="<?=IMG_PATH ?>/2MelodyLogo.png" />
    <title> 2Music </title>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <?php
        $scripts = $scripts ?? [];
        foreach ($scripts as $script) {
            echo "<script src=\"" . JS_PATH . "/$script\"></script>";
        }
    ?>
</head>

<body>
    <div class="container">
    <?php require_once 'Cabecera.php'; ?>
        <?php require_once 'Sidebar.php'; ?>
        <main id='content'>
            <?= $content ?>
        </main>
        <?php require_once 'Footer.php'; ?>
        
    </div> 
</body>
</html>