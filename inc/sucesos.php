		<h2>Novedades</h2>
		<?php
			$sql = "SELECT sucesos.*, DATE_FORMAT(fecha, '%d/%m/%Y %H:%i') AS fecha
				FROM amigos, usuarios, sucesos
				WHERE {$global_idusuarios} = user1 AND user2 = idusuarios AND user2 = propietario
				OR {$global_idusuarios} = user2 AND user1 = idusuarios AND user1 = propietario
				ORDER BY fecha DESC";
			$query=mysqli_query($link, $sql);
			//echo mysqli_error($link);
			while($row = mysqli_fetch_assoc($query)){
				//print_r($row);
				if($row['tipo']=="amistad"){
					$query2=mysqli_query($link, "SELECT * FROM usuarios WHERE idusuarios = {$row['propietario']} OR idusuarios = {$row['visitante']}");
					echo mysqli_error($link);
					$row2 = mysqli_fetch_assoc($query2);
					echo $row['fecha']." -> ".$row2['nombre']." y ";
					$row2 = mysqli_fetch_assoc($query2);
					echo $row2['nombre']." son amigos<br>";
				}
				
				if($row['tipo']=="fotos"){
					
				}
				
				if($row['tipo']=="foto"){
					$query2=mysqli_query($link, "SELECT * FROM fotos, usuarios WHERE idfotos = {$row['datos']} AND idusuarios={$row['propietario']}");
					echo mysqli_error($link);
					$row2 = mysqli_fetch_assoc($query2);
					echo $row['fecha']." -> ".$row2['nombre']." a cambiado su foto principal <img src='".$row2['archivo']."' style='max-height:100px'><br>";
				}
				
				if($row['tipo']=="estado"){
					$query2=mysqli_query($link, "SELECT * FROM usuarios WHERE idusuarios = {$row['propietario']}");
					echo mysqli_error($link);
					$row2 = mysqli_fetch_assoc($query2);
					echo $row['fecha']." -> ".$row2['nombre']." a cambiado su estado a ".$row2['estado']."<br>";
				}
				
				if($row['tipo']=="tablon"){
					$query2=mysqli_query($link, "SELECT * FROM usuarios WHERE idusuarios = {$row['propietario']} OR idusuarios = {$row['visitante']}");
					echo mysqli_error($link);
					$row2 = mysqli_fetch_assoc($query2);
					echo $row['fecha']." -> ".$row2['nombre']." ha comentado el tablon de ";
					$row2 = mysqli_fetch_assoc($query2);
					echo $row2['nombre'].": ".$row['datos']."<br>";
				}
			}
		?>