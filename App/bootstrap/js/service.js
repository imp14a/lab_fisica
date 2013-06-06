
var practice = "";
var intro = "";
var proc = "";
var conclusion = "";

/*
	accessService()

	Realiza una llamada al servicio de acceso y determina 
	si se trata de un acceso lícito o no.
*/

Event.observe(window, 'resize', setDimensionElements);

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
  			alert('Ocurrió un error al validar el acceso.'); 
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
		    	//Redimencionamos los elementos.
		    	setDimensionElements();		    	
		    	//Agregamos los eventos		    			    		
		    	setEventsElements();	
		    	//Asignamos los tooltips	    			    	
		    	setTooltipsElements();		    	
		    			    	
		    }
		},
  		onFailure: function() { 
  			alert('El servidor de base de datos no está disponible.'); 
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

	new Tagtip('properties', 'Ajuste las propiedades a los elementos de la práctica.', {
		title: 'Propiedades',
		align: 'bottomRight'
	});
	new Tagtip('world', 'Ajuste las propiedades del mundo donde se realiza la práctica.', {
		title: 'Mundo',
		align: 'bottomRight'
	});
	new Tagtip('monitor', 'Observe una propiedad específica de un elemento.', {
		title: 'Monitor',
		align: 'bottomRight'
	});
	new Tagtip('graph', 'Visualice el estado actual de la práctica.', {
		title: 'Gráfica',
		align: 'bottomRight'
	});
	new Tagtip('camera', 'Defina el zoom que desea ver en la práctica.', {
		title: 'Cámara',
		align: 'bottomRight'
	});
	new Tagtip('script', 'Modifique la estructura básica de la práctica.', {
		title: 'Script',
		align: 'bottomRight'
	});
}

/*

*/
function setDimensionElements(){
	var viewport = document.viewport.getDimensions();
	var width = viewport.width; 
	var height = viewport.height;
	console.log(height);
	//console.log(width);
	//alert(height);
	$('content').setStyle({'height': (height - ($('header').getHeight() + $('footer').getHeight())) + 'px'});
	$('simulator').setStyle({'height': (height - ($('header').getHeight() + $('footer').getHeight())) + 'px'});
	$('service_simulator').setStyle({'height': ($('simulator').getHeight() - 100) + 'px'});
	$('service_simulator').setStyle({'width': (width - ($('navigation').getWidth() + $('vtoolbar').getWidth()) -80) + 'px'});
	//Primer actualización de contenido de información
	$('activity_title').update(practice);
	$('title').update("INTRODUCCIÓN"); 
	$('info').update(intro);
}