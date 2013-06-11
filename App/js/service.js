
var practice = "";
var intro = "";
var proc = "";
var conclusion = "";
var modal = null;


/*
	getActivityService()

	Obtiene la información de la práctica correspondiente.

*/
Event.observe(window, 'load', getActivityService);

function getActivityService(){
	new Ajax.Request('http://lab_fisica/Service/pages/core/simulator.php', {
		method: 'get',
  		parameters: {controller: 'Activity', action: 'getActivity'},
  		onSuccess: function(transport) {		
  			var json = transport.responseText.evalJSON();
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
		    	//Creamos una ventana modal		 		    	
		    	modal = new Modal();		    	
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
	$('properties').observe('click', showModalWindow);
	$('world').observe('click', showModalWindow);
	$('monitor').observe('click', showModalWindow);
	$('graph').observe('click', showModalWindow);
	$('script').observe('click', showModalWindow);
}

/*
	Muestra la ventana dialogo.
*/
function showModalWindow(sender){
	//TODO: Obtener variables editables	
	if (sender.srcElement.className == "properties"){   	
		modal.setProperties('Propiedades', 'Variables de propiedades.');		
	}
	else if (sender.srcElement.className == "world"){   	
		modal.setProperties('Mundo', 'Variables de mundo.');		
	}
	else if (sender.srcElement.className == "monitor"){   	
		modal.setProperties('Monitor', 'Agregar variable a inspeccionar.');		
	}
	else if (sender.srcElement.className == "graph"){   	
		modal.setProperties('Gráfica', 'Mostrar gráfica.');		
	}
	else if (sender.srcElement.className == "script"){   	
		modal.setProperties('Script', 'Mostrar script.');		
	}	
	modal.showModal();
}

/*
	Realiza los cambios de propiedades en el mundo.
*/
function worldChange(){

}

/*
	Se agregan los tooltips de los elementos.
*/
function setTooltipsElements(){
	new Tagtip('button_start', 'Inicia la simulación de la práctica.', {
		title: 'Iniciar',
		align: 'bottomRight'
	});
	new Tagtip('button_pause', 'Pausa la simulación de la práctica.', {
		title: 'Pausar',
		align: 'bottomRight'
	});
	new Tagtip('button_restart', 'Reinicia la simulación de la práctica.', {
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
	Redimensiona los elementos de acuerdo al tamaño del viewport.
*/
function setDimensionElements(){
	var viewport = document.viewport.getDimensions();
	var width = viewport.width; 
	var height = viewport.height;
	//console.log(height);
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