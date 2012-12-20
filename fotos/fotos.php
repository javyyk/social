<?php
	require("../verify_login.php");
	head("Fotos - Social");
	echo "<script type='text/javascript' src='jscripts/foto_etiqueta.js'></script>";
	echo "<script type='text/javascript' src='jscripts/foto_visualizador.js'></script>";
	require("estructura.php");
?>
<div class="barra_izq_centro" style="height: 600px !important;">
	<div id='coors1'>	
	</div>
	<div id='coors2'>
		
	</div>
	<?php
	if($_GET['idfotos'] AND $_GET['uploader']){
		$fotos=mysql_query("SELECT * from fotos WHERE uploader='".$_GET['uploader']."' AND idfotos<='".$_GET['idfotos']."' ORDER BY idfotos DESC LIMIT 2");
	}else{
		$fotos=mysql_query("SELECT * from fotos WHERE uploader='".$global_idusuarios."' ORDER BY idfotos DESC LIMIT 2");
		if(mysql_num_rows($fotos)<1){
			echo "Todavia no has subido ninguna foto, <a href='subir_fotos.php'>hazlo ahora</a>";
			die();
		}
		$_GET['uploader']=$global_idusuarios;
	}
	$row_actual=mysql_fetch_assoc($fotos);

	echo "<br>".$row_actual['titulo']."<br>\n";
	//echo "<br>ID: ".$row['idfotos']." - File: ".$row['archivo']."<br>\n";
	//echo mysql_num_rows($fotos);
	echo "<div id='foto_marco'>";
		echo "<img id='foto' alt='' height='300' width='300' src='".$row_actual['archivo']."'";
		$row_sig=mysql_fetch_assoc($fotos);
		if(mysql_num_rows($fotos)==2){
			?>
			onclick="
			location.href='<?php echo "?uploader=".$_GET['uploader']."&amp;idfotos=".$row_sig['idfotos']; ?>'"
			<?php
		}
		echo "/>";
		$etiquetados = mysql_query("SELECT nombre,apellidos,idusuarios,x,y FROM fotos LEFT JOIN fotos_has_usuarios ON fotos_idfotos=idfotos INNER JOIN usuarios ON idusuarios=usuarios_idusuarios WHERE fotos.idfotos='".$row_actual['idfotos']."'");
		while($p = mysql_fetch_assoc($etiquetados)){
			echo "<div class='etiquetado' style='left:".$p['x']."px;top:".$p['y']."px;' etiqueta='".$p['idusuarios']."'></div>";
		}
	
		?>
		
	</div>
</div>




<div class="barra_der">
	<ul style='margin:0;list-style: none outside none;padding:0px;'>
		<li><a href="#" onclick="etiqueta_editar()">Editar Etiquetas</a></li>
		<li><a href="post.php?foto_principal=<?php echo $row_actual['idfotos'];?>">Principal</a></li>
		<li><a href="post.php?foto_borrar=<?php echo $row_actual['idfotos'];?>">Borrar foto</a></li>
	</ul>
	Personas:<br>
	<ul id="lista_etiquetados" style='margin:0;list-style: none outside none;padding:0px;'>
		<?php
			if(mysql_num_rows($etiquetados)>0){
				mysql_data_seek($etiquetados, 0);
				while($personas = mysql_fetch_assoc($etiquetados)){
					echo "<li onclick=\"etiqueta_borrar('".$personas['nombre']." ".$personas['apellidos']."','".$personas['idusuarios']."')\">".$personas['nombre']. " ".$personas['apellidos']."</li>";
				}
			}else{
				echo "No hay nadie etiquetado todavia";
			}
		?>
	</ul>
	<?php
		$query=mysql_query("
			SELECT *
			FROM amigos, usuarios
			WHERE user1='".$global_idusuarios."' AND user2=idusuarios OR user2='".$global_idusuarios."' AND user1=idusuarios
		");

		if(mysql_num_rows($query)>0){
			?>
			<form method='POST' action='post.php'">
				<div class="ui-widget">
				    <label for="tags" style="display: none;">Persona: </label>
				    <input id="tags" name="receptor"  style="display: none;" placeholder="Introduce el nombre"/>
				</div>
				<script>
				    //Declarando variables
				    lista_amigos = new Array();
				    lista_etiquetados = [
					    <?php
					    	if(mysql_num_rows($etiquetados)>0){
						    	mysql_data_seek($result, 0);
								$i_temp=0;
								while($personas = mysql_fetch_assoc($etiquetados)){
									if($i_temp!=0) echo ",";
									echo "{value: ".$personas['idusuarios'].", label: '".$personas['nombre']." ".$personas['apellidos']."', x: ".$personas['x'].", y: ".$personas['y']."}";
									$i_temp++;
								}
							}
						?>
					];
					var idfoto=<?php echo $row_actual['idfotos'];?>;
					 var lista_amigos = [
							<?php
								while($row=mysql_fetch_assoc($query)){
									echo "{value: '".$row['idusuarios']."', label: '".$row['nombre']." ".$row['apellidos']."'},";	
								}
							?>
						];
				    $(function() {
				       	$( "#tags" ).autocomplete({
        				    minLength: 0,
							source: lista_amigos,
				            focus: function( event, ui ) {
				            	//al focus sobre un resultado
				                $( "#tags" ).val( ui.item.label );
				                return false;
				            },
				            select: function( event, ui ) {
				                //AL PULSAR UN RESULTADO
				               	//lo añadimos a los etiquetados
				                lista_etiquetados.push({value: ui.item.value, label: ui.item.label, x: x_centrado, y: y_centrado});
				            	$("#lista_etiquetados").append("<li onclick=\"etiqueta_borrar('"+ui.item.label+"','"+ui.item.value+"')\">"+ui.item.label+"</li>");
								$( "#tags" ).val("");
								
								// buscamos el nombre del amigo seleccionado
								for(i=0;i<lista_amigos.length;i++){
									if(lista_amigos[i].label==ui.item.label){
										lista_amigos.splice(i, 1); // y lo quitamos del array
										break;
									}
								}
								
								//efectos de raton y divs
								etiqueta_fijar(ui.item.value);
								return false;
				            }
				        }).data( "autocomplete" )._renderItem = function( ul, item ) {
				            return $( "<li>" )
				                .data( "item.autocomplete", item )
				                .append( "<a>" + item.label + "</a>" )
				                .appendTo( ul );
				        };
					});
					</script>
				<br>
			  	<button type="button" onclick="post(lista_etiquetados);" style="display: none !important;">Enviar</button>
			</form>
		<?php
		}
		?>
</div>


























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