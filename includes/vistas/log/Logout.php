<?php

require_once '../../Config.php';

unset($_SESSION['username']);
unset($_SESSION['login']);
unset($_SESSION['isArtist']);

session_destroy();
session_start();
header('Location:' . VIEWS_PATH . '/foro/Foro.php'); 