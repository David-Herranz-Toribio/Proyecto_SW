
<?php
require_once 'FormularioMultimedia.php'; 
require_once 'Usuario.php'; 
require_once 'Producto.php';

class FormularioProducto extends FormularioMultimedia
{
    private $id_product; 
    private $publicador;

    public function __construct($id_product, $publicador) {
        parent::__construct('formPublicaPost', ['urlRedireccion' =>  VIEWS_PATH .'/tienda/MiTiendaVista.php', 'enctype' => 'multipart/form-data']);
        $this->id_product= $id_product; 
        $this->publicador= $publicador; 
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        if(!is_null($this->id_product)){
            $prod = SW\classes\Producto::obtenerProductoporId($this->id_product);
      
            $nombre = $prod->getNombre();
            $descripcion = $prod->getDescripcion();
            $stock = $prod->getStock();
            $precio = $prod->getPrecio();
    
            $imagen = $prod->getImagen();  
    
            $imagen_html = "<img src='".IMG_PATH . '/prodImages/'. $imagen."' width = '70' heigth = '70'>";
        }

        else {
            $prod= ''; 
            $nombre= ''; 
            $descripcion= ''; 
            $stock= ''; 
            $precio= ''; 
            $imagen= 'FotoMerch.png'; 
            $imagen_html= ''; 
        }

        $htmlErroresGlobales =  self::generaListaErroresGlobales($this->errores);
        $erroresCampos= self::generaErroresCampos(['imagen'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
            <fieldset> 
            <input type = "hidden" name = "Autor" value = "$this->publicador">
            <input type = "hidden" name = "Id" value = $this->id_product>
            <input type = "hidden" name = "Imagen_antigua" value = $imagen>

            <label>Nombre</label>
            <input type="text" name="Nombre" value="$nombre">

            <label>Imagen</label>
            <div> 
            <input type = "file" name = "Imagen" accept = "image/*">
            {$erroresCampos['imagen']}
            $imagen_html
            </div> 

            <label>Descripcion</label>

            <textarea name = "Descripcion">$descripcion</textarea>

            <label>Stock</label>
            <input type="number" name="Stock" value="$stock" min="1" max='9999'/>

            <label>Precio</label>
            <input type="number" name="Precio" value="$precio" min="1" max='9999'/>

            <button type = "submit">Crear producto</button>
            </fieldset> 
        EOF;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = []; 

        $id= filter_var($datos['Id'], FILTER_VALIDATE_INT);  
        $autor = isset($datos['Autor']) ? filter_var($datos['Autor'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
        $nombre = htmlspecialchars($datos['Nombre']);
        $descripcion = isset($datos['Descripcion']) ? htmlspecialchars($datos['Descripcion']) : "$nombre de $autor"; 
        $stock= filter_var($datos['Stock'], FILTER_VALIDATE_INT);  
        $precio = filter_var($datos['Precio'], FILTER_VALIDATE_FLOAT);
        $imagen_ant= htmlspecialchars($datos['Imagen_antigua']); 
        $imagen= self::compruebaImagen($nombre, 'imagen', '/prodImages/'); 

        if(count($this->errores)===0){
            $producto = SW\classes\Producto::crearProducto($id, $nombre, $descripcion, $imagen ?? $imagen_ant , $autor, $stock, $precio);
            $producto->guarda();
        }
        
    }
}