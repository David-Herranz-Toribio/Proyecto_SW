$(document).ready(function() {
    $("#logoutButton").click(function(){
        var ok = window.confirm("¿Quieres cerrar sesión?");
        if (ok)
            location.assign("<?php echo $link; ?>");
    }); 

    $("#DeleteUserButton").click(function(){
        var ok = window.confirm("¿Quieres eliminar tu cuenta?");
        if (ok)
            location.assign("<?php echo $link; ?>");
    }); 
});
