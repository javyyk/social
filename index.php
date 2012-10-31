<?php
session_start();
require('config.php');
if(isset($_SESSION['idsesion'])) {
	header("Location: inicio.php");
} else {
	header("Location: login.php");
}
?>