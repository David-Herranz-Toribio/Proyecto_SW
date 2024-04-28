<?php

require_once '../../Config.php';
require_once CLASSES_URL . '/Post.php';

$post = SW\classes\Post::buscarPostPorID($_POST['ModificarID']);
$content = modificatePost($post->getTexto(), $post->getId());

require_once LAYOUT_URL;