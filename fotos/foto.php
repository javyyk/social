<?php

	/*if($_GET['idfotos'] AND $_GET['uploader']){
		$fotos=mysql_query("SELECT * from fotos WHERE uploader='".$_GET['uploader']."' AND idfotos<='".$_GET['idfotos']."' ORDER BY idfotos DESC LIMIT 2");
	}else{
		$fotos=mysql_query("SELECT * from fotos WHERE uploader='".$global_idusuarios."' ORDER BY idfotos DESC LIMIT 2");
		if(mysql_num_rows($fotos)<1){
			echo "Todavia no has subido ninguna foto, <a href='subir_fotos.php'>hazlo ahora</a>";
			die();
		}
		$_GET['uploader']=$global_idusuarios;
	}*/
	if(mysql_num_rows($fotos)){
		?>
		<div class="barra_izq_centro" style="height: 600px !important;">
			<div id='coors1'></div>
			<div id='coors2'></div>
		<?php
		$row_actual=mysql_fetch_assoc($fotos);
		echo "<br>".$row_actual['titulo']."<br>\n";
				
		echo "<div id='foto_marco'>";
			echo "<img id='foto' alt='' height='300' width='300' src='".$row_actual['archivo']."'";
				if(mysql_num_rows($fotos)>1){
					$row_sig=mysql_fetch_assoc($fotos);
					?>
					onclick="
					location.href='<?php echo "?album=".$_GET['idalbum']."&amp;idfotos=".$row_sig['idfotos']; ?>'"
					<?php
				}
			echo "/>";
			$etiquetados = mysql_query("SELECT nombre,apellidos,idusuarios,x,y FROM fotos LEFT JOIN etiquetas ON fotos_idfotos=idfotos INNER JOIN usuarios ON idusuarios=usuarios_idusuarios WHERE fotos.idfotos='".$row_actual['idfotos']."'");
			while($p = mysql_fetch_assoc($etiquetados)){
				echo "<div class='etiquetado etiqueta_".$p['idusuarios']."' style='left:".$p['x']."px;top:".$p['y']."px;' id='etiqueta_".$p['idusuarios']."'></div>";
			}
	
	}else{
		?>
		<div class="centrar">
		<div class="error_ajustable">
		<?php
		if($_GET['iduser']==$global_idusuarios){
			if($_GET['idalbum']=='subidas'){
				echo "No has subido ninguna foto";
			}
			if($_GET['idalbum']=='etiquetadas'){
				echo "No estas etiquetado en ninguna foto";
			}
		}else{
			if($_GET['idalbum']=='subidas'){
				echo $global_nombre." no ha subido ninguna foto";
			}
			if($_GET['idalbum']=='etiquetadas'){
				echo $global_nombre." no esta etiquetado en ninguna foto";
			}
		}
		echo "</div></div>";
		die();
	}
	//echo "<br>ID: ".$row['idfotos']." - File: ".$row['archivo']."<br>\n";
	//echo mysql_num_rows($fotos);

		?>
		
	</div>
</div>