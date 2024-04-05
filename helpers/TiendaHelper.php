<?php

require_once RUTA_CLASSES.'/Producto.php';
require_once RUTA_CLASSES.'/Pedido.php';

function creacionCarritoHTML($id, $nombre, $descripcion, $autor, $image, $stock, $precio, $id_pedido, $cantidad, $user){

    $rutaProdImg = RUTA_IMG_PATH.'/prodImages/'.$image;
    $rutaProducto = RUTA_VISTAS_PATH.'/tienda/ProductoVista.php';
    
    $total = $cantidad * $precio;
    //Imagen y nombre del producto
    $prodInfo =<<<EOS
    <div class="prod_info">
        <img alt = "prod_info" src= $rutaProdImg width = "70" heigth = "70">
        <div><a href= "$rutaProducto?prod=$id" name= "prod">@$autor</a>, $nombre</div>
    </div>
    EOS;

    //Descripcion del producto
    $prodDesc =<<<EOS2
    <div class="prod_desc">
        <p>$descripcion</p> 
        <p>Has seleccionado $cantidad unidades por valor de $precio &#9834 cada una</p>
    </div>
    <div class="prod_precio">
        <p>Total: $total &#9834</p
    </div>
    EOS2;

    

    
    $botones = '';
    
    //Eliminar un producto
    $rutaEliminar = RUTA_HELPERS_PATH.'/ElimCarrito.php';

    $botones .= <<<EOS4
    <form action= $rutaEliminar method="post">
        <input type="hidden" name="EliminarID" value= '$id'>
        <input type="hidden" name="PedidoID" value= '$id_pedido'>

        <button type="submit"> Eliminar</button>
    </form>
    EOS4;


    $html =<<<EOS6
        <article class = "estiloProd">
            $prodInfo
            $prodDesc
            $botones
        </article>
    EOS6;

    return $html;
}
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
    if($stock != 0){
     
        $compra = '<button type = "submit"> Comprar </button>
                   <input type="number" name="Cantidad" value="0" min="1" max="'. $stock.'"/>
                   <p style="display:inline"> <output name="result">0</output> &#9834</p> ';
    }
    //Descripcion del producto
    $prodDesc =<<<EOS2
    <div class="prod_desc">
        <p>$descripcion</p> 
        <p>Quedan $stock unidades por valor de $precio &#9834 cada una</p>
        <form action = $rutaCompra method="post" oninput="result.value= (parseFloat($precio) * parseInt(Cantidad.value)).toFixed(2)">            
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
    
    $content = "<h1 class = 'texto_infor'> Productos </h1>";
    $content .= "<section class = 'listaArticulos'>";
    $productos = Producto::obtenerListaDeProductos();

    foreach($productos as $prod){
        $content .= creacionProductoHTML($prod->getId(), $prod->getNombre(), $prod->getDescripcion(), $prod->getAutor(),
                                         $prod->getImagen(), $prod->getStock(), $prod->getPrecio(), $yoYYoMismo);   
    }
    $content .= "</section>";

    return $content;
}

function showCarrito($user){
    $rutaComprar = RUTA_HELPERS_PATH.'/ProcesarCompra.php';


    $content = "<h1 class = 'texto_infor'> Tu Carrito </h1>";
    $content .= <<< EOS
    <form class= 'boton_publicar' action = $rutaComprar method = "post">
    <button type = "submit">Compra</button>
    </form>
    EOS;

    $content .= "<section class = 'listaArticulos'>";

    $pedido = Pedido::buscarPedidoPorUser($user);
    $id_pedido = $pedido->getId();
    $productos = Producto::obtenerProductosDePedido($id_pedido);

    foreach($productos as $item) {
        $prod = $item['producto'];
        $cantidad = $item['cantidad'];
        $content .= creacionCarritoHTML($prod->getId(), $prod->getNombre(), $prod->getDescripcion(), $prod->getAutor(),
                                         $prod->getImagen(), $prod->getStock(), $prod->getPrecio(), $id_pedido, $cantidad, $user);   
    }
    $content .= "</section>";

    return $content;
}