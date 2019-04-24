
			$(document).ready(function(){
				comeca();
			})
			var timerI = null;
			var timerR = false;

			function para(){
    			if(timerR)
        			clearTimeout(timerI)
    			timerR = false;
			}
			function comeca(){
    			para();
    			lista();
			}
			function lista(){
				$.ajax({
					url:"../atualizaListaAjax.php",
   					success: function (textStatus){
 						$('#lista').html(textStatus); //mostrando resultado
 					}
 				})
 				timerI = setTimeout("lista()", 20);//tempo de espera
    			        timerR = true;

			}
