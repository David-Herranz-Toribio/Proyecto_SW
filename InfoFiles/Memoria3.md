# Memoria Práctica 3

## Funcionalidades implementadas

### Practica 2
* Foro: Se puede publicar solo si estas logeado.
        Modificar y eliminar tus post 
        Responder y dar me gusta a post
        Funcionalidad de karma (que sirve como 'moneda' en la tienda) que se va acumulando al participar en el foro 

* Perfil: Podemos registrarnos e iniciar sesion.

* Menu de navegacion en la parte izquierda 

### Practica 3
* Sumadas a las de la practica 2  

* Perfil: 
          Hay una pagina unica por cada usuario registrado, en ella se encuentra 
          -Datos personales como su nickname, username, descripcion etc... 
          -Menu dentro del perfil donde se podran ver
             -Sus post publicados 
             -Los post a los que ha dado me gusta 
             -Si es artista, podemos ver sus productos de la tienda.
             -Si es tu perfil, puedes ver el historial de pedidos que ya has realizado. 
             -Si es tu perfil, hay un boton que te lleva a una pagina de ajustes donde podras modificar tu perfil 
             -Si es artista, puedes ver la musica que ha publicado (Todavia sin hacer).

          -Puedes seguir a gente y que otra gente te siga. 


* Tienda: Se puede comprar productos
          Añadir productos, modificarlos o eliminarlos si estas registrado como artista 
          Funcionalidad de carrito donde se van añadiendo los productos que compras en la tienda
            -Si no tienes corcheas (otro nombre para el karma) no puedes comprar los productos que has añadido
            -Aunque puedes ir eliminando productos del carro para reducir ese precio 



          
* Barra de busqueda en el foro donde puedes buscar un usuario especifico para el que quieras ver sus post  
* En la tienda esta la misma barra, solo que se usa para buscar determinados productos (Ej: camiseta, poster etc...)

## Funcionalidad en proceso

* Ajustes: Cambiar la apariencia de la pagina 
* Musica: Toda la funcionalidad 
* Añadir a la Tienda entradas de eventos (ej: conciertos)
* Suscripciones 

## Scripts de vistas

* Index
    * index.php

* Foro
    * AddForo.php
    * CrearPost.php
    * Foro.php
    * ModificarVista.php
    * RespuestasForo.php

* Layout
    * Cabecera.php
    * Footer.php 
    * Layout.php
    * Sidebar.php

* Log
    * Login.php
    * Logout.php
    * SignUpArtist.php
    * SignUpUser.php

* Musica
    * Musica.php (Solo es un prototipo, aun no tiene funcionalidad)

* Perfil
    * AjustePerfil.php
    * Perfil.php

* Tienda
    * Carrito.php
    * Merch.php
    * MiTiendaVista.php
    * ProductoVista.php

## Scripts adicionales

### Practica 2

* Clases
    * Usuario.php
    * Post.php
    * BD.php

* Helpers
    * REFERENTES AL PERFIL
       -LoginHelper.php
       -SignUpHelper.php
       -ProcesarLogin.php
       -ProcesarRegistro.php

    * REFERENTES AL FORO 
      -PostHelper.php
      -PostHelper.php
      -CrearPostVista.php
      -ProcesarLike.php
      -ProcesarModificacion.php
      -ProcesarEliminar.php
    
    * REFERENTES A LA CABECERA
      -CabeceraSesion.php

* Navegación
    * Config.php

* Base de datos
    * Estructura BD : 2melody.sql
    * Datos BD : 2melodyDatos.sql


### Practica 3 

* Clases
    * Pedido.php
    * Producto.php
    * Aplicacion.php (La que en la Practica 2 era BD.php)
    
* Helpers
    * REFERENTES AL PERFIL
      -ModificarPerfilHelper.php
      -ProcesarSeguimiento.php
      -ProcesarEliminarUsuario.php

    * REFERENTES AL FORO 
      -PostHelper.php

    * REFERENTES A LA TIENDA  
      -ElimCarrito.php
      -ProcesarProducto.php
      -ProcesarCompra.php
      -TiendaHelper.php
      -ProcesarTienda.php
      -ProcesarElimProd.php

    * REFERENTES A LA MUSICA
      -MusicaHelper (Es un prototipo, aun no se termino de implementarse)


## Usuarios en la base de datos
- usuario: user1 
    - contraseña: adminpass

- usuario: user2 
    - contraseña: adminpass

- usuario: user3 
    - contraseña: adminpass

- usuario: user4 
    - contraseña: adminpass

- usuario: user5 
    - contraseña: adminpass

- usuario: user6 
    - contraseña: adminpass

## Estructura de la base de datos

### Practica 2

- **usuario** (`id_user`, `username`, `nickname`, `password`, `foto`, `descripcion`, `karma`, `num_seguidores`, `num_seguidos`)
  - Esta es la tabla con la información general de todos los usuarios y los datos necesarios para que puedan interactuar con la aplicación. Contiene detalles como el nombre de usuario, contraseña, imagen de perfil, etc.

- **ajustes** (`fuente`, `fontSize`, `temas`, `paginaPrincipal`, `id_user`)
  - Esta tabla almacena las preferencias de ajustes de cada usuario, como la fuente, el tamaño de fuente, el tema preferido, etc., para personalizar su experiencia de uso.

- **artista** (`id_artista`, `integrantes`)
  - Tabla asociada a los usuarios que son artistas, contiene información específica sobre los artistas, como los miembros del grupo musical en el caso de bandas.

- **post** (`id_post`, `id_user`, `texto`, `imagen`, `likes`, `origen`, `tags`, `fecha`)
  - Tabla que almacena los posts realizados por los usuarios, incluyendo texto, imágenes, etiquetas, etc.

- **postfav** (`id_post`, `id_user`)
  - Relación entre los posts y los usuarios que los han marcado como favoritos.


### Practica 3

- **seguidores** (`id_user`, `id_seguidor`)
  - Tabla de seguimiento que relaciona los usuarios con los demás usuarios que siguen.

- **pedido** (`id_pedido`, `id_user`, `estado`, `total`, `fecha`)
  - Almacena información sobre los pedidos realizados por los usuarios, incluyendo su estado y total.

- **producto** (`id_prod`, `id_artista`, `imagen`, `nombre`, `descripcion`, `stock`, `precio`)
  - Contiene detalles sobre los productos disponibles en la tienda, como nombre, descripción, stock y precio.

- **pedido_prod** (`id_pedido`, `id_prod`, `cantidad`)
  - Relación entre los pedidos y los productos que contienen, junto con la cantidad de cada producto en el pedido.







## Parte de actividades por Participante
- por rellenar por cada Participante