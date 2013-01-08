<div class="barra_der">
	<ul style='margin:0;list-style: none outside none;padding:0px;'>
		<li><a href="#" onclick="etiqueta_editar()">Editar Etiquetas</a></li>
		<li><a href="post.php?foto_principal=<?php echo $row_actual['idfotos'];?>">Principal</a></li>
		<li><a href="post.php?foto_borrar=<?php echo $row_actual['idfotos'];?>">Borrar foto</a></li>
	</ul>
	Personas:<br>
	<ul id="lista_etiquetados" style='margin:0;list-style: none outside none;padding:0px;'>
		<?php
			if(mysql_num_rows($fotos)){
				if(mysql_num_rows($etiquetados)>0){
					mysql_data_seek($etiquetados, 0);
					while($personas = mysql_fetch_assoc($etiquetados)){
						echo "<li class='etiqueta_".$personas['idusuarios']."'>".$personas['nombre']. " ".$personas['apellidos']."<div onclick=\"etiqueta_borrar('".$personas['nombre']." ".$personas['apellidos']."','".$personas['idusuarios']."')\"></div></li>";
					}
				}else{
					echo "No hay nadie etiquetado todavia";
				}
			}
		?>
	</ul>
	<?php
		$query=mysql_query("SELECT idusuarios, nombre, apellidos FROM amigos, usuarios WHERE user1='".$global_idusuarios."' AND user2=idusuarios OR user2='".$global_idusuarios."' AND user1=idusuarios UNION SELECT idusuarios, nombre, apellidos FROM usuarios WHERE idusuarios='".$global_idusuarios."'");
		?>
			<form >
				<div class="ui-widget">
				    <label for="tags" style="display: none;">Persona: </label>
				    <input id="tags" name="receptor"  style="display: none;"/>
				</div>
				<script>
				    //Declarando variables
				    lista_amigos = new Array();
				    lista_etiquetados = [
					    <?php
							if(mysql_num_rows($fotos)){
						    	if(mysql_num_rows($etiquetados)>0){
							    	mysql_data_seek($etiquetados, 0);
									$i_temp=0;
									while($personas = mysql_fetch_assoc($etiquetados)){
										if($i_temp!=0) echo ",";
										echo "{value: ".$personas['idusuarios'].", label: '".$personas['nombre']." ".$personas['apellidos']."', x: ".$personas['x'].", y: ".$personas['y']."}";
										$i_temp++;
									}
								}
							}
						?>
					];
					var idfoto=<?php echo $row_actual['idfotos'];?>;
					 var lista_amigos = [
							<?php
								$i_temp=0;
								while($row=mysql_fetch_assoc($query)){
									if($i_temp!=0) echo ",";
									echo "{value: '".$row['idusuarios']."', label: '".$row['nombre']." ".$row['apellidos']."'}";	
								$i_temp++;
								}
							?>
						];
						
					</script>
				<br>
			  	<button type="button" onclick="post(lista_etiquetados);" style="display: none !important;">Enviar</button>
			</form>
</div>