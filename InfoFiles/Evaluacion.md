# Feedback de la P3

## Funcionalidades implementadas

1. 
2. 
3.

## Calificación: 10 / 10

## Memoria (hasta 1,5 puntos) (1,5 / 1,5)

- [ ] Los listados de los scripts NO han sido actualizados respecto a los de la P2 (0 puntos)
- [ ] Los listados de los scripts han sido actualizados respecto a los de la P2 (0,5 puntos)

- [ ] El diagrama de base de datos NO ha sido actualizado respecto al de la P2 (0 puntos)
- [ ] El diagrama de base de datos ha sido actualizado respecto al de la P2 (0.5 puntos)

- [ ] La memoria incluye el parte de actividades detallado por cada integrante del grupo de prácticas (0.5 puntos)

Contenido:
- [ ] Listado de scripts para las vistas
- [ ] Listado de scripts adicionales
- [ ] Estructura de la base de datos
- [ ] Listado del juego de usuarios de pruebas.
- [ ] Parte de actividades.

### Comentarios sobre la memoria

#### Listado de scripts de vista

#### Listado de otros scripts

#### Estructura de la BD

## HTML (hasta 1 puntos) (1 / 1)

- [ ] Hay errores graves en el HTML (0 puntos)
- [ ] Hay bastantes errores en el HTML (0.5 puntos)
- [ ] Hay algunos errores en el HTML (0.75 puntos)
- [ ] Se hace un uso adecuado de las etiquetas (1 punto)

## CSS (hasta 1 puntos) (1 / 1)

- [ ] No se incluyen CSS o son las mismas que se proporcionan en los ejercicios 2 o 3. (0 puntos)
- [ ] Estilos mínimos o modificaciones mínimas sobre las CSS proporcionadas en el ejercicio 2 o 3 (0,25 puntos)
- [ ] Añaden nuevas reglas tanto para modificar el aspecto de elementos de las páginas como para organizar la aplicación (0,5 puntos)
- [ ] Se hace un uso intensivo de CSS, en particular se usan CSS Flexbox y/o CSS Grid para organizar las páginas (1 puntos)

## Prototipo del Proyecto (hasta 6 puntos) (6,5 / 6,5)

### Funcionalidades implementadas (hasta 4 puntos) (4 / 4)


#### Primera

Pruebas:
- [ ] Al probar la funcionalidad implementada no funciona o tiene bastantes errores (0 puntos)
- [ ] Al probar la funcionalidad implementada falla en algunos casos (1 punto)
- [ ] Al probar la funcionalidad implementada funciona correctamente (2 puntos)

Grado de madurez:
- [ ] La funcionalidad está completada por debajo del 25% (0 puntos)
- [ ] La funcionalidad está completada entre el 25%-50% (1 punto)
- [ ] La funcionalidad está completada entre el 50%-75% (2 puntos)
- [ ] La funcionalidad está completada entre el 75%-100% (3 puntos)

#### Segunda
...

### Calidad del código (hasta 2,5 puntos) (2,5 / 2,5)

- [ ] No existe una separación clara entre scripts de vista y scripts de lógica (0 puntos)
- [ ] Existe una separación clara entre scripts de vista y scripts de lógica (0,25 puntos)
- [ ] Existe una separación clara entre scripts de vista y scripts de lógica. Además la lógica en los scripts de vista es concentrada al comienzo del script y se utilizan funciones de apoyo para simplificar la generación y el mantenimiento del HTML de las páginas. (0,5 puntos)

- [ ] El código contiene bastantes errores comunes o de otro tipo (0 puntos)
- [ ] El código contiene algunos errores comunes o de otro tipo (0,25 puntos)
- [ ] El código no contiene errores apreciables  (0,5 puntos)

- [ ] Sigue la estructura del ejercicio 3 / estructura-proyecto o similar (0,5 puntos)

- [ ] La solución utiliza orientación a objetos al menos para las clases de entidad de la aplicación (0,5 puntos)

- [ ] Las clases de entidad se encargan de la gestión de acceso a la base de datos (o bien se aplica otro patrón más avanzado como el DAO) (0,5 puntos)

Algunos errores comunes encontrados:
- [ ] No se liberan recursos $rs->free() cuando se lanza una consulta SELECT.
- [ ] Las operaciones de base de datos no escapan ($conn->real_escape_string()) los parámetros del usuario.
- [ ] No se utiliza HTTP POST cuando la operación modifica el estado del servidor.
- [ ] Los datos que provienen del usuario no se validan adecuadamente.
- [ ] Las clases de entidad (e.g. Usuario, Mensaje, etc.) generan HTML. Las clases de entidad no deben de tener esa responsabilidad.
- [ ] Las operaciones de BD devuelven arrays cuyo contenido son directamente las filas que se obtienen de la base de datos y no instancias de la clase correspondiente.