function toggleStyle(nuevo) {
    console.log("Cambiando la pagina de estilo"); 
    document.getElementById('estilo').setAttribute('href', nuevo); 

    /*Aqui nos conectariamos al servidor de alguna forma para que se quede fijo el estilo cambiado
    al recargar la pagina*/ 
}