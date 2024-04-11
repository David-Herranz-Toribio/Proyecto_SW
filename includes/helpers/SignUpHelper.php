<?php

function generateUserImage(){
    
    $iconImage = IMG_PATH . '/RegisterUserImage.png';
    $image =<<<EOS
        <img src="$iconImage" alt="foto de perfil" height="200" width="200">
    EOS;

    return $image;
}

function generateArtistAccountLink(){

    $enlace = VIEWS_PATH . '/log/SignUpArtist.php';
    return "<p> Eres un artista? <a href=$enlace> Crea tu cuenta aquí </a></p>";
}

function generateFormularyUser($errores){

    $username_usado_error = '';
    if( isset($errores['username_usado']) ){
        $username_usado_error = $errores['username_usado'];
    }

    $email_invalido_error = '';
    if( isset($errores['email_invalido']) ){
        $email_invalido_error = $errores['email_invalido'];
    }

    $email_usado_error = '';
    if( isset($errores['email_en_uso']) ){
        $email_usado_error = $errores['email_en_uso'];
    }

    $short_password_error = '';
    if( isset($errores['short_password']) ){
        $short_password_error = $errores['short_password'];
    }

    $fecha_anterior_error = '';
    if( isset($errores['fecha_anterior']) ){
        $fecha_anterior_error = $errores['fecha_anterior'];
    }

    $fecha_mayor_edad_error = '';
    if( isset($errores['fecha_mayor_edad']) ){
        $fecha_mayor_edad_error = $errores['fecha_mayor_edad'];
    }

    $enlace = HELPERS_PATH . '/ProcesarRegistro.php';
    $form =<<<EOS
    <fieldset class="formRegistro">
    <legend> Registra tu nueva cuenta de usuario </legend> 
        <form action=$enlace method="post">
        
            <input hidden name="isArtist" value="0"> 
            <label> Nickname </label>
            <p></p> 
            <input required type="text" name= "new_nickname">

            <p></p>
            <label> Foto de perfil </label> 
            <input type = "file" name = "image" accept = "image/*">
            <label> Username (Ej: paco03) </label>
            <p></p> 
            <input required type="text" name="new_username">
            <p> $username_usado_error </p>

            <label> Email </label>
            <p></p> 
            <input required type="text" name="new_email">
            <p> $email_invalido_error <br> $email_usado_error</p>

            <label> Password </label>
            <p></p>
            <input required type="password" name="new_password">
            <p> $short_password_error </p>

            <label> Birthdate </label>
            <p></p>
            <input required type="date" name="new_birthdate">
            <p> $fecha_anterior_error <br> $fecha_mayor_edad_error </p>

            <button type="submit" name="register_button" > Sign In </button>
        </form>
    </fieldset>
    EOS;

    return $form;
}

function generateFormularyArtist($errores){

    $username_usado_error = '';
    if( isset($errores['username_usado']) ){
        $username_usado_error = $errores['username_usado'];
    }

    $email_invalido_error = '';
    if( isset($errores['email_invalido']) ){
        $email_invalido_error = $errores['email_invalido'];
    }

    $email_usado_error = '';
    if( isset($errores['email_en_uso']) ){
        $email_usado_error = $errores['email_en_uso'];
    }

    $short_password_error = '';
    if( isset($errores['short_password']) ){
        $short_password_error = $errores['short_password'];
    }

    $fecha_anterior_error = '';
    if( isset($errores['fecha_anterior']) ){
        $fecha_anterior_error = $errores['fecha_anterior'];
    }

    $fecha_mayor_edad_error = '';
    if( isset($errores['fecha_mayor_edad']) ){
        $fecha_mayor_edad_error = $errores['fecha_mayor_edad'];
    }

    $enlace = HELPERS_PATH . '/ProcesarRegistro.php';
    $form =<<<EOS
    <fieldset class= "formRegistro">
        <legend> Registra tu nueva cuenta de artista </legend> 
        <form action= $enlace method="post">
        
            <input hidden name="isArtist" value="1"> 
            <label> Nickname </label>
            <p></p> 
            <input required type="text" name= "new_nickname">
            
            <p></p> 
            <label> Foto de perfil </label> 
            <input type = "file" name = "image" accept = "image/*">

            <label> Username (Ej: paco03) </label>
            <p></p> 
            <input required type="text" name="new_username">
            <p> $username_usado_error </p>
                
            <label> Email </label>
            <p></p> 
            <input required type="text" name="new_email">
            <p> $email_invalido_error <br> $email_usado_error</p>

            <label> Password </label>
            <p></p> 
            <input required type="password" name="new_password">
            <p> $short_password_error </p>
                
            <label> Birthdate </label>
            <p></p> 
            <input required type="date" name="new_birthdate">
            <p> $fecha_anterior_error <br> $fecha_mayor_edad_error </p>

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