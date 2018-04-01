<?php

require_once("config.php");

// select one
/*$root = new Usuario();
$root->selectById(4);
echo $root;*/

// select all
//echo json_encode(Usuario::selectAll());

// select as many as the login are similar
//echo json_encode(Usuario::selectByLogin("a"));

// try to login Usuario
//$usuario = new Usuario();
//$usuario->login("pedro", "ambndisdk");
//echo $usuario;

// insert usuario
//$aluno = new Usuario("aluno", "sa$%g4g");
//$aluno->insert();
//echo $aluno;

// update usuario
$usuario = new Usuario();
$usuario->selectById(8);
$usuario->update("Thiallisson","dskfs934fm34343c343");
echo $usuario;

?>