<?php

require_once RUTA_CLASSES.'/Producto.php';

function creacionProductoHTML($id, $nombre, $descripcion, $autor, $image, $stock, $precio, $yoYYoMismo){

    $rutaProdImg = RUTA_IMG_PATH.'/prodImages/'.$image;
    $rutaProducto = RUTA_VISTAS_PATH.'/tienda/ProductoVista.php';
    $rutaCompra = RUTA_HELPERS_PATH.'/ProcesarProducto.php';

    //Imagen y nombre del producto
    $prodInfo =<<<EOS
    <div class="prod_info">
        <img alt = "prod_info" src= $rutaProdImg width = "70" heigth = "70">
        <div><a href= "$rutaProducto?prod=$id" name= "prod">@$autor</a>, $nombre</div>
    </div>
    EOS;

    $compra = '<p>No queda stock</p>';
    if($stock != 0)
        $compra = '<button type = "submit"> Comprar </button>';

    //Descripcion del producto
    $prodDesc =<<<EOS2
    <div class="prod_desc">
        <p>$descripcion</p> 
        <p>Quedan $stock unidades por valor de $precio cada una</p>
        <form action = $rutaCompra method="post">
            <input hidden name="Cantidad" value="1"> 
            <input hidden name="Id" value= $id> 
            $compra
        </form>
    </div>
    EOS2;

    
    //Likes, respuestas y responder
    /*
    if (soy admin){

    }
    */
    
    $botones = '';
    /*
    Eliminar y modificar un producto
    if ($yoYYoMismo == $autor){
        $rutaMod = RUTA_VISTAS_PATH.'/foro/ModificarVista.php';
        $rutaEliminar = RUTA_HELPERS_PATH.'/ProcesarEliminar.php';

        $botones .= <<<EOS4
        <form action = $rutaMod method="post">
            <input type = "hidden" name = "ModificarID" value = "$id">
            <button type = "submit"> Modificar</button>
        </form>

        <form action= $rutaEliminar method="post">
            <input type="hidden" name="EliminarID" value= '$id'>
            <button type="submit"> Eliminar</button>
        </form>
        EOS4;
    }
    */


    $html =<<<EOS6
        <article class = "estiloProd">
            $prodInfo
            $prodDesc
            $botones
        </article>
    EOS6;

    return $html;
}

function showProducts($yoYYoMismo){
    
    $content = "<h1 class = 'texto_infor'> Artículos </h1>";
    $content .= "<section class = 'listaArticulos'>";
    $productos = Producto::obtenerProductosDeArtista('user2');
    //$productos = Producto::obtenerListaDeProductos();

    foreach($productos as $prod){
        $content .= creacionProductoHTML($prod->getId(), $prod->getNombre(), $prod->getDescripcion(), $prod->getAutor(),
                                         $prod->getImagen(), $prod->getStock(), $prod->getPrecio(), $yoYYoMismo);   
    }
    $content .= "</section>";

    return $content;
}