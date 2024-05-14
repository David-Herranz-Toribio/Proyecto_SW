$(document).ready(function() {
    $("#logoutButton").click(function(){
        if (link.endsWith('/log/Logout.php')) {
            var ok = window.confirm("¿Quieres cerrar sesión?");
            if (ok)
                location.assign(link);
        }
        else
            location.assign(link);
    }); 

    $("#DeleteUserButton").click(function(){
        var ok = window.confirm("¿Quieres eliminar tu cuenta?");
        if (ok)
            location.assign(linkEliminar);
    }); 
});
