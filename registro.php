<?php
require('config.php');
	head("Registro - Social");
	require_once("validador.class.php");
	?>
	<script>
    $(function() {
        $( "#datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true
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


if(	(!$_POST['nombre'] OR !$_POST['apellidos'] OR !$_POST['contrasenia'] OR 
	$_POST['contrasenia'] != $_POST['contrasenia2'] OR !$_POST['email'] OR !$_POST['nacimiento'])
	AND $_POST['registro']=='Registrarse'){
		?>
		<h2>
			<font color="red">Debes cumplir las siguientes condiciones:</font>
		</h2>
		<ul>
			<li>El usuario no puede estar en blanco</li>
			<li>Las contrase�as no pueden estar en blanco y deben ser iguales</li>
		</ul>
		<br><br><br><b><a href='registro.php'>Volver a intentarlo</a></b><br><br>
		<?php
		$registro_fallido=1;
}elseif($_POST['registro']=='Registrarse'){
	$existe = mysql_query("SELECT * FROM usuarios WHERE email='".$_POST['email']."'");

	if(mysql_num_rows($existe) !="0"){
		?>
		<br><center><h3><font color="red">El usuario \"".$usuario."\" ya existe</font></h3><br><br>
		<br><br><br><center><b><a href='registro.php'>Volver a intentarlo</a></b><br><br>
		<?php
	}else{
		mysql_query("INSERT INTO usuarios (nombre, apellidos, edad, password, email)
			values ('".$_POST['nombre']."','".$_POST['apellidos']."','".$_POST['nacimiento']."','".sha1($_POST['contrasenia'])."','".$_POST['email']."')");
		if(mysql_errno()){
			error_mysql();
			die();
		}
		?>
		<br>
		<center>
			Tu cuenta ha sido creada correctamente.<br>
			Se ha enviado un email a tu direccion
		</center>
		<a href=index.php><b>Entrar el sistema</b></a><br><br>		
		<?php
	}	
}

if(!$_POST['registro'] OR $registro_fallido==1){
	?>
	<div class="marco">
		<form name="registro" method='post' action='registro.php'>
			Nombre: <input type='text' size='15' maxlength='20' name='Nombre' /><br />
			Apellidos: <input type='text' size='25' maxlength='40' name='Apellidos' /><br />
			Contrase&ntilde;a: <input type='password' size='15' name='contrasenia' /><br />
			Repita la contrase&ntilde;a: <input type='password' size='15' name='contrasenia2' /><br />
			Email: <input type='text' size='30' name='Email' /><br />
			Fecha nacimiento: <input type='text' size='15' name='nacimiento'  id="datepicker" /><br />

			<input type="radio" name="Sexo" value="Hombre"/>Hombre<br />
			<input type="radio" name="Sexo" value="Mujer"/>Mujer<br />
			
			 <input type="checkbox" name="tos" value="tos_yes">Acepto los terminos de uso<br>
			
			<button type='button' name='registro' onclick="validador('submi')">Registrarse</button>
			</form>
	</div>
	<?php
	$Validador = new Validador();
	$Validador->SetInput(array('name' => 'Nombre', 'min' => '4'));
	$Validador->SetInput(array('name' => 'Apellidos', 'obligatorio' => 'yes'));
	$Validador->SetInput(array('name' => 'contrasenia', 'alias' => 'Contraseña', 'min' => '4'));
	$Validador->SetInput(array('name' => 'contrasenia2', 'alias' => 'Repita la Contraseña', 'semejante' => 'contrasenia,Contraseña'));
	$Validador->SetInput(array('name' => 'Email', 'formato' => '^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$'));
	$Validador->SetInput(array('name' => 'nacimiento', 'alias' => 'Fecha de nacimiento','formato' => '^\d{1,2}\/\d{1,2}\/\d{2,4}$'));
	//$Validador->SetInput(array('name' => 'contrasenia', 'obligatorio' => 'yes', 'min' => '4', 'max' => '10', 'semejante' => 'Password,Repite-password'));
	//$Validador->SetInput(array('name' => 'Password', 'obligatorio' => 'yes', 'min' => '4', 'max' => '10', 'semejante' => 'Password,Repite-password'));
	//$Validador->SetInput(array('name' => 'Email', 'obligatorio' => 'yes', 'max' => '30', 'formato' => '^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$'));
	$Validador->SetInput(array('name' => 'Sexo', 'radio' => 'Hombre,Mujer'));
	//$Validador->SetInput(array('name' => 'tos', 'obligatorio' => 'yes'));
	$Validador->GeneraValidadorJS();
	
	if($_POST){
		$Validador->GeneraValidadorPHP();
		echo "<pre><b>Contenido POST:</b><br>";
		print_r($_POST);
		echo "</pre>";
	}
/*
 * Atributos: name, obligatorio, min, max,formato,caracteres no permitidos,sincronizacion de campos
 * que hacer si el validador php no acepta o si acepta
 */

}
?>