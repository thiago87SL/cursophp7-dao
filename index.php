<?php

require_once("config.php");

// select one
/*$root = new Usuario();
$root->selectById(4);
echo $root;*/

// select all
//echo json_encode(Usuario::selectAll());

// select as many as the login are similar
echo json_encode(Usuario::selectByLogin("a"));



?>