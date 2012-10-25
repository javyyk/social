<?php
	require("verify_login.php");
	head("Subir fotos - Social");
?>
	<link rel="stylesheet" href="upload/js/jquery.plupload.queue/css/jquery.plupload.queue.css" type="text/css" media="screen" />
	<script type="text/javascript" src="upload/js/plupload.js"></script>
	<script type="text/javascript" src="upload/js/plupload.flash.js"></script>
	<script type="text/javascript" src="upload/js/plupload.html4.js"></script>
	<script type="text/javascript" src="upload/js/plupload.html5.js"></script>
	<script type="text/javascript" src="upload/js/i18n/es.js"></script>
	<script type="text/javascript" src="upload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
</head>
<body>
	<?php require("estructura.php"); ?>
	<h3>Subir fotos</h3>
	<div class="cuerpo_centro">
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
		<?php require("upload/subida.html"); ?>
		<input type="hidden" name="subir_fotos" value="1" />
		<input type="submit" value="Subir fotos" />
	</form>

</body>
</html>