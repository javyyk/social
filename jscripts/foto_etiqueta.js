
function editar_etiquetas(){
	move=1;
	//desactivamos click
	onclick=$("#foto").attr("onclick");
	$("#foto").removeAttr("onclick");
	
	$("#foto_marco").mouseenter(function(e){
		metediv();
		$("#foto_marco").mousemove(function(e){
			if(move!=1) return false;
			var p = $("#foto").position();
			//$("p:last").text( "left: " + position.left + ", top: " + position.top );

			var x = e.pageX - this.offsetLeft;
			var y = e.pageY - this.offsetTop;
			$("#coors1").text("x: "+x+" y: "+y);
            	h=$("#etiqueta").css("height").match(/[0-9]{1,}/gi)[0]/2;
            	w=$("#etiqueta").css("width").match(/[0-9]{1,}/gi)[0]/2;
			var y = y + p.top - h;
			var x = x + p.left - w;
			$("#etiqueta").css({"top":y,"left":x});
			$("#coors2").text("x: "+x+" y: "+y);
			//$("#coors2").text("( e.clientX, e.clientY ) : " + clientCoords);
		});
		$("#etiqueta").click(function(e){
			move=0;
			$("form").show();
			$("form #tags").focus();
		});
		
	});
		
		
	$("#foto").click(function(e){

	});
	//$("#foto,#etiqueta").mouseenter(function(){
		/*$("#foto").mousemove(function(e){
			var p = $("#foto").position();
			//$("p:last").text( "left: " + position.left + ", top: " + position.top );

			var x = e.pageX - this.offsetLeft;
			var y = e.pageY - this.offsetTop;
			$("#coors1").text("x: "+x+" y: "+y);
			var y = y + p.top;
			var x = x + p.left;
			$("#etiqueta").css({"top":y,"left":x});
			$("#coors2").text("x: "+x+" y: "+y);
			//$("#coors2").text("( e.clientX, e.clientY ) : " + clientCoords);
		//});
	});*/
}
function metediv(){
	if($("#etiqueta").length<1){
		$("#foto_marco").append("<div id='etiqueta'></div>");
	/*	var p = $("#foto").position();
			//$("p:last").text( "left: " + position.left + ", top: " + position.top );

			var x = e.pageX - this.offsetLeft;
			var y = e.pageY - this.offsetTop;
			$("#coors1").text("x: "+x+" y: "+y);
			var y = -25 + y + p.top;
			var x = -25 + x + p.left;
			$("#etiqueta").css({"top":y,"left":x});
			$("#coors2").text("x: "+x+" y: "+y);*/
       	$("#etiqueta").draggable({ cursor: "crosshair", cursorAt: { top: 25, left: 25 }});
        $( "#etiqueta" ).resizable({
            aspectRatio: 1/1,
             maxHeight: 200,
            maxWidth: 200,
            minHeight: 50,
            minWidth: 50, 
            stop: function() {
            	h=$("#etiqueta").css("height").match(/[0-9]{1,}/gi)[0]/2;
            	w=$("#etiqueta").css("width").match(/[0-9]{1,}/gi)[0]/2;
				$( "#etiqueta" ).draggable( "option", "cursorAt", { top: h, left: w} );
            }
        });
	}
}
$(document).ready(function(){
});