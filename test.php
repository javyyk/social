<?php
	require("verify_login.php");
	head("Mensajeria Privada - Social");
?>

<script>
$.ajax({
	url: "post.php",
}).done(function ( data ) {
	alert(data);
});
</script>