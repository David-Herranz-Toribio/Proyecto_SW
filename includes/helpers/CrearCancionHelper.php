<?php

function displayMessage($message){

    $html =<<<EOS
    <h2 class='text_infor'> $message </h2>
    EOS;

    return $html;
}