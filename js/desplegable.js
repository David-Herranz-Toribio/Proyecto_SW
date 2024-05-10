$(function() {
    
    $(".desplegable_canciones").click(function() {
        var albumHeader = $(this).parent().parent();
        var listaCanciones = albumHeader.siblings(":first");
        listaCanciones.slideToggle("slow");
    });

});