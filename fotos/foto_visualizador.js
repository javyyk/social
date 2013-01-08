$(document).ready(function(){
	$("#lista_etiquetados li,#foto_marco div.etiquetado").hover(
	  function () {
		etiqueta_id = $(this).attr("class").match(/etiqueta_[0-9]{1,}/gim)[0];
		$("#lista_etiquetados li."+etiqueta_id).addClass("etiqueta_seleccionada");
		$("#foto_marco div."+etiqueta_id).addClass("etiqueta_seleccionada");
		
		width = $("#foto_marco div."+etiqueta_id+" div.etiqueta_nombre").innerWidth()/2-15;
		$("#foto_marco div."+etiqueta_id+" div.etiqueta_nombre").css({"visibility":"visible","right": width});
	},
	  function () {
		etiqueta_id = $(this).attr("class").match(/etiqueta_[0-9]{1,}/gim)[0];
		$("#lista_etiquetados li."+etiqueta_id).removeClass("etiqueta_seleccionada");
		$("#foto_marco div."+etiqueta_id).removeClass("etiqueta_seleccionada");
		
		$("#foto_marco div."+etiqueta_id+" div.etiqueta_nombre").css({"visibility":"hidden"});
	  }
	);
	//div.etiquetado
});