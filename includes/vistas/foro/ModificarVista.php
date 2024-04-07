<?php

require_once '../../Config.php';
require_once CLASSES_PATH . '/Post.php';

$post = Post::buscarPostPorID($_POST['ModificarID']);
$content = modificatePost($post->getTexto(), $post->getId());

require_once LAYOUT_PATH;