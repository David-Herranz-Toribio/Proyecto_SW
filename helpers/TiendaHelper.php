<?php

require_once RUTA_CLASSES.'/Producto.php';
require_once RUTA_CLASSES.'/Pedido.php';
require_once RUTA_CLASSES.'/Usuario.php';

function creacionCarritoHTML($id, $nombre, $descripcion, $autor, $image, $stock, $precio, $id_pedido, $cantidad, $user){

    $rutaProdImg = RUTA_IMG_PATH.'/prodImages/'.$image;
    $rutaProducto = RUTA_VISTAS_PATH.'/tienda/ProductoVista.php';
    $rutaArtista = RUTA_VISTAS_PATH.'/perfil/Perfil.php';
    
    $total = $cantidad * $precio;
    //Imagen y nombre del producto
    $prodInfo =<<<EOS
    <div class="prod_info">
        <a href= "$rutaProducto?prod=$id" name= "prod" >
            <img alt = "prod_info" src= $rutaProdImg width = "70" heigth = "70">
            <p>$nombre</p>
        </a>
        <div>
            <a href= "$rutaArtista?user=$autor" name= "prod" >
              <p>Creador: @$autor</p>
            </a>
        </div>
    </div>
    <div class="prod_precio">
        <p> Cantidad: $cantidad unidades</p>
        <p> Total: $total &#9834</p>
    EOS;
    
    $boton = '';
    
    //Eliminar un producto
    $rutaEliminar = RUTA_HELPERS_PATH.'/ElimCarrito.php';

    $boton .= <<<EOS4
    <form action= $rutaEliminar method="post">
        <input type="hidden" name="EliminarID" value= '$id'>
        <input type="hidden" name="PedidoID" value= '$id_pedido'>

        <button type="submit"> Eliminar</button>
    </form>
    </div>

    EOS4;


    $html =<<<EOS6
        <article class = "estiloProd">
            $prodInfo
            $boton
        </article>
    EOS6;

    return $html;
}
function creacionProductoHTML($id, $nombre, $descripcion, $autor, $image, $stock, $precio, $yoYYoMismo){

    $rutaProdImg = RUTA_IMG_PATH.'/prodImages/'.$image;
    $rutaProducto = RUTA_VISTAS_PATH.'/tienda/ProductoVista.php';
    $rutaArtista = RUTA_VISTAS_PATH.'/perfil/Perfil.php';

    $rutaCompra = RUTA_HELPERS_PATH.'/ProcesarProducto.php';

    //Imagen y nombre del producto
    $prodInfo =<<<EOS
    <div class="prod_info">
        <a href= "$rutaProducto?prod=$id" name= "prod" >
            <img alt = "prod_info" src= $rutaProdImg width = "70" heigth = "70">
            <p>$nombre</p>
        </a>
        <div>
            <a href= "$rutaArtista?user=$autor" name= "prod" >
              <p>Creador: @$autor</p>
            </a>
        </div>
    </div>

    EOS;

    $compra = '<p>No queda stock</p>';
    if($stock != 0){
     
        $compra = '<button type = "submit" class = "botonCompra"> Comprar </button>
                   <input type="number" name="Cantidad" value="0" min="1" max="'. $stock.'"/>
                   <p style="display:inline"> <output name="result">0</output> &#9834</p> ';
    }
    //Descripcion del producto
    $prodDesc =<<<EOS2
    <div class="prod_info">
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
    
    //Eliminar y modificar un producto
    if ($yoYYoMismo == $autor){
        $rutaMod = RUTA_VISTAS_PATH.'/foro/ModificarVista.php';
        $rutaEliminar = RUTA_HELPERS_PATH.'/ProcesarEliminar.php';

        $botones .= <<<EOS4
        <div class= 'modElim'> 
        <form action = $rutaMod method="post">
            <input type = "hidden" name = "ModificarID" value = "$id">
            <button type = "submit"> &#9998 </button>
        </form>

        <form action= $rutaEliminar method="post">
            <input type="hidden" name="EliminarID" value= '$id'>
            <button type="submit"> &#10060 </button>
        </form>
        </div>
        EOS4;
    }
    


    $html =<<<EOS6
        <article class = "estiloProd">
            $prodInfo
            $prodDesc
            $botones
        </article>
    EOS6;

    return $html;
}


