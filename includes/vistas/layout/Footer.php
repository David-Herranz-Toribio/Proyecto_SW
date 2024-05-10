<?php

    require_once '../../Config.php';
    require_once CLASSES_URL . '/Cancion.php';

    $canciones = null; 
    $idPlaylist = $_POST['idPlaylist'] ?? ''; 
    if(!is_null($idPlaylist)){
        $canciones = SW\classes\Cancion::getSongsFromPlaylistID($idPlaylist);  
    }
?>    

<footer class="footer">
    <audio src="" controls id="player"></audio>

    <ul id="playlist">
        <?php

            $i = 0; 
            if(!is_null($canciones)){
                foreach($canciones as $cancion_act){
                    $rutaAudio= AUDIO_URL . '/' . $cancion_act->getCancionRuta(); 
                    echo "<li id= 'cancion$i> <a href= 'https://upload.wikimedia.org/wikipedia/commons/9/9b/Queryen_-_DEMO_-_002_%281995%29_-_011_-_Flying_To_Tunis_%2830sec%29.ogg'> Pista12 </a></li> " ; 
                    $i++; 
                }
     
            }
        ?>
        <li id= 'cancion1'><a href="https://upload.wikimedia.org/wikipedia/commons/9/9b/Queryen_-_DEMO_-_002_%281995%29_-_011_-_Flying_To_Tunis_%2830sec%29.ogg">Pista 1</a></li>
        <li id= 'cancion2'><a href="https://upload.wikimedia.org/wikipedia/en/7/79/Micromoog_Demo.ogg">Pista 2</a></li>
        <li id= 'cancion3'><a href="https://ccrma.stanford.edu/~jos/mp3/gtr-nylon22.mp3">Pista 3</a></li>
    </ul>
    <button class="player-button" id="prev"><img src="<?=IMG_PATH?>/PlayerImages/Prev_Button.png" height="30" width="30"></button>
    <button class="player-button" id="rewind"><img src="<?=IMG_PATH?>/PlayerImages/Rewind_Button.png" height="30" width="30"></button>
    <button class="player-button" id="forward"><img src="<?=IMG_PATH?>/PlayerImages/Forward_Button.png" height="30" width="30"></button>
    <button class="player-button" id="next"><img src="<?=IMG_PATH?>/PlayerImages/Next_Button.png" height="30" width="30"></button>
    <script>
        playerLogic();    
    </script>
</footer>