<?php
session_start();
session_destroy();
header("Location: index.php");
//<a href="index.php">Entrar</a>
?>