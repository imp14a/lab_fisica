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
*/
function getActivityService()
{
	new Ajax.Request('http://lab_fisica/Service/pages/core/simulator.php', {
		method: 'get',
  		parameters: {controller: 'Activity', action: 'getActivity'},
  		onSuccess: function(transport) {		      			
  			var json = transport.responseText.substring(transport.responseText.indexOf("{"), transport.responseText.length).evalJSON();  		   			  			  			  			
  			console.log(json);
		    /*if(json){		    			    			    			    			    	
		    	alert(json.title);
		    }else{
		    	alert("no pelo");
				//window.location = "access_denied.html";
		    }*/		    
		},
  		onFailure: function() { 
  			alert('Intente en otro momento...'); 
  		}
	});
}