function playerLogic () {
    var currentSong = 0;
    var playing = true;
    $("#player")[0].src = $("#playlist li a")[0].href;
    $("#player")[0].pause();
    $("#playlist li:eq("+currentSong+")").addClass("current-song");
    showNameSong(); 


    $("#playlist li a").click(function(e){
        e.preventDefault(); 
        $("#player")[0].src = this;
        $("#player")[0].pause();
        $("#playlist li").removeClass("current-song");
        currentSong = $(this).parent().index();
        $(this).parent().addClass("current-song");
    });

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

        /*Para las playlist, enviar una peticion post al Footer que contiene el id de dicha playlist*/ 
    }); 


    /*Al hacer click en reproducir playlist/album*/ 
    $('body').on('click', '#startPlaylist', function(){
        var idPlayList= $(this).siblings("span")[0].innerText; 
        $.post('../layout/Footer.php', {'idPlaylist': idPlayList.trim()}, function(data, status){

        }); 
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
        $("#player")[0].src = $("#playlist li a")[currentSong].href;
        showNameSong(); 
        $("#player")[0].play();
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

}
