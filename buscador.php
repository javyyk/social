<?php
	require("verify_login.php");
	head("Buscador - Social");
	require("estructura.php");
?>

<div id="cuerpo" class="">
<form method="GET" action="buscador.php">
	<input type="text" name="busqueda" value="<?php echo $_GET['busqueda']; ?>"/>
	<button type="button">Buscar</button>
</form>
<?php
	if($_GET['agregar']){//ENVIAR PETICION AMISTAD
		$query=mysql_query("SELECT * FROM amigos WHERE user1='".$_GET['agregar']."' AND user2='".$global_idusuarios."' OR user1='".$global_idusuarios."' AND user2='".$_GET['agregar']."'");	
		if(mysql_errno()!=0){
			error_mysql("exit");
		}
		if(mysql_num_rows($query)>0){
			header("Location: inicio.php?yasoisamigos");
		}
		mysql_query("INSERT INTO peticiones VALUES ('".$global_idusuarios."','".$_GET['agregar']."')");
	}
	if($_GET['busqueda']){//REALIZAR BUSQUEDA
		$query=mysql_query("
		SELECT *,
			(
				SELECT count(*)  
				FROM amigos WHERE user1='".$global_idusuarios."' AND user2=idusuarios
				) AS amigo,
			(
				SELECT count(*)  
				FROM peticiones WHERE emisor='".$global_idusuarios."' AND receptor=idusuarios
				) AS enviada 
		FROM usuarios
		WHERE idusuarios!='".$global_idusuarios."' AND 
			(nombre LIKE '%".$_GET['busqueda']."%' OR apellidos LIKE '%".$_GET['busqueda']."%')
		");
		
		if(mysql_num_rows($query)>0){
			while($row=mysql_fetch_assoc($query)){
				//print_r($row);
				echo $row['nombre']." ".$row['apellidos']." -> ";
				if($row['amigo']==0 AND $row['enviada']==0){
					echo "<a href='buscador.php?busqueda=".$_GET['busqueda']."&agregar=".$row['idusuarios']."'>Agregar</a>";
				}elseif($row['amigo']==0 AND $row['enviada']==1){
					echo "Peticion enviada";
				}elseif($row['amigo']==1){
					echo "Amigo!";
				}
				echo "<br />";
				
			}
		}
	}
?>
</div>