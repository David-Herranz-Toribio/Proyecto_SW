# Memoria Práctica 3

## Funcionalidades implementadas

### Practica 2

* Foro:
  * Se puede publicar solo si estas logeado.
  * Modificar y eliminar tus post 
  * Responder y dar me gusta a post
  * Funcionalidad de karma (que sirve como 'moneda' en la tienda) acumulable al participar en el foro 

* Perfil: Podemos registrarnos e iniciar sesion.

* Menu de navegacion en la parte izquierda 


### Practica 3

* Perfil: 
  * Hay una pagina unica por cada usuario registrado, en ella se encuentran:
  * Datos personales como su nickname, username, descripcion etc... 
  * Menu dentro del perfil donde se podran ver
    * Sus post publicados 
    * Los post a los que ha dado me gusta 
    * Si es artista, podemos ver sus productos de la tienda.
    * Si es tu perfil, puedes ver el historial de pedidos que ya has realizado. 
    * Si es tu perfil, hay un boton que te lleva a una pagina de ajustes donde podras modificar tu perfil 
    * Si es artista, puedes ver la musica que ha publicado (Todavia sin hacer).
  * Puedes seguir a gente y que otra gente te siga. 


* Tienda:
  * Se puede comprar productos
  * Añadir productos, modificarlos o eliminarlos si estas registrado como artista 
  * Funcionalidad de carrito donde se van añadiendo los productos que compras en la tienda
  * Si no tienes corcheas (otro nombre para el karma) no puedes comprar los productos que has añadido
  * Aunque puedes ir eliminando productos del carro para reducir ese precio 


* Barra de busqueda en el foro donde puedes buscar un usuario especifico para el que quieras ver sus post  
* En la tienda esta la misma barra, solo que se usa para buscar determinados productos (Ej: camiseta, poster etc...)


## Funcionalidad en proceso

* Ajustes: Cambiar la apariencia de la pagina
  * Tema claro/oscuro
  * Tipo de fuente
  * Ventana principal favorita
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
    * Perfil:
       * LoginHelper.php
       * SignUpHelper.php
       * ProcesarLogin.php
       * ProcesarRegistro.php

    * Foro: 
      * PostHelper.php
      * PostHelper.php
      * CrearPostVista.php
      * ProcesarLike.php
      * ProcesarModificacion.php
      * ProcesarEliminar.php
    
    * Cabecera:
      * CabeceraSesion.php

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
    * Perfil:
      * ModificarPerfilHelper.php
      * ProcesarSeguimiento.php
      * ProcesarEliminarUsuario.php

    * Foro: 
      * PostHelper.php

    * Tienda  
      * ElimCarrito.php
      * ProcesarProducto.php
      * ProcesarCompra.php
      * TiendaHelper.php
      * ProcesarTienda.php
      * ProcesarElimProd.php

    * Música
      *MusicaHelper (Prototipo, no tiene implementación)


## Usuarios en la base de datos
* usuario: user1 
    * contraseña: adminpass

* usuario: user2 
    * contraseña: adminpass

* usuario: user3 
    * contraseña: adminpass

* usuario: user4 
    * contraseña: adminpass

* usuario: user5 
    * contraseña: adminpass

* usuario: user6 
    * contraseña: adminpass


## Estructura de la base de datos

### Practica 2

* **usuario** (`id_user`, `username`, `nickname`, `password`, `foto`, `descripcion`, `karma`, `num_seguidores`, `num_seguidos`)
  * Esta es la tabla con la información general de todos los usuarios y los datos necesarios para que puedan interactuar con la aplicación. Contiene detalles como el nombre de usuario, contraseña, imagen de perfil, etc.

* **ajustes** (`fuente`, `fontSize`, `temas`, `paginaPrincipal`, `id_user`)
  * Esta tabla almacena las preferencias de ajustes de cada usuario, como la fuente, el tamaño de fuente, el tema preferido, etc., para personalizar su experiencia de uso.

* **artista** (`id_artista`, `integrantes`)
  * Tabla asociada a los usuarios que son artistas, contiene información específica sobre los artistas, como los miembros del grupo musical en el caso de bandas.

