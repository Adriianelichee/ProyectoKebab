<?php
require_once 'MIautocargador.php';
require_once 'vendor/autoload.php';

$conexion = Conexion::getConection();
// $controller = new HomeController();
// $controller->index();

$ingrediente = new Ingredient("Sal","0.50");
$RepoIng = new RepoIng($conexion);

$RepoIng->create($ingrediente);