/*$(document).ready(function(){
	$("div").each(function(){
		numP = 999999;
		rnd = Math.random() * numP;
		color = Math.round(rnd);
		$(this).css({"border":"3px solid #"+ color});
	});
});*/


$(document).ready(function() {
// Muestra y oculta los menús
$('#menu-altern ul li:has(ul)').hover( //función al pasar el ratón por encima de un "li" que tiene una "ul"
function(e) //Primera función-->ratón por encima
{
$(this).find('ul').fadeIn();
},
function(e) //Cuando el ratón deja de estar encima.
{
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