function showProduct($yoYYoMismo, $id){
    $prod = Producto::obtenerProductoporId($id);

    // Por si hay que hacer alguna busqueda mas tarde

    // if(!empty($productos)){
    //     if (isset($_GET['query'])) {
    //         $textoBusqueda = $_GET['query'];
    //         $productos = Producto::LupaNombreProductoExistentes($productos, $textoBusqueda);
    //     }   
    // }

    $content = "<h1 class = 'texto_infor'> Producto ".$prod->getNombre()." </h1>";
    $content .= "<section class = 'listaArticulos'>";

    // MIRAR LOS BOCETOS PARA HACER ALGO MAS ESPECIFICO PARA PRODUCTO INDIVIDUAL Y PONER POST AQUI TAMBIEN POR EJEMPLO
    $content .= creacionProductoHTML($prod->getId(), $prod->getNombre(), $prod->getDescripcion(), $prod->getAutor(),
                                         $prod->getImagen(), $prod->getStock(), $prod->getPrecio(), $yoYYoMismo);   



                                       
    $content .= "</section>";

    return $content;

}

function showProducts($yoYYoMismo){
    
    $content = "<h1 class = 'texto_infor'> Productos </h1>";
    $content .= "<section class = 'listaArticulos'>";
    $productos = Producto::obtenerListaDeProductos();
    if(!empty($productos)){
        if (isset($_GET['query'])) {
            $textoBusqueda = $_GET['query'];
            $productos = Producto::LupaNombreProductoExistentes($productos, $textoBusqueda);
        }   
    }
    foreach($productos as $prod){
        $content .= creacionProductoHTML($prod->getId(), $prod->getNombre(), $prod->getDescripcion(), $prod->getAutor(),
                                         $prod->getImagen(), $prod->getStock(), $prod->getPrecio(), $yoYYoMismo);   
    }
    $content .= "</section>";

    return $content;
}

function showCarrito($user){
    $rutaComprar = RUTA_HELPERS_PATH.'/ProcesarCompra.php';
    $acum_precio = 0;
    $acum_cantidad = 0;
    $diferencia = 0;
    $comprable = true;

    $content = "<h1 class = 'texto_infor'> Tu Carrito </h1>";
    $seccion =  "<section class = 'listaArticulos'>";

    $pedido = Pedido::buscarPedidoPorUser($user);

    if(empty($pedido)){
        $seccion .=  "<h1>No tienes ningun pedido activo</h1>";
    }else{
        $id_pedido = $pedido->getId();
        $productos = Producto::obtenerProductosDePedido($id_pedido);

        if(empty($productos))
            $seccion .=  "<h1>No tienes ningun producto en tu carrito</h1>";
        else{
            $resumen = "<div id='resumen_carrito'>
            
            <h2>Resumen Pedido</h2>";
            $iter = 0;
            foreach($productos as $item) {
                $iter++;
                $prod = $item['producto'];
                $cantidad = $item['cantidad'];
                $acum_cantidad += $cantidad;

                $precio = $prod->getPrecio();
                $acum_precio += ($cantidad * $precio);
                $resumen .="<h4>".$iter.". ".$prod->getNombre()." --- ".($cantidad * $precio) ."&#9834</h4>";
                $seccion .=  creacionCarritoHTML($prod->getId(), $prod->getNombre(), $prod->getDescripcion(), $prod->getAutor(),
                                                $prod->getImagen(), $prod->getStock(), $precio, $id_pedido, $cantidad, $user);   
            }
            
            $user = Usuario::buscaUsuario($user);

            $karma = $user->getKarma();
            $user = $user->getUsername();

            $resumen .="
                    <h3>--------------------------------</h3>
                    <h3>Precio Total: ". $acum_precio."&#9834</h3>
                    <h3>Cantidad: " .$acum_cantidad."</h3>
                    <h3>-</h3>
                    <h3>Tu Saldo (&#9834): ". $karma ."</h3>";
            $diferencia = intval($karma - $acum_precio);
            if ($diferencia  < 0) {
                $comprable = false;
                $resumen .="<h3 style='color:red;'>Nuevo saldo: ". $diferencia."&#9834</h3>";

            }else
                $resumen .="<h3 style='color:green;'>Nuevo saldo: ". $diferencia."&#9834</h3>";
            
            if($comprable){
                $resumen .= <<< EOS
                    <form class= 'boton_publicar' action = $rutaComprar method = "post">
                        <input type ="hidden" name="id_user" value="$user">
                        <input type ="hidden" name="nuevo_karma" value="$diferencia">
                        <input type ="hidden" name="precio_total" value="$acum_precio">
                        <button type = "submit">Compra</button>
                    </form>    
                EOS;
            }
            $content .= $resumen ."</div>";
        }
    }
    $seccion .=  "</section>";



    $content .=  $seccion;
    return $content;
}