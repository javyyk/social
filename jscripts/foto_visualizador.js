
	function amigos_actualizar(){
		$("#lista_etiquetados li").each(function(){
			//alert($(this).attr('onclick').match(/'[0-9]{1,}'/gim)[0]);
			id=$(this).attr('onclick').match(/'[0-9]{1,}'/gim)[0].match(/[0-9]{1,}/gim)[0];
			//alert(id);
			// buscamos el nombre del amigo seleccionado
			for(i=0;i<lista_amigos.length;i++){
				if(lista_amigos[i].value==id){
					lista_amigos.splice(i, 1); // y lo quitamos del array
					break;
				}
			}
		});
	}
	
	$(document).ready(function(){
	$("div.etiquetado,#lista_etiquetados li").hover(
	  function () {
	   // TODO:Resaltar ettuiqueta actual
	  // alert("OK");
	  }, 
	  function () {
	   // TODO:dejar como antes
	  }
	);
	
});