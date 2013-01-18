<?php
require ("verify_login.php");
head("Subir fotos - Social");
require ("upload/subida.html");
?>
</head>
<body>
	<?php
	require ("estructura.php");
	?>
	<div class="cuerpo_full">
		<?php
		if ($_POST['subir_fotos']) {
			$count = 0;
			foreach ($_POST as $name => $value) {
				if (preg_match("/tmpname/", $name, $algohaykeponer) == 1) {
					$count++;
					if($_POST['idalbum']!=("NULL" OR null))
						$_POST['idalbum'] = "'".$_POST['idalbum']."'";
					
					mysql_query("INSERT INTO fotos (titulo,archivo,uploader,fecha,albums_idalbums) VALUES ('" . $_POST['titulo'] . "','user_fotos/" . $global_idusuarios . "-" . limpia_texto($global_nombrefull) . "/" . $value . "','" . $global_idusuarios . "',now()," . $_POST['idalbum'] . ");");
					error_mysql("exit");
				}
			}

			if ($count > 0) {
				echo "Fotos subidas con exito<br><br>";
			} else {
				echo "Faltan las imagenes<br><br>";
			}
		}
		?>
		<form method="post" action="subir_fotos.php" enctype="multipart/form-data">
			<b>Titulo(s):</b>
			<input type="text" name="titulo" size="55" />
			<br />
			<b>Album:</b>
			<?php
			$albums = mysql_query("SELECT * FROM `albums` WHERE usuarios_idusuarios='" . $global_idusuarios . "'");
			if (mysql_num_rows($albums) > 0) {
				echo "<select name='idalbum'><option value='NULL'>Ninguno</option>";
				while ($row = mysql_fetch_assoc($albums)) {
					echo "<option value='" . $row['idalbums'] . "'>" . $row['album'] . "</option>";
				}
			} else {

			}
			?>
			</select>
			<br />
			<b>Imagenes:</b>
			<br />
			<div id="uploader"></div>
			<input type="hidden" name="subir_fotos" value="1" />
			<button type="submit">
				Subir fotos
			</button>
		</form>

</body>
</html>