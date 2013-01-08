<?php
	if(mysql_num_rows($fotos)){
		?>
		<div class="barra_full">
			<h2>Comentarios</h2>
			<form method="POST" action="post.php">
				<textarea name="foto_comentario" cols="60" rows="2"></textarea>
				<input type="hidden" name="idfotos" value="<?php echo $row_actual['idfotos']; ?>" />
				<input type="submit" value="Submit">
			</form>
			<?php
			$query=mysql_query("
				SELECT nombre, apellidos, comentario,
				 DATE_FORMAT(fecha, '%d/%m/%Y %H:%i') AS fecha,
				(SELECT archivo FROM fotos WHERE idfotos=idfotos_princi) AS img_princi
				 FROM fotos_comentarios, usuarios WHERE fotos_idfotos='".$row_actual['idfotos']."' AND emisor=idusuarios ORDER BY fecha DESC");
			if(mysql_num_rows($query)>0){
				while($comentarios=mysql_fetch_assoc($query)){
					echo "<div>".$comentarios['nombre']." ".$comentarios['apellidos']." ".$comentarios['fechaf']."<br>";
					echo "Dijo: ".$comentarios['comentario']."</div><br>";
				}
			}else{
				echo "<div>Todavia nadie ha comentado esta foto</div>";
			}
			?>
		</div>
	</div>
	<?php
	}
?>