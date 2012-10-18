<?php
/*
 * llamada a la clase
 * envio de condiciones de multiples campos
 * llamada a generar js donde se quiera
 * llamada a generar php donde se quiera
*/

class Validador{
	
	public $name;
	public $obligatorio;
	public $min;
	public $max;
	public $radio;
	public $semejante;
	public $expr;
	public $formato;
	public $campos = array();

   function __construct() {
   }
   
	function __destruct() {
	}
   
   
    public function setName($name){
		$this->name = $name;
	}
	public function setObligatorio($obligatorio){
		$this->obligatorio = $obligatorio;
	}
	public function setmin($min){
		$this->min = $min;
	}
	public function setmax($max){
		$this->max = $max;
	}
	public function setRadio($radio){
		$this->radio = $radio;
	}
	public function setSemejante($semejante){
		$this->semejante = $semejante;
	}
	public function setExpr($expr){
		$this->expr = $expr;
	}
	public function setFormato($formato){
		$this->formato = $formato;
	}
	
	//Recoge los datos desde el array campos y setea los atributos
	public function SetFromArray($arr){
		//Destruimos los atributos de un campo ya generado
		unset($this->name);
		unset($this->obligatorio);
		unset($this->min);
		unset($this->max);
		unset($this->radio);
		unset($this->semejante);
		unset($this->expr);
		unset($this->formato);
			
		foreach ($arr as $key => $value) {
			switch ($key) {
				case 'name':
					$this->setName($value);
					break;
				case 'obligatorio':
					$this->setObligatorio($value);
					break;
				case 'min':
					$this->setmin($value);
					break;
				case 'max':
					$this->setmax($value);
					break;
				case 'radio':
					$this->setRadio($value);
					break;
				case 'semejante':
					$this->setSemejante($value);
					break;
				case 'expr':
					$this->setExpr($value);
					break;
				case 'formato':
					$this->setFormato($value);
					break;
				default:
					break;
			}
		}
		
	}
	//Recoge los datos
	public function SetInput($arr){
		//almacenamos los datos del campo en un array
		array_push($this->campos, $arr);
	}
	
