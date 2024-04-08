# Memoria Práctica 3

## Funcionalidades implementadas

### Practica 2
* Foro

### Practica 3

* Perfil
* Tienda


## Funcionalidad en proceso

* Segunda
* Tercera


## Scripts de vistas

* Index
    * index.php

* Foro
    * AddForo.php
    * CrearPost.php
    * Foro.php
    * ModificarVista.php
    * ResouestasForo.php

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
    * Musica.php

* Perfil
    * AjustePerfil.php
    * Perfil.php

* Tienda
    * Carrito.php
    * Entradas.php
    * Merch.php
    * ProductoVista.php

## Scripts adicionales

### Practica 2

* Clases
    * Usuario.php
    * Post.php
    * BD.php

* Helpers
    * LoginHelper.php
    * PostHelper.php
    * SignUpHelper.php
    * CabeceraSesion.php
    * PostHelper.php
    * CrearPostVista.php
    * ProcesarLogin.php
    * ProcesarRegistro.php
    * ProcesarLike.php
    * ProcesarModificacion.php
    * ProcesarEliminar.php

* Navegación
    * Config.php

* Base de datos
    * Estructura BD : 2melody.sql
    * Datos BD : 2melodyDatos.sql


### Practica 3

* Clases
    * Pedido.php
    * Producto.php
    
* Helpers
    * ModificarPerfilHelper.php
    * PostHelper.php
    * ProcesarProducto.php
    * ProcesarCompra.php
    * TiendaHelper.php
    * ProcesarSeguimiento.php


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

- **evento** (`id_evento`, `id_artista`, `nombre`, `descripcion`, `fecha`)
  - Esta tabla guarda información sobre los eventos organizados por los artistas, incluyendo el nombre, la descripción y la fecha del evento.

- **evento_prod** (`id_evento`, `id_prod`)
  - Relaciona los eventos con los productos relacionados con dichos eventos.

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