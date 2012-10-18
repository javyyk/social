<?php
	require("config.php");
	require("cabecera.php");

if($_GET['producto']){
	mysql_query("delete from productos where idproductos='".$_GET['producto']."'");
	echo mysql_error();
	echo "<h3>Producto borrado con exito</h3>";
}
?>