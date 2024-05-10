<?php

require_once CLASSES_URL . '/Producto.php';
require_once CLASSES_URL . '/Pedido.php';
require_once CLASSES_URL . '/Usuario.php';
require_once CLASSES_URL . '/FormularioProducto.php'; 


function suscripcionHTML($yo){
    $content ="";
    if(isset($_SESSION['isAdmin'] ) && ($_SESSION['isAdmin'] == true)){
        $rutaComprobar = HELPERS_PATH . '/ComprobarSuscripcion.php';
        $rutaAumentarKarma = HELPERS_PATH . '/AumentarKarma.php';
        $rutaSus = VIEWS_PATH . '/tienda/Suscripcion.php';
        $content .=  <<<EOS3
        <div id="actualizarAdmin">
            <h4>Panel Admin (Simular Script de Cron)</h4>
            <form action= "$rutaComprobar" method="post">
                <button type="submit" name="actualizar" value="$rutaSus"> Actualizar </button>
            </form>
            <h4>Aumentar karma en 200</h4>
            <form action= "$rutaAumentarKarma" method="post">
                <input type="text" name="nombre" value="" placeholder="Ej: user2">
                <button type="submit" name="karma" value="$rutaSus">Aumentar karma</button>
            </form>
        </div>
        EOS3;
    }

    $content .= "<section class='default'>";

    if(!is_null($_SESSION['isSub']) ){
        $diadehoy = date('Y-m-d H:i:s');
        $diadeexpiracion = SW\classes\Suscripcion::getFechaExpiracion($yo);
        $diferencia = strtotime($diadeexpiracion) - strtotime($diadehoy);
        $diferencia = $diferencia * 1000;
        $content .= <<<EOS2
            <h1>¡Ya tienes una suscripción activa!</h1>
            <p>Si deseas cambiar tu suscripción, primero cancela la actual</p>
            <p>Si deseas cancelar tu suscripción, ve a tu perfil</p> 

            <div class="timer" id="timer">
                Tiempo restante: <span id="time">00:00:00</span>
            </div>
            <script>startTimer($diferencia);</script>
        EOS2;

        $form= new formularioSuscripcion($yo,'eliminarSuscripcion');

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


    return $content;


}
function creacionCarritoHTML($id, $nombre, $descripcion, $autor, $image, $stock, $precio, $id_pedido, $cantidad, $user){

    $rutaProdImg = IMG_PATH .  '/prodImages/'.$image;
    $rutaProducto = VIEWS_PATH . '/tienda/ProductoVista.php';
    $rutaArtista = VIEWS_PATH . '/perfil/Perfil.php';
    
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
    $rutaEliminar = HELPERS_PATH . '/ElimCarrito.php';

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

    $rutaProdImg = IMG_PATH .  '/prodImages/'.$image;
    $rutaProducto = VIEWS_PATH . '/tienda/ProductoVista.php';
    $rutaArtista = VIEWS_PATH . '/perfil/Perfil.php';

    $rutaCompra = HELPERS_PATH . '/ProcesarProducto.php';

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

    $compra = '<p> No queda stock </p>';
    if($stock != 0){
     
        $compra = '<button type = "submit" class = "botonCompra"> Comprar </button>
                   <input type="number" name="Cantidad" value="0" min="0" max="'. $stock.'"/>
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
    
    $botones = '';
    
    //Eliminar y modificar un producto
    if ($yoYYoMismo == $autor || (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == true)){
        $rutaMod = VIEWS_PATH . '/tienda/MiTiendaVista.php';
        $rutaEliminar = HELPERS_PATH . '/ProcesarElimProd.php';

        $botones .= <<<EOS4
        <div class= 'modElim'> 
        <form action = $rutaMod method="get">
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
    $prod = SW\classes\Producto::obtenerProductoporId($id);

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
    
    $content = "<section class = 'listaArticulos'>";
    $productos = SW\classes\Producto::obtenerListaDeProductos();
    if(!empty($productos)){
        if (isset($_GET['query'])) {
            $textoBusqueda = $_GET['query'];
            $productos = SW\classes\Producto::LupaNombreProductoExistentes($productos, $textoBusqueda);
        }   
    }
    foreach($productos as $prod){
        $content .= creacionProductoHTML($prod->getId(), $prod->getNombre(), $prod->getDescripcion(), $prod->getAutor(),
                                         $prod->getImagen(), $prod->getStock(), $prod->getPrecio(), $yoYYoMismo);   
    }
    $content .= "</section>";

    return $content;
}

function showProductsArtista($yoYYoMismo){
    
    $content = "<section class = 'listaArticulos'>";
    $productos = SW\classes\Producto::obtenerProductosDeArtista($yoYYoMismo);
    if(!empty($productos)){
        if (isset($_GET['query'])) {
            $textoBusqueda = $_GET['query'];
            $productos = SW\classes\Producto::LupaNombreProductoExistentes($productos, $textoBusqueda);
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
    $rutaComprar = HELPERS_PATH . '/ProcesarCompra.php';
    $acum_precio = 0;
    $acum_cantidad = 0;
    $diferencia = 0;
    $comprable = true;

    $content = "<h1 class = 'texto_infor'> Tu Carrito </h1>";
    $seccion =  "<section class = 'listaArticulos'>";

    $pedido = SW\classes\Pedido::buscarPedidoPorUser($user);

    if(empty($pedido)){
        $seccion .=  "<h1>No tienes ningun pedido activo</h1>";
    }else{
        $id_pedido = $pedido->getId();
        $productos = SW\classes\Producto::obtenerProductosDePedido($id_pedido);

        if(empty($productos))
            $seccion .=  "<h1>No tienes ningun producto en tu carrito</h1>";
        else{
            $resumen = "<div id='resumen_carrito'>
            
            <h2>Resumen Pedido</h2>";
            $iter = 0;
            foreach($productos as $prod) {
                $iter++;
                $cantidad = $prod->cantidad;
                $acum_cantidad += $cantidad;

                $prod = $prod->producto;
                $precio = $prod->getPrecio();
                $acum_precio += ($cantidad * $precio);
                
                $resumen .="<h4>".$iter.". ".$prod->getNombre()." --- ".($cantidad * $precio) ."&#9834</h4>";

                $seccion .=  creacionCarritoHTML($prod->getId(), $prod->getNombre(), $prod->getDescripcion(), $prod->getAutor(),
                                                $prod->getImagen(), $prod->getStock(), $precio, $id_pedido, $cantidad, $user);   
            }
            
            $user = SW\classes\Usuario::buscaUsuario($user);

            $karma = $user->getKarma();
            $user = $user->getUsername();

            $resumen .="
                    <h3>--------------------------------</h3>
                    <h3>Precio Total: ". $acum_precio."&#9834</h3>
                    <h3>Cantidad: " .$acum_cantidad."</h3>
                    <h3>-</h3>
                    <h3>Tu Saldo (&#9834): ". $karma ."</h3>";

            if ($_SESSION['isSub'] == true){
                $descuento = intval($acum_precio * 0.1);
                $acum_precio -= $descuento;
                $resumen .="<h3 style='color:yellow;'>Descuento por suscriptor: ". $descuento."&#9834</h3>";
            }                
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


function showHistorialPedidos($id_user){
    
    /*Sacar de la BD los pedidos ya procesados */ 


    if(($pedidos= SW\classes\Pedido:: buscarHistorialPedidos($id_user))==NULL){
        $lista= "<h3> Ningun pedido realizado todavía </h3>"; 
    }  

    else {
        $lista= ''; 
        if (isset($_GET['query'])) {
            $textoBusqueda = $_GET['query'];
            $pedidos = SW\classes\Pedido::LupaFechaHistorialPedidos($pedidos, $textoBusqueda);
        }
        foreach($pedidos as $pedido){
            $lista.= "<article class= 'estiloPed'>";
            $id_ped= $pedido->getId(); 
            $productos=  SW\classes\Producto::obtenerProductosDePedido($id_ped);
            $lista.= "<div class='prod_info'>
                        <h3> Ident. Pedido:". $id_ped ."</h3>
                        <h3> Fecha: ".$pedido->getFecha()."</h3>
                        <h3> Total: ".$pedido->getTotal()." &#9834</h3>
                        </div>";   
            $lista.= "<div class= 'estiloPedido'>";
            foreach($productos as $prod_cant) {
                $lista .= "<div class= 'estiloProd'>"; 
                $producto= $prod_cant->producto;
                $id_prod=  $producto->getId(); 
                $name_prod= $producto->getNombre(); 
                $desc_prod= $producto->getDescripcion(); 
                $autor_prod= $producto->getAutor(); 
                $img_prod= $producto->getImagen(); 
                $cantidad_prod= $prod_cant->cantidad; 
                $precio_prod=  $producto->getPrecio();                               
                $total= $cantidad_prod * $precio_prod;
    
                $rutaProdImg = IMG_PATH .  '/prodImages/'.$img_prod;
                $rutaProducto = VIEWS_PATH . '/tienda/ProductoVista.php';
                $rutaArtista = VIEWS_PATH . '/perfil/Perfil.php';
    
    
    
                $lista.= <<<EOS
                <img alt = "prod_info" src= $rutaProdImg width = "70" heigth = "70">
                <p>$name_prod</p>
                <div>
                <a href= "$rutaArtista?user=$autor_prod" name= "prod" >
                  <p>Creador: @$autor_prod</p>
                </a>
                 </div>
    
    
                 <div class="prod_precio">
                 <p> Cantidad: $cantidad_prod unidades</p>
                 <p> Total: $total &#9834</p>
                 </div>
                EOS; 
    
                $lista .= "</div>"; 
            }
            $lista.= "</div>";
    
            $lista .= "</article>"; 
        }
    
        $lista.= "</section>";      
    }
   
    return $lista; 
}

function addProd($yo, $id_prod){
    $form= new FormularioProducto($id_prod, $yo); 
    $htmlform= $form->gestiona(); 

    $content =<<<EOS
    <h1 class = 'texto_infor'> Tus productos </h1>
    <section class = 'formulario_style'>
       $htmlform
    </section>
    EOS;

    return $content;
}
