<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=RUTA_CSS_PATH?>/estilos.css">
    <title> 2Music </title>
</head>

<body>


    <div class = "container">

    <?php require_once 'Cabecera.php'; ?>
    
    <?php require_once 'Sidebar.php'; ?>
    
    <main class= "content">
        <?= $content ?>
    </main>

    </div> 

    <!-- Incluir footer proximamente = reproductor de música -->
</body>
</html>