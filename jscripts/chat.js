/////////////////////	CHAT FUNCTIONS	////////////////////
$(document).ready(function(){
	/*if(location.href.search(/(login.php|registro.php)/gi)!=-1){
		return;
	}*/
	/*$("body").append("<div id='chat'></div>");
	$("#chat").append("<div id='chat_boton'></div>");
	$("#chat").append("<div id='chat_conv_tmp' style='display:none;'></div>");*/
	
	timeOutId = setInterval(estado_online, 30000);
	estado_online();
	
	leer();
	timeOutLeer = setInterval(leer, 5000);
	
	chat_contactos();
	timeOutchat_contactos = setInterval(chat_contactos, 10000);
	
	
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

function chat_contactos(){
	$.ajax({
	  type: "POST",
	  url: "post.php",
	  data: { chat_contactos: "1" }
	}).done(function( msg ) {
		$("#chat_contactos").html(msg);
	});
}

function chat_init_conv(iduser, nombre, img){
	if($("#chat_conv_"+iduser).length<1){
		$("#chat").append(
			"<div id='chat_conv_"+iduser+"_min' class='chat_ventana_min' onclick=\"max('"+iduser+"')\">"+
				"<img src='"+img+"' alt='"+nombre+"'/>"+
				"<div class='mensajes'></div>"+
			"</div>"+
			"<div id='chat_conv_"+iduser+"' class='chat_ventana' iduser='"+iduser+"'>"+nombre+
				"<div class='boton cerr' onclick=\"cerrar('"+iduser+"')\"></div>"+
				"<div class='boton max'></div>"+
				"<div class='boton mini' onclick=\"mini('"+iduser+"')\"></div>"+
				"<div id='mensajes'></div>"+
				"<textarea name='mensaje' onkeypress=\"chat_press_enter(event,this,'"+iduser+"')\" /></textarea>"+
				"<button type='button' onclick=\"enviar('"+iduser+"')\">Enviar</button>"+
			"</div>");
	}
	chat_toggle();
}

function chat_press_enter(e,t,iduser) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){  	enviar(iduser);  }
}
function enviar(iduser){
	mensaje = $("#chat_conv_"+iduser).find("textarea").val();
	if(mensaje.length==0) return false;
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
		$("#chat_conv_tmp").html(msg);

		$("#chat_conv_tmp").find("div").each(function(){
		  	emisor=$(this).attr("iduser");
		  	nombre=$(this).attr("nombre");
		  	img=$(this).attr("img");
		  
		  	if($("#chat_conv_"+emisor).css("display")=="none"){
		  		//minimizada
		  		$("#chat_conv_"+emisor+"_min").find(".mensajes").css({"display":"inline-block"});  
		  		$("#chat_conv_"+emisor).find("#mensajes").append("<div class='mensaje'>"+$(this).html()+'</div>');
	  		}else if($("#chat_conv_"+emisor).length>0){
	  			//maximizada
		  		$("#chat_conv_"+emisor).find("#mensajes").append("<div class='mensaje'>"+$(this).html()+'</div>');
	  		}else{
	  			//sin iniciar
		  		chat_init_conv(emisor,nombre,img);
				chat_toggle(); //minimizar lista contactos
		  		$("#chat_conv_"+emisor).find("#mensajes").append("<div class='mensaje'>"+$(this).html()+'</div>');
	  			mini(emisor); //minimizar conversa
	  			$("#chat_conv_"+emisor+"_min").find(".mensajes").css({"display":"inline-block"}); //mostrar simbolo mensajes
	  		}
	  		//$("#chat_conv_"+emisor).find("#mensajes").scrollTop($("#chat_conv_"+emisor).find("#mensajes").prop("scrollHeight"))
			$("#chat_conv_"+emisor).find("#mensajes").animate({ scrollTop: $("#chat_conv_"+emisor).find("#mensajes").prop("scrollHeight")},3000);
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