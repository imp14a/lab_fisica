
var practice = "";
var intro = "";
var proc = "";
var conclusion = "";
var modal = null;
var elementsChanged = false;

//Unidades de tiempo para el control de la simulación
var unit = 0;
//Variable de intervalo de tiempo
var interval = null;

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
	//Control de intervalo de tiempo
	$('button_start').observe('click', startSimulation);
	$('button_pause').observe('click', stopSimulation);
	$('button_restart').observe('click', restartSimulation);
}

/*
	Muestra la ventana dialogo.
*/

function showModalWindow(sender){
	//TODO: Obtener variables editables	
	//TOOD agregar validaciones a los input
	if (sender.srcElement.className == "properties"){

		var container = new Element('div',{'class':'container'});
		if(isPlayed)
		{
			container.insert({bottom: new Element('div',{'class':'warningModal'}).
				insert({bottom: new Element('label').update("Los cambios se verán reflejados cuando reinicies la actividad")})});
		}
		var editables = getEditablesElements();
		var i=0;
		for(i=0;i<editables.length;i++){
			var prop = editables[i].elements;
			container.insert({bottom:new Element('label',{'class':'elementName'}).update(editables[i].displayName)});
			for(j=0;j<prop.length;j++){
				container.insert({bottom: new Element('div',{class:'input'})
					.insert({bottom: new Element('label').update(prop[j].displayName)})
					.insert({bottom: new Element('input',{name:editables[i].name+'.'+prop[j].name,type:'text',class:'property',value:prop[j].value,placeholder:"0.00"})})
					.insert({bottom: new Element('label').update(prop[j].unity)})});
			}
		}

		modal.setProperties('Propiedades', container,propertiesChange);		
	}
	else if (sender.srcElement.className == "world"){
		//var input 
		var container = new Element('div', {'class': 'container'})
		.insert({
			bottom: new Element('div',{class:'input'})
				.insert({bottom: new Element('label').update("Fuerza de gravedad:")})
				.insert({bottom: new Element('input',{name:'gravity',type:'text',class:'property',placeholder:"9.81"})})
				.insert({bottom: new Element('label').update("(ms/s²)")})
		}).insert({
			bottom: new Element('div',{class:'input'})
				.insert({bottom: new Element('label').update("Densidad del medio:")})
				.insert({bottom: new Element('input',{name:'density',type:'text',class:'property',placeholder:"0.00"})})
				.insert({bottom: new Element('label').update("(kg/m²)")})
		}).insert({
			bottom: new Element('div',{class:'input'})
				.insert({bottom: new Element('label').update("Mostrar ejes")})
				.insert({bottom: new Element('input',{name:'showAxes',type:'checkbox',class:'property'})})
		}).insert({
			bottom: new Element('div',{class:'input'})
				.insert({bottom: new Element('label').update("Mostrar suelo")})
				.insert({bottom: new Element('input',{name:'showGround',type:'checkbox',class:'property'})})
		})
		modal.setProperties('Mundo', container, worldChange);
		modal.setPropertiesValues(worldProperties);
	}
	else if(sender.srcElement.className == "file"){
		var container = new Element('div', {'class': 'container'});
		container.insert({bottom: new Element('label',{'class':'elementName'})}).update("Opciones de archivo");
		//TODO terminarl e modal
	}
	/*else if (sender.srcElement.className == "monitor"){   	
		modal.setProperties('Monitor', 'Agregar variable a inspeccionar.');		
	}
	else if (sender.srcElement.className == "graph"){
		modal.setProperties('Gráfica', 'Mostrar gráfica.');		
	}
	else if (sender.srcElement.className == "script"){   	
		modal.setProperties('Script', 'Mostrar script.');		
	}*/	
	modal.showModal();
}

/*
	Realiza los cambios de propiedades de objetos.
*/
function propertiesChange(){
	properties = modal.getPropertiesValues();
	for(key in properties){
		var name = key.split('.');
		if(name.length>2)
			setValuesForElement(name[0],name[1]+'.'+name[2],properties[key]);
		else
			setValuesForElement(name[0],name[1],properties[key]);
	}
	elementsChanged = true;
	if(!isPlayed){
		useNewProperties();
	}
	modal.hideModal();

}

/*
	Realiza los cambios de propiedades en el mundo.
*/
function worldChange(){

	worldProperties = modal.getPropertiesValues();
	update();
	modal.hideModal();
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