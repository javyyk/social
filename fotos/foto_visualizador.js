$(document).ready(function(){
	$("#lista_etiquetados li").hover(
	  function () {
		etiqueta_id = $(this).attr("class").match(/etiqueta_[0-9]{1,}/gim)[0];
		$("#lista_etiquetados li."+etiqueta_id).addClass("etiqueta_seleccionada");
		$("#foto_marco div."+etiqueta_id).addClass("etiqueta_seleccionada");
	  }, 
	  function () {
		etiqueta_id = $(this).attr("class").match(/etiqueta_[0-9]{1,}/gim)[0];
		$("#lista_etiquetados li."+etiqueta_id).removeClass("etiqueta_seleccionada");
		$("#foto_marco div."+etiqueta_id).removeClass("etiqueta_seleccionada");
	  }
	);
	//div.etiquetado
});