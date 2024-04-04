# Memoria Práctica 3

## Funcionalidades implementadas

* Perfil
* Tienda


## Funcionalidad en proceso
* Primera
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
    * TiendaHelper.php


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

- evento(id_evento, id_artista, nombre, descripcion, fecha)

- evento_prod (id_evento, id_prod)

- post (id_post, id_user, texto, imagen, likes, origen, tags, fecha)

- postfav (id_post, id_user)

- seguidores (id_user, id_seguidor)

- pedido (id_pedido, id_user, estado, total, fecha)

- producto (id_prod, id_artista, imagen, nombre, descripcion, stock, precio)

- pedido_prod (id_pedido, id_prod, cantidad)