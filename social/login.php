<?php
session_start();
require('config.php');
if(isset($_SESSION['idsesion'])) {
  	header("Location: inicio.php");
}
head("Login - Social");

if($_POST['email']){
	$login=mysql_query("SELECT * FROM usuarios WHERE email='".$_POST['email']."' AND password='".sha1($_POST['password'])."'");

	//LOGIN OK
	if(mysql_num_rows($login)==1){
		$codigo_temp=rand(0, 99999999999);
		mysql_query("UPDATE usuarios SET idsesion='".$codigo_temp."' WHERE email='".$_POST['email']."'");
		$_SESSION['idsesion']=$codigo_temp;
		session_write_close();
		header( "Location: inicio.php" ); 
		//echo "LOGIN OK";
		/*if($_POST['logincookie']==true){
			$fecha=time()+60*60*24*30;
		}else{
			$fecha=0;
		}*/
		
		//HAY URL?
		/*if($_COOKIE['tienda_url']){
			$url = $_COOKIE['forocochesurl'];
			setcookie("tienda_url", $_COOKIE['forocochesurl'], time()-36000000);
			header( "Location: ".$url );
		}else{
			header( "Location: index.php?log" );
		}*/
		
	//LOGIN FAIL
	}else{
		echo "LOGIN FAIL<br>";
	}
}
	require_once("validador.class.php");
	$Validador = new Validador();
	$Validador->SetInput(array('name' => 'email', 'obligatorio' => 'yes', 'min' => '6'));
	$Validador->SetInput(array('name' => 'password', 'obligatorio' => 'yes', 'min' => '6'));
	$Validador->GeneraValidadorJS();
?>

	
	<div id="main">
		<h1 id="logo">Social</h1>
		<!--<img src="imagenes/social-portada.png" alt="logo">-->
		<div id="form">
			<form id='form_login' method='POST' action='login.php'>
				Email: <input type='text' size='20' name='email'><br>
				Clave: <input type='password' size='20' name='password'><br>
				<!--Recordar datos: <input name='logincookie' type='checkbox' value='true'>
				<br>-->
			  <button type="button" onclick="validador('submit');">Entrar</button>
			  <button type='button' onclick="location.href='registro.php';" class="login_registrarse">Registrarse</button>
			</form>
		</div>
		<div id="creditos">
			<div>
				<p>Social &copy; 2012</p>
				<p>Social Inc.&#8482;</p>
			</div>
		</div>
	</div>
</body>