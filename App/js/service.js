
var practice = "";
var intro = "";
var objetive = "";
var proc = "";
var conclusion = "";
var modal = null;
var elementsChanged = false;

//Unidades de tiempo para el control de la simulación
var unit = 0;
//Variable de intervalo de tiempo
var interval = null;
// Variable para monitorear
var watch_variable = null;

var xmlCodeMirror = null;

var urlBase = 'http://wowinteractive.com.mx/lab_fisica/';
/*
	getActivityService()

	Obtiene la información de la práctica correspondiente.

*/
Event.observe(window, 'load', getActivityService);

function getActivityService(){
	adjustWindow();
	new Ajax.Request(urlBase + 'Service/pages/core/simulator.php', {
		method: 'get',
  		parameters: {controller: 'Activity', action: 'getActivity'},
  		onSuccess: function(transport) {		
  			var json = transport.responseText.evalJSON();
		    if(json.error){		    			    			    			    			    	
		    	alert('Ocurrió un error mientras se cargaba la información de la práctica. Intente de nuevo.'); 
		    }else{
		    	practice = json.title;
		    	intro = json.description;
		    	objetive = json.objetive;
		    	proc = json.steps;
		    	conclusion = json.observations;

		    	$('activityTitle').update(practice);

		    	$$('.title').each(function(element){
		    		element.update("INTRODUCCIÓN");
		    	}); 
		    	$$('.text_navigation').each(function(element){
		    		element.update(intro);
		    	});
		    	function desapear(element){
	    			$(element).hide();
	    		}
	    		$$('.title.subtitle').each(desapear);
	    		$$('.text_navigation.objetive_text').each(desapear);
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


var oldSender = null;

/*	
 *	Función que establece el texto que se muestra en el área de información.
 */
function setDescriptionElement(event){	
	var element = Event.element(event);
	if(smallWindowActive){
		$('navigation_dialog').show();
		if(element==oldSender){
			$('navigation_dialog').hide();
			oldSender = null;
		}else{
			oldSender = element;
		}
	}
	function desapear(element){
		$(element).hide();
	}
	$$('.title.subtitle').each(desapear);
	$$('.text_navigation.objetive_text').each(desapear);

	if (element.hasClassName("intro")){
		$$('.title').each(function(element){
    		element.update("INTRODUCCIÓN");
    	}); 
    	$$('.text_navigation').each(function(element){
    		element.update(intro);
    	});
	}
	else if (element.hasClassName("proc")){
		function showObjetive(element){
			$(element).show();
			if($(element).hasClassName('subtitle')){
				$(element).update("OBJETIVO");
			}
			if($(element).hasClassName('objetive_text')){
				$(element).update(objetive);
			}
		}
		$$('.title').each(function(element){
    		element.update("PROCEDIMIENTO");
    	}); 
    	$$('.text_navigation').each(function(element){
    		element.update(proc);
    	});
    	$$('.title.subtitle').each(showObjetive);
    	$$('.text_navigation.objetive_text').each(showObjetive);
	}
	else if (element.hasClassName("conclusion")){
		$$('.title').each(function(element){
    		element.update("OBSERVACIONES");
    	}); 
    	$$('.text_navigation').each(function(element){
    		element.update(conclusion);
    	});
	}
}

/*
	Se agregan los eventos de los botones.
*/
function setEventsElements(){
	$('intro').observe('click', setDescriptionElement);
	$('proc').observe('click', setDescriptionElement);
	$('conclusion').observe('click', setDescriptionElement);
	$('print').observe('click', printActivity);
	//TODO: Incluir todos los eventos para cada elemento.
	$('open').observe('click',showModalWindow);
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
	
	var element = Event.element(sender);
	
	if (element.hasClassName("properties")){

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
					.insert({bottom: new Element('input',{name:editables[i].name+'.'+prop[j].name,type:'text',class:'property number',value:prop[j].value,placeholder:"0.00"})})
					.insert({bottom: new Element('label').update(prop[j].unity)})});
			}
		}

		modal.setProperties('Propiedades', container,propertiesChange);
		modal.setBounds('300px','auto','30%','40%');
	}
	else if (element.hasClassName("world")){
		//var input 
		var container = new Element('div', {'class': 'container'})
		.insert({
			bottom: new Element('div',{class:'input'})
				.insert({bottom: new Element('label').update("Fuerza de gravedad:")})
				.insert({bottom: new Element('select',{name:'gravity',id:'gravity', class:'property'})
					.insert({bottom: new Element('option',{value:'2.78'}).update("Mercurio (-2.78)")})
					.insert({bottom: new Element('option',{value:'8.87'}).update("Venus (-8.87)")})
					.insert({bottom: new Element('option',{value:'9.81',selected:'selected'}).update("Tierra (-9.81)")})
					.insert({bottom: new Element('option',{value:'1.62'}).update("Luna (-1.62)")})
					.insert({bottom: new Element('option',{value:'3.72'}).update("Marte (-3.71)")})
					.insert({bottom: new Element('option',{value:'23.12'}).update("Jupiter (-23.12)")})
					.insert({bottom: new Element('option',{value:'9.05'}).update("Saturno (-9.05)")})
					.insert({bottom: new Element('option',{value:'8.69'}).update("Urano (-8.69)")})
					.insert({bottom: new Element('option',{value:'11.0'}).update("Neptuno (-11.00)")})
					.insert({bottom: new Element('option',{value:'0.4'}).update("Plutón (-0.40)")})
				})
				.insert({bottom: new Element('label').update("(ms/s²)")})
		}).insert({
			bottom: new Element('div',{class:'input'})
				.insert({bottom: new Element('label').update("Densidad del medio:")})
				.insert({bottom: new Element('input',{name:'density',id:'density', type:'text',class:'property number',placeholder:"0.00"})})
				.insert({bottom: new Element('label').update("(kg/m²)")})
		}).insert({
			bottom: new Element('div',{class:'input'})
				.insert({bottom: new Element('label').update("Mostrar ejes")})
				.insert({bottom: new Element('input',{name:'showAxes',id:'showAxes',type:'checkbox',class:'property'})})
		}).insert({
			bottom: new Element('div',{class:'input'})
				.insert({bottom: new Element('label').update("Mostrar suelo")})
				.insert({bottom: new Element('input',{name:'showGround',id:'showGround',type:'checkbox',class:'property'})})
		});
		modal.setBounds('300px','auto','30%','40%');
		modal.setProperties('Mundo', container, worldChange);
		modal.setPropertiesValues(worldProperties);
	}
	else if (element.hasClassName("monitor")){ 
		var container = new Element('div',{'class':'container'});
		var watchables = getWatchVariables();
		var i=0;
		for(i=0;i<watchables.length;i++){
			var prop = watchables[i].elements;
			container.insert({bottom:new Element('label',{'class':'elementName'}).update(watchables[i].displayName)});
			for(j=0;j<prop.length;j++){
				container.insert({bottom: new Element('div',{class:'input'})
					.insert({bottom: new Element('input',{name:"watchables",
												value:prop[j].function,
												type:'radio',class:'property',
												tag:prop[j].displayName,
												isVector:prop[j].isVector})})
					.insert({bottom: new Element('label').update(prop[j].displayName)})});
			}
		}
		modal.setBounds('300px','auto','30%','40%');
		modal.setProperties('Monitor', container, monitorChange);		
	}
	else if (element.hasClassName("graph")){
		if(watch_variable){
			var graph_view = new Element('div', {'id': 'graph_container'})
				.insert({bottom: new Element('label', {'id': 'graph_title'}).update(watch_variable.tag)})
				.insert({bottom: new Element('div', {'id': 'graph_view'})});
		}else{
			var graph_view = new Element('div', {'class': 'container'});			
			graph_view.insert({bottom: new Element('label').update("No se tiene asignada una variable para graficar.")});
		}
		modal.setBounds('800px','550px','5%','35%');
		modal.setProperties('Gráfica', graph_view);	
	}
	else if (element.hasClassName("script")){
		new Ajax.Request(urlBase + 'Service/pages/core/simulator.php', {
			method: 'get',
			parameters: {controller: 'File', action: 'createXMLDocument'},
			onSuccess: function(transport) {
				var container = new Element('div', {'class': 'container',});
				var textarea = new Element('textarea',{'id':'xml_textarea'});
				textarea.value = transport.responseText;
				container.insert({
					bottom:textarea
				});
				xmlCodeMirror = CodeMirror.fromTextArea(textarea,{
					alignCDATA:true,
					mode:  "xml",
					alignCDATA: true
				});

				btn_save = new Element('a',{'class':'btn_save'});
				btn_save.observe('click', saveXMLDocument);
				modal.addToolbarButton({top:btn_save});
				modal.setBounds('80%','80%','5%','10%');
				function xmlShowDone(){
					modal.hideModal();
					modal.removeToolbarButton('.btn_save');
					modal.setBounds('300px','auto','30%','40%');
				}
				modal.setProperties('Script',container,xmlShowDone,xmlShowDone);
				xmlCodeMirror.setSize('auto','90%');
				xmlCodeMirror.refresh();
			}
		});		
	}else if(element.hasClassName("open")){
		var container = new Element('div',{'class':'container'});
		if(isPlayed){
			container.insert({bottom: new Element('div',{'class':'warningModal'}).
				insert({bottom: new Element('label').update("Los cambios se verán reflejados cuando reinicies la actividad")})});
		}

		container.insert({bottom: new Element('label',{'class':'elementName'})}).update("Abrir archivo de practica.");
		form = new Element('form',{id:'uploadFileForm',target:'fileiFrame',method:'post',
				action: urlBase + "Service/pages/core/simulator.php?controller=File&action=uploadFile",
				enctype:"multipart/form-data"});
		form.insert({
			bottom: new Element('input',{type:'file',id:'file',name:'file'})
		}).insert({
			bottom: new Element('iframe',{id:'fileiFrame',name:'fileiFrame',style:"width:0; height:0;",onload:'xmlUploaded("fileiFrame")',src:''})
		});

		container.insert({
			bottom: form
		});

		function sendForm(){
			document.forms["uploadFileForm"].submit();
			//form.submit();
		}

		modal.setProperties('Abrir practica',container,sendForm);	
	}
	bindInputs(modal.container);
	modal.showModal();
}

name="adasda";

/*
	Carga la informacion generada al subir el archivo
*/
function xmlUploaded(name){
	var frame = getFrameByName(name);
    if (frame) {
        ret = frame.document.getElementsByTagName("body")[0].innerHTML;
        if (ret.length) {
        	
        	try{
        		var jsonResponse = eval("("+ret+")");

        	}catch(error){
        		alert('Error al cargar el archivo.');
        		return;
        	}
            if(typeof jsonResponse == 'undefined'){
                alert('Error al cargar el archivo.');
                return;
            }
            if(typeof jsonResponse.error != 'undefined'){
                alert(jsonResponse.error);
            }else{
            	worldProperties = jsonResponse.WorldProperties
            	//Elements properties
            	$(jsonResponse.WorldElements).each(function(element){
            		$(Object.keys(element)).each(function(key){

            			if(key!='name')
            				setValuesForElement(element.name,key,element[key]);
            		});
            	});

            	intro = jsonResponse.ActivityInfo.Description;
            	proc = jsonResponse.ActivityInfo.Process;
            	conclusion = jsonResponse.ActivityInfo.Observations;
            	objetive = jsonResponse.ActivityInfo.Objetive;

            	elementsChanged = true;
            	if(!isPlayed){
            		useNewProperties();
            	}
            	$('intro').click();
            	modal.hideModal();
            }
        }
    }
}

/*
	Auxiliar function 
*/
function getFrameByName(name) {
    for (var i = 0; i < frames.length; i++)
        if (frames[i].name == name)
            return frames[i];
    return null;
}

/*
	Guarda el archivo XML editado
*/
function saveXMLDocument(){

	var form = new Element('form',{method:'post','action': urlBase+"Service/pages/core/simulator.php?controller=File&action=downloadXMLFile"});
	form.insert({bottom:new Element('input',{id:'xml',name:'xml','type':'hidden',value:xmlCodeMirror.getValue()})});
	form.submit();
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
	Establece la variable a monitorear.
*/
function monitorChange(){
	watch_variable = modal.getWatchVariable();
	modal.hideModal(); 
	//Iniciar a monitorear
	setWatchInterval();
}

/*
	Realiza los cambios de propiedades en el mundo.
*/
function worldChange(){
	wp = modal.getPropertiesValues();
	worldProperties.gravity = parseFloat(wp.gravity, 10);
	worldProperties.density = parseFloat(wp.density, 10);
	worldProperties.showGround = wp.showGround!=null;
	worldProperties.showAxes = wp.showAxes !=null;
	modal.hideModal();
	rebuildWorld();
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
	new Tagtip('script', 'Modifique la estructura básica de la práctica.', {
		title: 'Script',
		align: 'bottomRight'
	});
}

function printActivity(){
	
	var form = new Element('form',{method:'post', id:'pdfForm',
		'action': urlBase + "Service/pages/core/simulator.php?controller=Activity&action=printActivity",
		'accept-charset':"UTF-8",target:'_blank'});

	form.insert({bottom:new Element('input',{id:'description',name:'description','type':'hidden',value:intro})});
	form.insert({bottom:new Element('input',{id:'objetive',name:'objetive','type':'hidden',value:objetive})});
	form.insert({bottom:new Element('input',{id:'process',name:'process','type':'hidden',value:proc})});
	form.insert({bottom:new Element('input',{id:'observations',name:'observations','type':'hidden',value:conclusion})});
	form.insert({bottom:new Element('input',{id:'image_data',name:'image_data','type':'hidden',value:$('canvas').toDataURL()})});
	
	$(document.body).insert({bottom:form});
	document.forms["pdfForm"].submit();
	
}

function fireEvent(element,event){
    if (document.createEventObject){
        // dispatch for IE
        var evt = document.createEventObject();
        return element.fireEvent('on'+event,evt)
    }
    else{
        // dispatch for firefox + others
        var evt = document.createEvent("HTMLEvents");
        evt.initEvent(event, true, true ); // event type,bubbling,cancelable
        return !element.dispatchEvent(evt);
    }
}