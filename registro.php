<?php
require('config.php');
	head("Registro - Social");
	require_once("validador.class.php");
	?>
	<script>
$(function() {
$( "#datepicker" ).datepicker({
changeMonth: true,
changeYear: true,
yearRange: "1940:2000"
});
});
</script>
</head>
<body>
	<ul id="menudrop">
		<li><a href="login.php">&lt;-- Login</a></li>
		<li><a href="contacto.php">Contacto</a></li>
	</ul>

	<h2 class="encabezado">Registro de usuario</h2>
	<br>
	<br>
	<?php

if($_POST){
	require("registro-post.php");
}
?>
	<div class="centrar">
		<div class="marco">
			<form name="registro" method='post' action='registro.php'>
				Nombre: <input type='text' class="validable" size='15' maxlength='20' name='Nombre' value="<?php echo $_POST['Nombre']; ?>" /><br />
				Apellidos: <input type='text' class="validable" size='25' maxlength='40' name='Apellidos'  value="<?php echo $_POST['Apellidos']; ?>" /><br />
				Contrase&ntilde;a: <input type='password' class="validable" size='15' name='contrasenia' /><br />
				Repita la contrase&ntilde;a: <input type='password' class="validable" size='15' name='contrasenia2' /><br />
				Email: <input type='text' class="validable" size='30' name='Email'  value="<?php echo $_POST['Email']; ?>" /><br />

				Fecha nacimiento: <input type='text' class="validable" size='15' name='nacimiento'  id="datepicker"  value="<?php echo $_POST['nacimiento']; ?>" /><br />
				
				Sexo: 
				<input type="radio" class="validable" name="Sexo" value="H"/>Hombre
				<input type="radio" class="validable" name="Sexo" value="M"/>Mujer<br />
				
				Edad:
				<input type="radio" class="validable" name="Edad" value="Mayor"/>Mayor
				<input type="radio" class="validable" name="Edad" value="Menor"/>Menor<br />

				 <input type="checkbox" class="validable" name="tos" value="tos_yes">Acepto los terminos de uso<br>

				Provincia: <select name="Provincia" class="validable"><?php require("select_provincias.html"); ?></select><br>
				<input type="hidden" name="Registro" value="yes"/>
				<button type='button' name='registro' value='Registrarse' onclick="validador('submit')">Registrarse</button>
			</form>
		</div>
	</div>
	<?php
	$Validador = new Validador();
	$Validador->SetInput(array('name' => 'Nombre', 'min' => '4'));
	$Validador->SetInput(array('name' => 'Apellidos', 'obligatorio' => 'yes'));
	$Validador->SetInput(array('name' => 'contrasenia', 'alias' => 'Contraseña', 'min' => '4'));
	$Validador->SetInput(array('name' => 'contrasenia2', 'alias' => 'Repita la Contraseña', 'semejante' => 'contrasenia,Contraseña'));
	$Validador->SetInput(array('name' => 'Email', 'formato' => '^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$'));
	$Validador->SetInput(array('name' => 'nacimiento', 'alias' => 'Fecha de nacimiento','formato' => '^\d{1,2}\/\d{1,2}\/\d{4,4}$'));
	$Validador->SetInput(array('name' => 'Sexo', 'radio' => 'yes'));
	$Validador->SetInput(array('name' => 'Edad', 'radio' => 'yes'));
	$Validador->SetInput(array('name' => 'tos', 'alias' => 'Terminos de Uso', 'checkbox' => 'yes'));
	$Validador->SetInput(array('name' => 'Provincia', 'select' => 0));
	$Validador->GeneraValidadorJS();
?>