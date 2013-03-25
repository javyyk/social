function ajax_post(url, data, reload, nextUrl, retrieve) {
	$.ajax({
		type : "POST",
		url : url,
		data : data,
		cache : false
	}).always(function(msg) {
		$("#ajax_cargando_padre").remove();
		$("body").append("<div id='ajax_cargando_padre'><div id='ajax_cargando'><img src='imagenes/loading.gif'><div class='texto'>Procesando petici&oacute;n, por favor espere.</div></div></div>");
	}).fail(function(msg) {
		ajax_post_fail();
	}).done(function(msg) {
		if (msg.length == 0) {
			$("#ajax_cargando").addClass("ajax_ok");
			$("#ajax_cargando").html("<img src='imagenes/ok.png'><div class='texto'>Acci&oacute;n completada con &eacute;xito.</div>");
			$("#ajax_cargando_padre").fadeIn(function() {
				setTimeout(function() {
					$("#ajax_cargando").fadeOut("slow");
				}, 1000);
			});
			if (reload ==true) {
				window.setTimeout((function (){window.location.reload();}), 1000);
			}
			if (nextUrl) {
				window.setTimeout((function (){window.location=nextUrl;}), 1000);
			}
		}else if(msg == "ERROR") {
			ajax_post_fail();
		}else if (msg != "ERROR") {
			if(retrieve == true){
				return msg;
			}else{
				ajax_post_fail(msg);
			}
		}
	});
}

function ajax_post_fail(msg) {
	if(msg){
		$("#ajax_cargando").addClass("ajax_fail");
		$("#ajax_cargando").html("<img src='imagenes/advertencia.png'><div class='texto'>Ha ocurrido un error:<br><br>"+msg+"<br><br><a onclick='ajax_post_aceptar()'>Aceptar</a></div>");
	}else{
		$("#ajax_cargando").addClass("ajax_fail");
		$("#ajax_cargando").html("<img src='imagenes/advertencia.png'><div class='texto'>Ha ocurrido un error, int&eacute;ntalo de nuevo o ponte en contacto con nosotros.<br><br><a onclick='ajax_post_aceptar()'>Aceptar</a></div>");
	}
}

function ajax_post_aceptar() {
	$("#ajax_cargando").fadeIn(function() {
		setTimeout(function() {
			$("#ajax_cargando_padre").fadeOut("slow");
		}, 0);
	});
}

function chat_turn(modo) {
	if (modo == "on") {
		ajax_post("post.php", "chat_estado=on");
		location.reload();
	} else {
		ajax_post("post.php", "chat_estado=off");
		location.reload();
	}
}

function chat_toggle() {
	if ($("#chat_contactos").css("display") == "none") {
		$("#chat_contactos").css({
			"display" : "inline-block"
		});
	} else {
		$("#chat_contactos").hide();
	}
}


$(document).ready(function() {
	// Muestra y oculta los menús
	$('#menu-altern ul li:has(ul)').hover(function(e) {
		$(this).find('ul').fadeIn();
	}, function(e) {
		$(this).find('ul').fadeOut();
	});

	// Señala en el menu horizontal la pagina actual
	var url = location.href.match(/[a-z0-9_-]{1,}.php/gi);
	$("#menudrop").find("a").each(function() {
		if ($(this).attr("href") == url) {
			//alert(url);
			$(this).css({
				"color" : "white"
			});
			$(this).parent().css({
				"background-color" : "#3869A0"
			});
		}
	});
}); 