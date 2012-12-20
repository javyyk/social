$(document).ready(function(){
	$("div.etiquetado,#lista_etiquetados li").hover(
	  function () {
	  	for ( i = 0; i < lista_etiquetados.length; i++) {
			if (lista_etiquetados[i].value == id) {
				lista_amigos.splice(i, 1);
				// y lo quitamos del array
				break;
			}
		}
	  }, 
	  function () {
	   // TODO:dejar como antes
	  }
	);
	
});