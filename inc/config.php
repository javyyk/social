<?php
//CONSTANTES DE CONFIGURACION GLOBALES

//Titulo corto del sitio
define("Sitio", "Social");

//Titulo largo del sitio
define("Sitio_Largo", "Social Networks");

//Direccion de la web
define("Sitio_direccion", "127.0.0.1/social");

//IP del servidor MySQL
define("MySQL_IP", "127.0.0.1");

//Usuario del servidor MySQL
define("MySQL_USER", "root");

//Contraseña del servidor MySQL
define("MySQL_PASS", "");

//Base de datos del servidor MySQL
define("MySQL_BD", "social");

//Email que se usara como emisor de los correos
define("Email_Address", "javi.and.friends@gmail.com");



//CONEXION BBDD
$link = mysqli_connect(MySQL_IP, MySQL_USER, MySQL_PASS);
if (!$link)
	die("Error al conectar con el MySQL");

$mysqli_db = mysqli_select_db($link, MySQL_BD);
if (!$mysqli_db)
	die("Error al seleccionar la base de datos");


//TODO: Debug
$tiempo_inicio = microtime(true);
//CONTADOR DE CONSULTAS
$q_querys = mysqli_query($link, "SHOW SESSION STATUS LIKE 'Questions'");
$r_querys = mysqli_fetch_array($q_querys);
define("START_QUERIES", $r_querys['Value']);

// Configuracion idioma de PHP para fechas (usar con strftime)
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

// Configuracion idioma de MySql para fechas
mysqli_query($link, "SET lc_time_names = 'es_ES'");

// $ruta se usa para meter ../ cuando la peticion procede de ficheros en subdirectorios
require($ruta."inc/functions.php");
?>