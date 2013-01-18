<?php
	if(mysql_num_rows($fotos)){
		?>
		<div class="barra_full">
			<h2>Comentarios</h2>
				<textarea name="foto_comentario" cols="60" rows="2" id="foto_comentario_mens"></textarea>
				<input type="hidden" name="idfotos" value="<?php echo $row_actual['idfotos']; ?>" />
				<button onclick="enviar_comentario()">Enviar comentario</button>

			<?php
			$query=mysql_query("
				SELECT nombre, apellidos, comentario,
				 DATE_FORMAT(fecha, '%d/%m/%Y %H:%i') AS fecha,
				(SELECT archivo FROM fotos WHERE idfotos=idfotos_princi) AS img_princi
				 FROM fotos_comentarios, usuarios WHERE fotos_idfotos='".$row_actual['idfotos']."' AND emisor=idusuarios ORDER BY fecha DESC");
			if(mysql_num_rows($query)>0){
				while($comentarios=mysql_fetch_assoc($query)){
					echo "<div class='foto_comentario'>";
						echo "<div class='foto_come_titu'>".$comentarios['nombre']." ".$comentarios['apellidos'];
							echo "<div class='foto_come_fecha'>".$comentarios['fecha']."</div>";
						echo "</div>";
						echo "<div class='foto_come_men'>".$comentarios['comentario']."</div>";
					echo "</div>";
				}
			}else{
				echo "<div>Todavia nadie ha comentado esta foto</div>";
			}
			?>
		</div>
	<?php
	}
?>

<script>
	function enviar_comentario(){
		//crear div
		$("body").append("<div id='ajax_cargando'></div>");
		
		comentario = $("#foto_comentario_mens").val();
		ajax_post2('post.php',comentario);
	}
	function ajax_post2(url,data){
		$.ajax({
		  type: "POST",
		  url: url,
		  data: data
		}).done(function(){
			alert("success"); 
			
		}).fail(function(){
			alert("error");
			
		}).always(function(msg) { alert("complete"+msg);
		});
	}
</script>