* **post** (`id_post`, `id_user`, `texto`, `imagen`, `likes`, `origen`, `tags`, `fecha`)
  * Tabla que almacena los posts realizados por los usuarios, incluyendo texto, imágenes, etiquetas, etc.

* **postfav** (`id_post`, `id_user`)
  * Relación entre los posts y los usuarios que los han marcado como favoritos.


### Practica 3

* **seguidores** (`id_user`, `id_seguidor`)
  * Tabla de seguimiento que relaciona los usuarios con los demás usuarios que siguen.

* **pedido** (`id_pedido`, `id_user`, `estado`, `total`, `fecha`)
  * Almacena información sobre los pedidos realizados por los usuarios, incluyendo su estado y total.

* **producto** (`id_prod`, `id_artista`, `imagen`, `nombre`, `descripcion`, `stock`, `precio`)
  * Contiene detalles sobre los productos disponibles en la tienda, como nombre, descripción, stock y precio.

* **pedido_prod** (`id_pedido`, `id_prod`, `cantidad`)
  * Relación entre los pedidos y los productos que contienen, junto con la cantidad de cada producto en el pedido.


## Parte de actividades por Participante

* David
  * EMPEZAR A CORREGIR FORMULARIOS SIN VALIDACION
  * Imagenes subidas por el usuario
  * Crear una pagina de artista y cuando pinches en uno te lleve a una pagina que tenga apartados para ver sus producto eventos y posts
  * Pagina de un producto individual

* Óscar
  * Añadir campo de descripción en perfil de usuario
  * Pestaña para ver tus post favoritos
  * Pestaña para ver tus posts
  * Informacion perfil => (Nickname, descripcion, cumpleaños, nºseguidores, nºseguidos, karma)
  * Mejorar la lógica de la vistas PerfilHelper.php
  * Actualización de la memoria
  * Actualizar dicha memoria con datos pedidos por el profe en la evaluación
  * Mensajes de error en login
  * Mensajes de error en sign up
  * Comprobar que no se creen cuentas con emails repetidos
  * Reorganización de carpetas
  * Añadir funciones para buscar en la base de datos un usuario con un cierto username, nickname, email y birthdate
  * Utilizar arrays en lugar de múlitples parámetros en los constructores
  * Botones de vistas en perfil
  * Implementación de namespaces
  * Actualizar pull requests del profesor sobre la práctica 2

* Hugo
  * Cascade y tabla productos y asociados
  * Actualizar Diagramas de base de datos para que coincidan y mejorarlos
  * Crear una pagina de artista y cuando pinches en uno te lleve a una pagina que tenga apartados para ver sus productos eventos y posts
  * Pagina de un producto individual

* Ignacio
  * Mejora del css con uso de grid
  * Añadir foto de perfil para modificarla
  * Incluir en Ajustes un boton de eliminar cuenta
  * Implementacion de barra de búsqueda
  * Implementacion de fotos de perfil visibles de usuario
  * Cabecera de la página 
  * incluir 
  * Cabecera de la página
  * Cabecera de la página
  * Cabecera de la página


* Alonso
  * Mejora del css con uso de grid
  * Implementar CSS para la vista de las respuestas
  * Modificar datos del perfil
  * Poder seguir a gente y que te sigan
  * Historial de pedidos
  * Si es artista mostrar sus productos
  * Informacion perfil => (Nickname, descripcion, cumpleaños, nºseguidores, nºseguidos, karma)
  * Botón de publicación en el foro
  * Diferenciar entre perfil propio y de otro usuario
  * Rrorganizar código para evitar sobreuso de divs
  * Implementación nueva del css

* Resto de tareas:
  * Respuestas, eliminaciones y modificaciones en cada mensaje
  * Likes
  * Posts
  * Respuestas
  * Edicion y modificacion de posts
  * Usar etiquetas en lugar de clases
  * ScrollBar en el desplegable de géneros musicales
  * Respuestas desplegables
  * Respuestas, eliminaciones y modificaciones en cada mensaje
  * Añadir campo de descripción en perfil de usuario
  * El sidebar que ocupe toda la columna
  * Mantener la posición del sidebar independientemente del lugar
  * Quitar las opciones y cuando pases el cursor por los módulos te carguen las opciones
  * Tamaños mínimos para los elementos
  * La sidebar debe contraerse y expandirse sin cambiar el fondo