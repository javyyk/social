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


if(	(!$_POST['Nombre'] OR !$_POST['Apellidos'] OR !$_POST['contrasenia'] OR 
	$_POST['contrasenia'] != $_POST['contrasenia2'] OR !$_POST['Email'] OR !$_POST['nacimiento']) AND $_POST['Registro']){
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
}elseif($_POST['Nombre']!=""){
	$existe = mysql_query("SELECT * FROM usuarios WHERE email='".$_POST['Email']."'");

	if(mysql_num_rows($existe) !="0"){
		?>
		<br><center><h3><font color="red">El email "<?php echo $_POST['Email']; ?>" ya existe</font></h3></center><br><br>
		<?php
	}else{
		mysql_query("INSERT INTO usuarios (nombre, apellidos, fnac, password, email,fecha_reg, sexo)
			values ('".$_POST['Nombre']."','".$_POST['Apellidos']."',STR_TO_DATE('".$_POST['nacimiento']."','%d/%m/%Y'),'".sha1($_POST['contrasenia'])."','".$_POST['Email']."',curdate(),'".$_POST['Sexo']."')");
		error_mysql('');
		?>
		<br>
		<center>
			Tu cuenta ha sido creada correctamente.<br>
			Se ha enviado un email a tu direccion
		</center>
		<a href=index.php><b>Entrar el sistema</b></a><br><br>		
		<?php
		die();
	}	
}

if(!$_POST['registro'] OR $registro_fallido==1){
	?>
	<div class="marco">
		<form name="registro" method='post' action='registro.php'>
			Nombre: <input type='text' class="validable" size='15' maxlength='20' name='Nombre' value="<?php echo $_POST['Nombre']; ?>" /><br />
			Apellidos: <input type='text' class="validable" size='25' maxlength='40' name='Apellidos'  value="<?php echo $_POST['Apellidos']; ?>" /><br />
			Contrase&ntilde;a: <input type='password' class="validable" size='15' name='contrasenia' /><br />
			Repita la contrase&ntilde;a: <input type='password' class="validable" size='15' name='contrasenia2' /><br />
			Email: <input type='text' class="validable" size='30' name='Email'  value="<?php echo $_POST['Email']; ?>" /><br />
			Fecha nacimiento: <input type='text' class="validable" size='15' name='nacimiento'  id="datepicker"  value="<?php echo $_POST['nacimiento']; ?>" /><br />

			<input type="radio" name="Sexo" value="H"/>Hombre<br />
			<input type="radio" name="Sexo" value="M"/>Mujer<br />
			
			 <input type="checkbox" name="tos" value="tos_yes">Acepto los terminos de uso<br>
			
			<input type="hidden" name="Registro" value="yes"/>
			<button type='button' name='registro' value='Registrarse' onclick="validador('submit')">Registrarse</button>
			</form>
	</div>
	<?php
	$Validador = new Validador();
	$Validador->SetInput(array('name' => 'Nombre', 'min' => '4'));
	$Validador->SetInput(array('name' => 'Apellidos', 'obligatorio' => 'yes'));
	$Validador->SetInput(array('name' => 'contrasenia', 'alias' => 'Contraseña', 'min' => '4'));
	$Validador->SetInput(array('name' => 'contrasenia2', 'alias' => 'Repita la Contraseña', 'semejante' => 'contrasenia,Contraseña'));
	$Validador->SetInput(array('name' => 'Email', 'formato' => '^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$'));
	$Validador->SetInput(array('name' => 'nacimiento', 'alias' => 'Fecha de nacimiento','formato' => '^\d{1,2}\/\d{1,2}\/\d{4,4}$'));
	//$Validador->SetInput(array('name' => 'contrasenia', 'obligatorio' => 'yes', 'min' => '4', 'max' => '10', 'semejante' => 'Password,Repite-password'));
	//$Validador->SetInput(array('name' => 'Password', 'obligatorio' => 'yes', 'min' => '4', 'max' => '10', 'semejante' => 'Password,Repite-password'));
	//$Validador->SetInput(array('name' => 'Email', 'obligatorio' => 'yes', 'max' => '30', 'formato' => '^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$'));
	$Validador->SetInput(array('name' => 'Sexo', 'radio' => 'Hombre,Mujer'));
	//$Validador->SetInput(array('name' => 'tos', 'obligatorio' => 'yes'));
	$Validador->GeneraValidadorJS();
}
?>