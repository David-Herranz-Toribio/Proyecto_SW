<?php

function generateUserImage(){
    
    $iconImage = RUTA_IMG_PATH . '/RegisterUserImage.png';
    $image =<<<EOS
        <img src="$iconImage" alt="foto de perfil" height="200" width="200">
    EOS;

    return $image;
}

function generateArtistAccountLink(){

    $enlace = RUTA_VISTAS_PATH . '/log/SignUpArtist.php';
    return "<p> Eres un artista? <a href=$enlace> Crea tu cuenta aquí </a></p>";
}

function generateFormularyUser($errores){

    $username_error = '';
    if( isset($errores['username']) ){
        $username_error = $errores['username'];
    }

    $email_error = '';
    if( isset($errores['email']) ){
        $email_error = $errores['email'];
    }

    $birthdate_error = '';
    if( isset($errores['birthdate']) ){
        $birthdate_error = $errores['birthdate'];
    }

    $enlace = RUTA_HELPERS_PATH . '/ProcesarRegistro.php';
    $form =<<<EOS
    <fieldset class="formRegistro">
    <legend> Registra tu nueva cuenta de usuario </legend> 
        <form action=$enlace method="post">
        
            <input hidden name="isArtist" value="0"> 
            <label> Nickname </label>
            <p></p> 
            <input required type="text" name= "new_nickname">

            <p></p>

            <label> Username (Ej: paco03) </label>
            <p></p> 
            <input required type="text" name="new_username">
            <p> $username_error </p>

            <p></p> 
                
            <label> Email </label>
            <p></p> 
            <input required type="text" name="new_email">
            <p> $email_error </p>

            <p></p> 

            <label> Password </label>
            <p></p> 
            <input required type="password" name="new_password">
                
            <p></p> 
                
            <label> Birthdate </label>
            <p></p> 
            <input required type="date" name="new_birthdate">
            <p> $birthdate_error </p>

            <p></p>

            <button type="submit" name="register_button" > Sign In </button>
        </form>
    </fieldset>
    EOS;

    return $form;
}

function generateFormularyArtist($errores){

    $username_error = '';
    if( isset($errores['username']) ){
        $username_error = $errores['username'];
    }

    $email_error = '';
    if( isset($errores['email']) ){
        $email_error = $errores['email'];
    }

    $birthdate_error = '';
    if( isset($errores['birthdate']) ){
        $birthdate_error = $errores['birthdate'];
    }

    $enlace = RUTA_HELPERS_PATH . '/ProcesarRegistro.php';
    $form =<<<EOS
    <fieldset class= "formRegistro">
        <legend> Registra tu nueva cuenta de artista </legend> 
        <form action= $enlace method="post">
        
            <input hidden name="isArtist" value="1"> 
            <label> Nickname </label>
            <p></p> 
            <input required type="text" name= "new_nickname">
            
            <p></p> 

            <label> Username (Ej: paco03) </label>
            <p></p> 
            <input required type="text" name="new_username">
            <p> $username_error </p>

            <p></p> 
                
            <label> Email </label>
            <p></p> 
            <input required type="text" name="new_email">
            <p> $email_error </p>

            <p></p> 

            <label> Password </label>
            <p></p> 
            <input required type="password" name="new_password">
                
            <p></p> 
                
            <label> Birthdate </label>
            <p></p> 
            <input required type="date" name="new_birthdate">
            <p> $birthdate_error </p>

            <p></p> 

            <label> Musical genre: </label><br>
            <select name="musical_genres" size = "6">
                <option> ----</option>
                <option value="Pop"> Pop </option>
                <option value="Rock"> Rock </option>
                <option value="Rap"> Rap </option>
                <option value="Hip Hop"> Hip Hop </option>
                <option value="Latino"> Latino </option>
                <option value="Jazz"> Jazz </option>
                <option value="R&B"> R&B </option>
                <option value="K-Pop"> K-Pop </option>
                <option value="J-Pop"> J-Pop </option>
                <option value="Dubstep"> Dubstep </option>
                <option value="Clásica"> Clásica </option>
                <option value="Disco"> Disco </option>
                <option value="Funk"> Funk </option>
                <option value="Jazz"> Jazz </option>
                <option value="Reggae"> Reggae </option>
                <option value="Metal"> Metal </option>
            </select>

            <p></p>

            <button type="submit" name="register_button" > Sign In </button>
        </form>
    </fieldset>
    EOS;

    return $form; 
}

function generateErrorMessages(){

    if(isset($_SESSION['error'])){
        return $_SESSION['error'];
    }

    return '';
}