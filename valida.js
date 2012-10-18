$(document).ready(function() {
	
	$('input').keypress(function(e) {
        if(e.which == 13) {
        	validador();
        }
    });
	function validar(){
		
	
	}
	$("input").blur(function(){
			
			$(this).css({'background-color':'red',});
	});
});