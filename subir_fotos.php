<?php
	require("verify_login.php");
	head("Subir fotos - Social");
	require("upload/subida.html"); ?>
</head>
<body>
	<?php require("estructura.php"); ?>
	<h2 class="encabezado">Subida de fotos</h2>
	<div class="cuerpo_full">
	<?php
	if($_POST['subir_fotos']){
		$count=0;
		foreach ($_POST as $name => $value) {
			if(preg_match("/tmpname/", $name, $algohaykeponer) == 1){
				$count++;
				mysql_query("INSERT INTO fotos (titulo,archivo,uploader,fecha) VALUES ('".$_POST['titulo']."','fotos/".limpia_texto($global_nombrefull)."_".$global_idusuarios."/".$value."','".$global_idusuarios."',now())");
				error_mysql("exit");
			}
		}

		if($count>0){
			echo "Fotos subidas con exito<br><br>";
		}else{
			echo "Faltan las imagenes<br><br>";
		}
	}
	?>
	<form method="post" action="subir_fotos.php" enctype="multipart/form-data">
		<b>Titulo(s):</b> <input type="text" name="titulo" size="55" /><br />
		<b>Imagenes:</b><br />
		<div id="uploader"></div>
		<input type="hidden" name="subir_fotos" value="1" />
		<input type="submit" value="Subir fotos" />
	</form>

</body>
</html>