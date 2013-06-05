
var practice = "";
var intro = "";
var proc = "";
var conclusion = "";

/*
	accessService()

	Realiza una llamada al servicio de acceso y determina 
	si se trata de un acceso lícito o no.
*/

Event.observe(window, 'load', accessService);

function accessService() {	
	var data = new String(window.location);
	data = data.substring(data.indexOf("=") + 1, data.length);
	
	new Ajax.Request('http://lab_fisica/Service/pages/core/simulator.php', {
  		method: 'get',
  		parameters: {data: data},
  		onSuccess: function(transport) {  	  			
  			var json = transport.responseText.substring(transport.responseText.indexOf("{"), transport.responseText.length).evalJSON();  		   			  			  			  			
		    if(json.access){		    			    			    			    			    	
		    	getActivityService();
		    }else{		    	
		    	window.location = "access_denied.html";				
		   	}
		},
  		onFailure: function() { 
  			alert('Intente en otro momento...'); 
  		}
	});
}


/*
	getActivityService()

	Obtiene la información de la práctica correspondiente.

*/
function getActivityService()
{
	new Ajax.Request('http://lab_fisica/Service/pages/core/simulator.php', {
		method: 'get',
  		parameters: {controller: 'Activity', action: 'getActivity'},
  		onSuccess: function(transport) {		      			
  			var json = transport.responseText.substring(transport.responseText.indexOf("{"), transport.responseText.length).evalJSON();  		   			  			  			  			  			
		    if(json.error){		    			    			    			    			    	
		    	alert('Ocurrió un error mientras se cargaba la información de la práctica. Intente de nuevo.'); 
		    }else{
		    	practice = json.title;
		    	intro = json.description;
		    	proc = json.steps;
		    	conclusion = json.observations;
		    	//console.log(json);	
		    	//Primer actualización
		    	$('activity_title').update(practice);
		    	$('title').update("INTRODUCCIÓN"); 
		    	$('info').update(intro);
		    	$('info').innerHTML;
		    		
		    	setEventsElements();		    			    	
		    	setTooltipsElements();		    	
		    			    	
		    }
		},
  		onFailure: function() { 
  			alert('Intente en otro momento...'); 
  		}
	});
}

/*	
	Función que establece el texto que se muestra en el área de información.
*/
function setDescriptionElement(sender){
	console.log(sender.srcElement.className);
	
	if (sender.srcElement.className == "intro"){
		$('title').update("INTRODUCCIÓN");
		$('info').update(intro);		
	}
	else if (sender.srcElement.className == "proc"){
		$('title').update("PROCEDIMIENTO");
		$('info').update(proc);			
	}
	else if (sender.srcElement.className == "conclusion"){
		$('title').update("OBSERVACIONES");
		$('info').update(conclusion);		
	}
}

/*
	Se agregan los eventos de los botones.
*/
function setEventsElements(){
	$('intro').observe('click', setDescriptionElement);
	$('proc').observe('click', setDescriptionElement);
	$('conclusion').observe('click', setDescriptionElement);		    	
	//TODO: Incluir todos los eventos para cada elemento.
}

/*
	Se agregan los tooltips de los elementos.
*/
function setTooltipsElements(){
	new Tagtip('start', 'Inicia la simulación de la práctica.', {
		title: 'Iniciar',
		align: 'bottomRight'
	});
	new Tagtip('pause', 'Pausa la simulación de la práctica.', {
		title: 'Pausar',
		align: 'bottomRight'
	});
	new Tagtip('restart', 'Reinicia la simulación de la práctica.', {
		title: 'Reiniciar',
		align: 'bottomRight'
	});

	new Tagtip('proc', 'Muesta el procedimiento de la práctica.', {
		title: 'Procedimiento',
		align: 'bottomLeft'
	});
	new Tagtip('intro', 'Muesta la introducción de la práctica.', {
		title: 'Introducción',
		align: 'bottomLeft'
	});
	new Tagtip('conclusion', 'Muesta las observaciones de la práctica.', {
		title: 'Observaciones',
		align: 'bottomLeft'
	});
	new Tagtip('print', 'Muesta las opciones para imprimir la práctica.', {
		title: 'Imprimir',
		align: 'bottomLeft'
	});
}
