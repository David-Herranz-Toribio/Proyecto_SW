# Memoria Práctica 3

## Funcionalidades implementadas

* Funcionalidad de entrega
    * Perfil
    * Tienda

* Funcionalidad extra
    * Primera
    * Segunda
    * Tercera

## Scripts de vistas

- 

## Scripts adicionales

- Pedido.php
- Producto.php
- ModificarPerfilHelper.php
- PostHelper.php
- ProdesarProducto.php
- TiendaHelper.php


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