	//Imprime el codigo validador JavaScript
	public function GeneraValidadorJS(){

		print "
				<script type='text/javascript'>
				var ayuda = {}; /* DECLARAMOS VARIABLE GLOBAL */
				var validado = 0;
				array_campos = new Array();
				
				function validador(option){ /* FUNCION VALIDADOR */
					for(i=0;i<=array_campos.length;i++){ // LIMPIAMOS ARRAY
						array_campos.pop();
					}
					validado = 1;
		";
		/*foreach($this->campos as $t){
			
			$this->SetFromArray($t);
			if($this->campos){
				print "
					
					ayuda_".$this->name.".mensaje = ''
				";
			}else{
				echo "<h3>Debes introducir el nombre del campo</h3>";
			}
		}*/
		//print "function validador(){";
		
		foreach($this->campos as $t){
			
			$this->SetFromArray($t);
			if($this->campos){
				print(
					"ayuda.".$this->name." = {};
					ayuda.".$this->name.".mensaje = '';
					array_campos.push('".$this->name."');
					$(\"input[name='".$this->name."']\").css({'background-color':'green'}); /* RESETEAMOS EL COLOR */\n
				");
				$help_div = "ayuda.".$this->name.".mensaje";
				//print_r($this->campos);
				$campo="if($(\"input[name='".$this->name."']\")";
				$check = array();
				
				//Obligatorio
				if($this->obligatorio){	
					array_push($check,
						$campo.".val().length<1){\n\t\t\t\t\t".
						$help_div." += 'El campo \"".$this->name."\" es obligatorio<br>';
						$(\"input[name='".$this->name."']\").css({'background-color':'red'});
					}\n\n");
				}
				
				//Min
				if($this->min){	
					array_push($check, $campo.".val().length<".$this->min."){\n".
							$help_div." += 'El campo \"".$this->name."\" debe contener al menos ".$this->min." caracteres<br>';\n
							$(\"input[name='".$this->name."']\").css({'background-color':'red'});\n

						}\n");
				}
				
				//Max MEJOR LIMITAR LONGITUD EN HTML
				/*if($this->max){	
					array_push($check, $campo.".val().length>".$this->max."){mensaje+='El campo \"".$this->name."\" debe contener como maximo ".$this->max." caracteres<br/>';}\n");
				}*/
				
				//Radio
				/*if($this->radio){
					unset($radiook);
					foreach (preg_split("/,/", $this->radio) as $key => $value) {
						if(strlen($_POST[$value])){
							$radiook="1";
						}
					}
					if(!$radiook){
						$mensaje.="Debes seleccionar una de las opciones del campo \"".$this->name."\"<br/>";
					}
				}*/
				
				//Semejante
				/*if($this->semejante){
					$semejantes=preg_split("/,/", $this->semejante);
					$semejante_anterior=$_POST[$semejantes[0]];
					foreach ($semejantes as $key => $value) {
						//echo "\$_POST[".$value."]:".$_POST[$value];
						if($_POST[$value]!=$semejante_anterior){
							$semejante_error="1";
						}
						$semejante_anterior=$_POST[$value];
					}
					if($semejante_error){
						$mensaje.="Los campos \"".$this->semejante."\" no coinciden<br/>";
					}
				}*/
				
				//Expr
				/*if($this->expr){	
					array_push($check, $campo.".val().search(/".$this->expr."/g)!=-1){mensaje+='El campo \"".$this->name."\" contiene caracteres invalidos<br/>';}\n");
				}
				
				//Formato
				if($this->formato){	
					array_push($check, $campo.".val().search(/".$this->formato."/g)==-1){mensaje+='El contenido del campo \"".$this->name."\" no tiene un formato valido<br/>';}\n");
				}
				*/
				
				foreach($check as $c){
					echo $c;
				}
				
			}else{
				echo "<h3>Debes introducir el nombre del campo</h3>";
			}
		}
		print "
					if(option == 'submit'){
						//alert(array_campos);
						form_ok = 1;
						for(i=0;i<array_campos.length;i++){
							help_div = eval('ayuda.' + array_campos[i] + '.mensaje'); /* DEPENDIENDO DEL DIV SE USA UNA VARIABLE */
							if(help_div.length > 0){
								form_ok = 0;
							}
						}
						if(form_ok == 1){ //Si no ha errores enviar
							$('#form_login').submit();
						}
					}
				} /* FIN VALIDADOR */		
					$(document).ready(function(){
						if($(\"#help_div\").length<1){/* SI NO EXISTE EL DIV DE AYUDA LO INSERTAMOS */
							$('body').append(\"<div id='help_div' style='display:none;position:absolute;border:1px solid red;padding:4px;background-color:red;'></div>\");
						}
						
						$(\"input\").hover(/* AL PONER CURSOR SOBRE UN INPUT */
							function(){/* MOSTRAR DIV */
								help_div = eval('ayuda.' + $(this).attr('name') + '.mensaje'); /* DEPENDIENDO DEL DIV SE USA UNA VARIABLE */
								if(help_div.length>0){ /* LA VARIABLE NO ESTA VACIA */
									$('#help_div').html(help_div);
									$('#help_div').show();
									help_div =	'';
								}
							},
							function(){/* OCULTAR DIV */
								//if(help_div.length>0){	
									$('#help_div').html(\"\");
									$('#help_div').hide();
								//}
							}
						);
						
						$(\"input\").mouseenter(function() {/* MOVIMIENTO DEL DIV*/
							$(\"input\").mousemove(function(e){
								var x = e.pageX + 15;
								var y = e.pageY - 15;
							   								  
								$('#help_div').css({'left':x,'top':y});
							});	
						});
						
						$('input').keyup(function(event) {
							if(validado == 1){
								validador();
								help_div = eval('ayuda.' + $(this).attr('name') + '.mensaje'); /* DEPENDIENDO DEL DIV SE USA UNA VARIABLE */
								if(help_div.length<1){
									$('#help_div').html(\"\");
									$('#help_div').hide();
								}else{
									$('#help_div').html(help_div);
									$('#help_div').show();
								}
							}
							/*if (event.which == 13) {
								event.preventDefault();
							}*/
						});

					});
			</script>
			";
			
			
			/*$('#mensaje').html(mensaje);
					if(mensaje==''){
						$('#form').submit();
					}
				mensaje='';
				*/
			
	}
	
	
	//Genera el codigo validador PHP
	public function GeneraValidadorPHP(){
		foreach($this->campos as $t){
			
			$this->SetFromArray($t);
			
			if($this->campos){
				if(!$mensaje){
					$mensaje="";
				}
				$campo=$_POST[$this->name];
				//print($campo);
				//print_r($t);
				//print(strlen($campo)."<br>");
				$mensaje.="<br><b>".$this->name.": ".$campo."</b><br>";
				
				//Obligatorio
				if($this->obligatorio){
					if(strlen($campo)<1){
						$mensaje.="El campo \"".$this->name."\" es obligatorio<br/>";
					}
					
				}
				
				//Min
				if($this->min){	
					if(strlen($campo)<$this->min){
						$mensaje.="El campo \"".$this->name."\" debe contener al menos ".$this->min." caracteres<br/>";
					}
				}
				
				//Max
				if($this->max){	
					if(strlen($campo)>$this->max){
						$mensaje.="El campo \"".$this->name."\" debe contener como maximo ".$this->max." caracteres<br/>";
					}
				}
				
				//Radio
				if($this->radio){
					unset($radiook);
					foreach (preg_split("/,/", $this->radio) as $key => $value) {
						if(strlen($_POST[$value])){
							$radiook="1";
						}
					}
					if(!$radiook){
						$mensaje.="Debes seleccionar una de las opciones del campo \"".$this->name."\"<br/>";
					}
				}
				
				//Semejante
				if($this->semejante){
					$semejantes=preg_split("/,/", $this->semejante);
					$semejante_anterior=$_POST[$semejantes[0]];
					foreach ($semejantes as $key => $value) {
						//echo "\$_POST[".$value."]:".$_POST[$value];
						if($_POST[$value]!=$semejante_anterior){
							$semejante_error="1";
						}
						$semejante_anterior=$_POST[$value];
					}
					if($semejante_error){
						$mensaje.="Los campos \"".$this->semejante."\" no coinciden<br/>";
					}
				}
				
				//Expr
				if($this->expr){	
					if(preg_match($this->expr, $campo)==0){
						$mensaje.="El campo \"".$this->name."\" contiene caracteres invalidos<br/>";
					}
				}
				//Formato
				if($this->formato){	
					if(!preg_match('/'.$this->formato.'/i', $campo)){
						$mensaje.="El contenido del campo \"".$this->name."\" no tiene un formato valido<br/>";
					}
				}
				
			}else{
				echo "<h3>Debes introducir el nombre del campo</h3>";
			}
			
		}

		if(strlen($mensaje)>0){
			//echo(""<h3>CODIGO VALIDADOR PHP----></h3>"".$mensaje."<h3><---CODIGO VALIDADOR PHP</h3>");
			echo "El validador PHP no esta de acuerdo.";
		}
	}
}
?>