<div id="chat">
	<div id="chat_boton" onclick="chat_toggle()"></div>
	<div id="chat_contactos">
		<?php
		if($_SESSION['chat_estado']!="on")
			echo "<p style='cursor:pointer;' onclick=\"chat_turn('on')\">Activar Chat</p>";
		?>
	</div>
	<div id='chat_conv_tmp' style='display:none;'></div>
</div>