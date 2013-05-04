<?php
//CONEXION BBDD
$link = mysqli_connect('127.0.0.1', 'root', '');
if (!$link)
	die("Error al conectar con el MySQL");

$mysqli_db = mysqli_select_db($link, "social");
if (!$mysqli_db)
	die("Error al seleccionar la base de datos");

// $ruta se usa para meter ../ cuando la peticion procede de ficheros en subdirectorios
require($ruta."inc/functions.php");
?>