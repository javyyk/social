//Definimos variables globales
var click;
var move;
var x_centrado;
var y_centrado;

function etiqueta_delete(label,value){
	//lo borramos del panel etiquetado
	 $("#lista_etiquetados").find("li").each(function(){
	 	if($(this).text()==label){
	 		$(this).remove();
	 	}
	 });
	 
	/*n = new Array();	//creamos un array temporal
	n = label;	//nombre y apellidos para usar indexOf
	n.label = label;	//nombre y apellidos
	n.value = value;	//id
	lista_amigos.push(n);	//lo añadimos al buscador*/
	
	lista_amigos.push({value: value, label: label});
	
	// buscamos el nombre del amigo seleccionado
	for(i=0;i<lista_etiquetados.length;i++){
		if(lista_etiquetados[i].label==label){
			lista_etiquetados.splice(i, 1); // y lo quitamos del array
			break;
		}
	}
	//alert(JSON.stringify(lista_etiquetados));
}

function post(lista_etiquetados){
	//alert(idfoto);
	string_envio="";
	//alert(JSON.stringify(lista_etiquetados));
	//alert(lista_etiquetados.length);
	for(i=0;i<lista_etiquetados.length;i++){
		string_envio+=lista_etiquetados[i].value+",";
		string_envio+=lista_etiquetados[i].x+",";
		string_envio+=lista_etiquetados[i].y+",";
	}
	string_envio=string_envio.substring(0,string_envio.length-1);
	ajax_post("post.php","foto_etiquetado=1&idfoto="+idfoto+"&etiquetas="+string_envio);
}
function editar_etiquetas(){
	move=1;
	onclick=$("#foto").attr("onclick");	//desactivamos click
	$("#foto").removeAttr("onclick");
	
	$("#foto_marco").mouseenter(function(e){
		metediv();
		$("#foto_marco").mousemove(function(e){
			if(move==1){
				fl=this.offsetLeft;
				fr=this.offsetLeft+parseInt($(this).css("width").match(/[0-9]{1,}/gi)[0]);
				ft=this.offsetTop;
				fb=this.offsetTop+parseInt($(this).css("height").match(/[0-9]{1,}/gi)[0]);
				
				//raton fuera de la foto
				if(e.pageX<fl || e.pageX>fr || e.pageY<ft || e.pageY>fb){
					$("#etiqueta").hide();
				}
				//alert(e.pageX);
				var p = $("#foto").position();
				//$("p:last").text( "left: " + position.left + ", top: " + position.top );
	
				x = e.pageX - this.offsetLeft;
				y = e.pageY - this.offsetTop;
				//xori = x;
				//yori = y;
			}
            h=$("#etiqueta").css("height").match(/[0-9]{1,}/gi)[0]/2;
            w=$("#etiqueta").css("width").match(/[0-9]{1,}/gi)[0]/2;
			y_centrado = y + p.top - h + "px";
			x_centrado = x + p.left - w + "px";
			$("#coors1").text("DIV x: "+x+" y: "+y);
			$("#coors2").text("DIV CENTRADO x: "+x_centrado+" y: "+y_centrado);
			$("#etiqueta").css({"top":y_centrado,"left":x_centrado});
			//$("#coors2").text("( e.clientX, e.clientY ) : " + clientCoords);
		});
		
		$("#etiqueta").click(function(e){
			move=0;
			click=1;
			$("form,form input").show();
			$("form #tags").focus();
		});
		
		$("#foto").click(function(e){ //si click=1 y pincha fuera de la etiqueta desparaliza etiqueta
			if(move==0 && click==1){
				move=1;
				click=0;
				$("form,form input").show();
				$("form #tags").focus();
			}
		});
		
	});
}

function amigo_etiquetado(id){
	//y=$("#etiqueta").css("top");
	//x=$("#etiqueta").css("left");		
	$("#foto_marco").append("<div etiqueta='"+id+"' class='etiquetado' style='left:"+x_centrado+";top:"+y_centrado+";'></div>");
	$("form input").hide();
	$("body").focus();
	move=1;
	click=0;
}
function metediv(){
	if($("#etiqueta").length<1){
		$("#foto_marco").append("<div id='etiqueta'></div>");
       	
	}else if(click!=1){
		move=1;
		$("#etiqueta").show();
	}
}

$(document).ready(function(){
});