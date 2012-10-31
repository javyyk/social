/////////////////////	CHAT FUNCTIONS	////////////////////
$(document).ready(function(){
	$("body").append("<div id='chat_conversaciones'></div>");
	$("body").append("<div id='tmp' style='display:none;'></div>");
});
function estado_online(){
	$.ajax({
	  type: "POST",
	  url: "post.php",
	  data: { estado_online: "1" }
	}).done(function( msg ) {
	  //alert( "Data Saved: " + msg );*/
	});
}

timeOutId = setInterval(estado_online, 30000);
estado_online();

function chat_init_conv(iduser, nombre){
	//alert("conversa"+iduser);
	if($("#chat_conv_"+iduser).length<1){
		$("#chat_conversaciones").append(
			"<div id='chat_conv_"+iduser+"_min' class='chat_ventana_min' onclick=\"max('"+iduser+"')\">"+nombre+
				"<div class='mensajes'></div>"+
			"</div>"+
			"<div id='chat_conv_"+iduser+"' class='chat_ventana' iduser='"+iduser+"'>"+nombre+
				"<div class='boton cerr' onclick=\"cerrar('"+iduser+"')\"></div>"+
				"<div class='boton max'></div>"+
				"<div class='boton mini' onclick=\"mini('"+iduser+"')\"></div>"+
				"<div id='mensajes'></div>"+
				"<textarea name='mensaje' rows='2'></textarea>"+
				"<button type='button' onclick=\"enviar('"+iduser+"')\">Enviar</button>"+
			"</div>");
	}
}

function enviar(iduser){
	mensaje = $("#chat_conv_"+iduser).find("textarea").val();
	$("#chat_conv_"+iduser).find("textarea").val("");
	$("#chat_conv_"+iduser).find("#mensajes").append("<div class='mensaje'>Yo: "+mensaje+'</div>');
	$.ajax({
	  type: "POST",
	  url: "post.php",
	  data: { chat_enviar: "1", receptor: iduser, mensaje: mensaje}
	}).done(function( msg ) {
	  //alert( msg );
	});
}

function leer(){

	$.ajax({
	  type: "POST",
	  cache: false,
	  url: "post.php",
	  data: { chat_leer: "1"}
	}).done(function( msg ) {
		$("#tmp").html(msg);

		$("#tmp").find("div").each(function(){
		  	emisor=$(this).attr("emisor");
		  
		  	if($("#chat_conv_"+emisor).css("display")=="none"){
		  		//minimizada
		  		$("#chat_conv_"+emisor+"_min").find(".mensajes").css({"display":"inline-block"});  
		  		$("#chat_conv_"+emisor).find("#mensajes").append("<div class='mensaje'>"+$(this).html()+'</div>');
	  		}else if($("#chat_conv_"+emisor).length>0){
	  			//maximizada
		  		$("#chat_conv_"+emisor).find("#mensajes").append("<div class='mensaje'>"+$(this).html()+'</div>');
	  		}else{
	  			//sin iniciar
		  		chat_init_conv(emisor, "aa");
		  		$("#chat_conv_"+emisor).find("#mensajes").append("<div class='mensaje'>"+$(this).html()+'</div>');
	  			mini(emisor);
	  			$("#chat_conv_"+emisor+"_min").find(".mensajes").css({"display":"inline-block"});
	  		}
		});
	});
}

function cerrar(emisor){
	$("#chat_conv_"+emisor).remove();
}

function mini(emisor){
	$("#chat_conv_"+emisor).hide();
	$("#chat_conv_"+emisor+"_min").css({"display":"inline-block"});
	$("#chat_conv_"+emisor+"_min").find(".mensajes").hide();
}

function max(emisor){
	$("#chat_conv_"+emisor).css({"display":"inline-block"});
	$("#chat_conv_"+emisor+"_min").hide();
}
leer();
timeOutLeer = setInterval(leer, 5000);