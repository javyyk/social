function ajax_post(url,data){
	$.ajax({
	  type: "POST",
	  url: url,
	  data: data
	}).done(function( msg ) {
	  alert( msg );
	});
}

function chat_turn(modo){
	if(modo=="on"){
		ajax_post("post.php","chat_estado=on");
		location.reload();
	}else{
		ajax_post("post.php","chat_estado=off");
		location.reload();
	}
}

$(document).ready(function() {
	// Muestra y oculta los menús
	$('#menu-altern ul li:has(ul)').hover(
		function(e){
			$(this).find('ul').fadeIn();
		},
		function(e){
			$(this).find('ul').fadeOut();
		}
	);


	// Señala en el menu horizontal la pagina actual
	var url = location.href.match(/[a-z0-9_-]{1,}.php/gi);
	$("#menudrop").find("a").each(function(){
		if($(this).attr("href") == url){
			//alert(url);
			$(this).css({"color":"white"});
			$(this).parent().css({"background-color":"#3869A0"});
		}
	});
});