	function estado_online(){
		$.ajax({
		  type: "POST",
		  url: "post.php",
		  data: { estado_online: "1" }
		}).done(function( msg ) {
		  //alert( "Data Saved: " + msg );*/
		});
	}
	function leer(){
		id=$("div.msg:last").attr("id");
		alert(id);
		if(id==undefined){
			id=0;
		}
		$.ajax({
		  type: "POST",
		  async: "false",
		  url: "bd.php",
		  cache: false,
		  data: { leer: "1", id: id }
		}).done(function( msg ) {
		  //alert( "Data Saved: " + msg );
		  $("#chat").prepend(msg);
		});
	}
	timeOutId = setInterval(estado_online, 30000);
	estado_online();
