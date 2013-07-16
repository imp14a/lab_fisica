/*
	accessService()

	Realiza una llamada al servicio de acceso y determina 
	si se trata de un acceso lícito o no.
*/

//Event.observe(window, 'resize', setDimensionElements);

Event.observe(window, 'load', accessService);

function accessService() {	
	var data = new String(window.location);
	data = data.substring(data.indexOf("=") + 1, data.length);
	
	new Ajax.Request('http://wowinteractive.com.mx/lab_fisica/Service/pages/core/simulator.php', {
  		method: 'get',
  		parameters: {data: data},
  		onSuccess: function(transport) {  	  			
  			var json = transport.responseText.substring(transport.responseText.indexOf("{"), transport.responseText.length).evalJSON();  		   			  			  			  			
		    if(json.access){		    			    			    			    			    	
		    	window.location = "index.html";
		    }else{		    	
		    	window.location = "access_denied.html";				
		   	}
		},
  		onFailure: function() { 
  			alert('Ocurrió un error al validar el acceso.'); 
  		}
	});
}