<?php
$dir="user_fotos/1-Javier-Gonzalez-Rastrojo/";
$directorio = opendir($dir);
echo "<b>Directorio actual:</b><br>$dir<br>";
echo "<b>Archivos:</b><br>";
while ($archivo = readdir($directorio)){
	echo "$archivo<br>";
	unlink($dir.$archivo);
}
closedir($directorio);
include 'config.php';
mysql_query("DELETE FROM fotos WHERE uploader='1'");
?>
