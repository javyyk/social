<?php
//CONEXION BBDD
$link = mysqli_connect('127.0.0.1', 'root', '');
if (!$link)
	die("Error al conectar con el MySQL");

$mysqli_db = mysqli_select_db($link, "social");
if (!$mysqli_db)
	die("Error al seleccionar la base de datos");


//TODO: Debug
$tiempo_inicio = microtime(true);
//CONTADOR DE CONSULTAS
$q_querys = mysqli_query($link, "SHOW SESSION STATUS LIKE 'Questions'");
$r_querys = mysqli_fetch_array($q_querys);
define("START_QUERIES", $r_querys['Value']);

// Configuracion idioma de PHP para fechas
//setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

// Configuracion idioma de MySql para fechas
mysqli_query($link, "SET lc_time_names = 'es_ES'");

// $ruta se usa para meter ../ cuando la peticion procede de ficheros en subdirectorios
require($ruta."inc/functions.php");
?>