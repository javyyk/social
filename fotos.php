<?php
	require("verify_login.php");
	head("Fotos - Social");
	echo "<script type='text/javascript' src='jscripts/foto_etiqueta.js'></script>";
	require("estructura.php");
?>
<div class="barra_izq_centro">
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
	
		?>
		/>
	</div>
</div>
<div class="barra_der">
	<ul style='margin:0;list-style: none outside none;padding:0px;'>
		<li><a href="#" onclick="editar_etiquetas()">Editar Etiquetas</a></li>
		<li><a href="post.php?foto_principal=<?php echo $row_actual['idfotos'];?>">Principal</a></li>
		<li><a href="post.php?foto_borrar=<?php echo $row_actual['idfotos'];?>">Borrar foto</a></li>
	</ul>
	<ul id="lista_etiquetados" style='margin:0;list-style: none outside none;padding:0px;'>
	</ul>
	<?php
		$query=mysql_query("
			SELECT *
			FROM amigos, usuarios
			WHERE user1='".$global_idusuarios."' AND user2=idusuarios OR user2='".$global_idusuarios."' AND user1=idusuarios
		");

		if(mysql_num_rows($query)>0){
			?>
			<form method='POST' action='post.php' style="display:none;">
				<div class="ui-widget">
				    <label for="tags">Persona: </label>
				    <input id="tags" name="receptor" />
				</div>
				<script>
				    $(function() {
				        var amigos = [
							<?php
							while($row=mysql_fetch_assoc($query)){
								echo "{value: '".$row['idusuarios']."', label: '".$row['nombre']." ".$row['apellidos']."'},";	
							}
							?>
						];
				       /*//  alert(amigos);
				        // delete amigos[1].label;
				         amigos[2].value="";
				        // alert(amigos[0].label);
				        // alert(amigos[0].value);
				        // alert(amigos);
      // alert(amigos.length);
						tmp = new Array();
						i_new=0;
						for(i=0;i<amigos.length;i++){
							//alert(i);
							//alert(amigos[i].value!="");
							//alert(amigos[i].label);
							if(amigos[i].value.length>0){
								alert(amigos[i].label);
								tmp[i_new] = {};
								tmp[i_new].label = amigos[i].label;
								tmp[i_new].value = amigos[i].value;	
								i_new++;
							}						
						}
						
						alert(tmp);
						var amigos = tmp;
						//alert(tmp[0].label);
						*/
						
						
						$( "#tags" ).autocomplete({
        				    minLength: 0,
							source: amigos,
				            focus: function( event, ui ) {
				            	//al focus sobre un resultado
				                $( "#tags" ).val( ui.item.label );
				                return false;
				            },
				            select: function( event, ui ) {
				                //AL PULSAR UN RESULTADO
				                $("#lista_etiquetados").append("<li onclick=\"etiqueta_delete('"+ui.item.label+"','"+ui.item.value+"')\" value='"+ui.item.value+"'>"+ui.item.label+"</li>");
								$( "#tags" ).val("");
										
								 		//alert(amigos);
								        // delete amigos[1].label;
								         //amigos[2].value="";
								        // alert(amigos[0].label);
								        // alert(amigos[0].value);
								        // alert(amigos);
				      // alert(amigos.length);
										tmp = new Array();
										i_new=0;
										for(i=0;i<amigos.length;i++){
											if(amigos[i].value==ui.item.value){
								        		 amigos[i].value="";
											}
											//alert(i);
											//alert(amigos[i].value!="");
											//alert(amigos[i].label);
											if(amigos[i].value.length>0){
												//alert(amigos[i].label);
												tmp[i_new] = {};
												tmp[i_new].label = amigos[i].label;
												tmp[i_new].value = amigos[i].value;	
												i_new++;
											}						
										}
										
										//alert(tmp);
										//$("#ui-id-1").find("li").remove();
										//amigos = tmp;
										
						$( "#tags" ).autocomplete( "option", "source", tmp );
										//alert(tmp[0].label);
				                return false;
				            }
				        }).data( "autocomplete" )._renderItem = function( ul, item ) {
				            return $( "<li>" )
				                .data( "item.autocomplete", item )
				                .append( "<a>" + item.label + "</a>" )
				                .appendTo( ul );
				        };
								//$("#ui-id-1").find("a").click(function(){
									//alert($(i.item.value).html());
									//$("#lista_etiquetados").append("<li><a href='#'>"+$(this).text()+"</a></li>");
								//});
							//}
					});
					</script>
				<br>
			  	<button type="button" onclick="validador('submit');">Enviar</button>
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