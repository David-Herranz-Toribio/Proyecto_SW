<?php
    require_once "../Config.php"; 

    if(isset($_SESSION['isSub']) && !is_null($_SESSION['isSub'])){
        echo ("si"); 
    }
    else echo("no"); 

?> 