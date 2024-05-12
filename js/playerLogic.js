$(document).ready(function(){
    var currentSong = 0;
    var countdown_publi= 3; 

    var isPlaying = false; // Variable para verificar si la canción está reproduciéndose
    var audioPubli= "<li id= 'cancionPubli'> <a href= '../../../audio/audio_publicidad.mp3'> Publicidad </a> </li>"; 

    var isPremium= user_premium(); 

    logicaPlaylist(); 


    //Determina si el usuario es premium 
    function user_premium(){
        $.get("../../helpers/comprobarPremium.php" , function(data,status){
            switch(data.trim()){
                case 'si': 
                    return true;

                case 'no': 
                    return false; 
            }
        }); 
    }


    //Pone en el footer la playlist que queremos escuchar
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
        isPlaying = true; // Establecer que la canción está reproduciéndose
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
        if(countdown_publi>=0 || isPremium){ //No puedes cambiar de cancion hasta que se termine el anuncio 
            nextSong();
        }
    });

    $("#rewind").click(function(){
        if(countdown_publi>=0 || isPremium){
            $("#player")[0].currentTime -= 10;
        }
        
    });

    $("#forward").click(function(){
        if(countdown_publi>=0 ||isPremium){
            $("#player")[0].currentTime += 10;
        }
       
    });

    // Al detectar el evento de pausa, establecer que la canción no está reproduciéndose
    $("#player")[0].addEventListener("pause", function() {
        isPlaying = false;
        $("#playlist .current-song a").css("animation", "none"); // Quitar la animación cuando la canción se pausa
    });

    /*Al hacer click en una cancion en el perfil de un artista*/ 
    $('body').on('click', '#playSong' , function(){
        
        if(countdown_publi>= 0){
            var rutaCancion = "../../../audio/";
            rutaCancion+= $(this).siblings("span")[0].innerText; 
            nombreCancion= $(this).parent().siblings("div")[0].lastElementChild.innerText;  
            rutaCancion= rutaCancion.replace(/ /g, "");
            let cancion= [rutaCancion, nombreCancion]; 
            let canciones= [cancion]; 
            changePlaylist(canciones); 
        }
    
    }); 

    /*Al hacer click en reproducir playlist/album*/ 
    $('body').on('click', '#startPlaylist', function(){
        if(currentSong>= 0){
            var idPlaylist= $(this).siblings("span")[0].innerText.trim(); 
            $.get("../../helpers/obtenerCanciones.php?idPlaylist=" + idPlaylist, changePlaylist); 
        }
    }); 

    function nextSong(){
        if(countdown_publi===0 && !user_premium){
            countdown_publi= 3; 
            $("#playlist li#cancionPubli").remove(); 
        }
        else currentSong++;

        if(currentSong == $("#playlist li a").length){
            currentSong = 0;
        }
        changeSong();
    }

    function changeSong(){
        countdown_publi--;

        if(countdown_publi==0 && !user_premium){
            $("#playlist li.current-song").after(audioPubli); 
        }

        
        $("#playlist li").removeClass("current-song");
        $("#playlist li:eq("+currentSong+")").addClass("current-song");
        showNameSong(); 
        logicaPlaylist();
        
        if (isPlaying) {
            $("#playlist .current-song a").css("animation", "blinkColor 4s infinite");
        }
        
        
    }

    /*Esconder todas las canciones menos la actual*/ 
    function showNameSong(){ 
        $("#playlist li ").each(function (index) {
            if($(this).hasClass("current-song")){
                $(this).show(); 
            } else {
                $(this).hide();
            }
        }); 
    }

});
