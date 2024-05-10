<?php
require_once '../../Config.php';
require_once CLASSES_URL . '/TopSearchBar.php';

function searchQuery($table, $filters, $data){

    $searchBar = SW\classes\TopSearchBar::getInstance();
    $datos = $searchBar->searchQuery($table, $filters, $data);


    return $datos;
}

function generateHTML($data, $option){
    
}