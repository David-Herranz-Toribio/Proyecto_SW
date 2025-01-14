$(document).ready(function(){

    var songList = [];
    var currentSong = 0;
    var countdown_publi = 3;
    var isPremium = 0;
    var isPlaying = false; // Variable para verificar si la canción está reproduciéndose
    var audioPubli = "<li id= 'cancionPubli'> <a href= '../../../audio/audio_publicidad.mp3'> Publicidad </a> </li>"; 
    

    user_premium(function(result, error) {
        if (error) {
            console.error("Error:", error);
        } else {
            isPremium = result; 
        }
    });
    logicaPlaylist(); 

    //Determina si el usuario es premium 
    function user_premium(callback){
        $.get("../../helpers/comprobarPremium.php" , function(data,status){
            switch(data.trim()){
                case 'si': 
                    callback(1);
                    break;

                case 'no': 
                    callback(0); 
                    break; 
            }
        }); 
    }

    //Pone en el footer la playlist que queremos escuchar
    function changePlaylist(canciones){
        $('#playlist').empty(); 
        for(let i = 0; i< canciones.length; i++){
            var elemento = canciones[i];
            $('#playlist').append("<li id= 'cancion" + i + "'> <a href=" + elemento[0] + ">" + elemento[1] + "</a> </li>"); 
        }
        logicaPlaylist();
    }

    function logicaPlaylist(){

        $("#playlist li:eq("+currentSong+")").addClass("current-song");
        var archivo = $("#playlist li a")[currentSong];
        $("#player")[0].src = archivo;
        $("#player")[0].play();
        isPlaying = true;
        showNameSong(); 
    }

    $("#player")[0].addEventListener("ended", nextSong);

    $("#prev").click(function(){

        if(countdown_publi> 0 || isPremium){
            currentSong--;
            if(currentSong < 0){
                currentSong = $("#playlist li a").length - 1;
            }
            changeSong();
        }
    });

    $("#next").click(function(){
        if(countdown_publi > 0 || isPremium){ //No puedes cambiar de cancion hasta que se termine el anuncio 
            nextSong();
        }
    });

    $("#rewind").click(function(){
        if(countdown_publi>0 || isPremium){
            $("#player")[0].currentTime -= 10;
        }
        
    });

    $("#forward").click(function(){
        if(countdown_publi>0 ||isPremium){
            $("#player")[0].currentTime += 10;
        }
       
    });

    // Al detectar el evento de pausa, establecer que la canción no está reproduciéndose
    $("#player")[0].addEventListener("pause", function() {
        isPlaying = false;
        $("#playlist .current-song a").css("animation", "none"); // Quitar la animación cuando la canción se pausa
    });

    /* Al hacer click en una cancion en el perfil de un artista */ 
    $('body').on('click', '#playSong', function(){

        if(countdown_publi > 0 ||isPremium){
            var rutaCancion = "../../../audio/";
            rutaCancion += $(this).siblings("span")[0].innerText; 
            nombreCancion = $(this).parent().siblings("div")[0].firstElementChild.innerText;  
            rutaCancion = rutaCancion.replace(/ /g, "");
            let cancion = [rutaCancion, nombreCancion]; 
            let canciones = [cancion]; 
            changePlaylist(canciones);
            countdown_publi = 3;
        }
    }); 

    /* Al hacer click en reproducir playlist/album */ 
    $('body').on('click', '#startPlaylist', function(){
        if(countdown_publi> 0 || isPremium){
            var idPlaylist= $(this).siblings("span")[0].innerText.trim(); 
            $.get("../../helpers/obtenerCanciones.php?idPlaylist=" + idPlaylist, changePlaylist);

        }
    }); 

    function nextSong(){
        if(countdown_publi === 0 && !isPremium){
            countdown_publi = 3; 
            $("#playlist li#cancionPubli").remove(); 
        }
        else  currentSong++;

        if(currentSong == $("#playlist li a").length){
            currentSong = 0;
        }
        changeSong();
    }

    function changeSong(){
        countdown_publi--;

        if(countdown_publi==0 && !isPremium){ //Entra la publi 
            $("#playlist li.current-song").after(audioPubli); 
            if(currentSong==0){ //Si la playlist vuelve al principio, se tiene que reproducir el audio que iba despues del que se estaba reproduciendo
                currentSong= $("#playlist li a").length-1; 
            }
        }

        $("#playlist li").removeClass("current-song");
        $("#playlist li:eq("+currentSong+")").addClass("current-song");
        showNameSong(); 
        logicaPlaylist();
        
        if (isPlaying) {
            $("#playlist .current-song a").css("animation", "blinkColor 4s infinite");
        }
    }

    /* Esconder todas las canciones menos la actual */ 
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
