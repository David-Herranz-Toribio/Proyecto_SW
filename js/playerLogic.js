$(document).ready(function(){
    var currentSong = 0;
    logicaPlaylist(); 

    
    function changePlaylist(canciones){
        $('#playlist').empty(); 
        for(let i= 0; i< canciones.length; i++){
            var elemento = canciones[i];
            $('#playlist').append("<li id= 'cancion" + i + "'> <a href=" + elemento[0] + ">" + elemento[1] + "</a> </li>"); 
        }
        logicaPlaylist();
    }


    function logicaPlaylist(){
     
        var playing = true;
        $("#playlist li:eq("+currentSong+")").addClass("current-song");
        $("#player")[0].src = $("#playlist li a")[currentSong].href;
        $("#player")[0].play();
        showNameSong(); 
    }

    $("#player")[0].addEventListener("ended", nextSong);

    $("#prev").click(function(){
        currentSong--;
        if(currentSong < 0){
            currentSong = $("#playlist li a").length - 1;
        }
        changeSong();
    });

    $("#next").click(function(){
        nextSong();
    });

    $("#rewind").click(function(){
        $("#player")[0].currentTime -= 10;
    });

    $("#forward").click(function(){
        $("#player")[0].currentTime += 10;
    });


    /*Al hacer click en una cancion en el perfil de un artista*/ 
    $('body').on('click', '#playSong' , function(){
        var rutaCancion = "/Proyecto_SW/audio/";
        rutaCancion+= $(this).siblings("span")[0].innerText; 
        rutaCancion= rutaCancion.replace(/ /g, "");
        $("#player")[0].src=  rutaCancion; 
        $("#player")[0].play();
    }); 


    /*Al hacer click en reproducir playlist/album*/ 
    $('body').on('click', '#startPlaylist', function(){
        var idPlaylist= $(this).siblings("span")[0].innerText; 
        $.get("../../helpers/obtenerCanciones.php?idPlaylist=" + idPlaylist, changePlaylist); 
    }); 


    function nextSong(){
        currentSong++;
        if(currentSong == $("#playlist li a").length){
            currentSong = 0;
        }
        changeSong();
    }

    function changeSong(){
        $("#playlist li").removeClass("current-song");
        $("#playlist li:eq("+currentSong+")").addClass("current-song");
        
        showNameSong(); 
       
        logicaPlaylist();
    }


    /*Esconder todas las canciones menos la actual*/ 
   function showNameSong(){ 
    $("#playlist li ").each(function (index) {
        if($(this).hasClass("current-song")){
            $(this).show(); 
        }
        else $(this).hide();
        }); 
    }

}); 
