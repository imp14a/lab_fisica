
Event.observe(window, 'resize', adjustWindow);

/*
	Redimensiona los elementos de acuerdo al tamaño del viewport.
*/
function adjustWindow(){
	
	var viewport = document.viewport.getDimensions(); // Gets the viewport as an object literal

	if(viewport.width<1024){
		$('navigation').hide();
		$('simulator').setStyle({
			width:'85%'
		});
		$('left_bar').setStyle({
			width:'45px',
			'margin-top': '60px',
			padding:0
		});
		$('left_bar').select('.item_bar').each(function(e){
			e.setStyle({
				'border-right':'none',
				'border-bottom': e.hasClassName('last')?'':'3px solid #5f9ea0',
				width:"45px"
			});
		});
		$$('#footer ul[class="center_bar"]').each(function(e){
			e.setStyle({
				'margin-right': 0
			});
		});
	}else{
		$('navigation').show();
		$('simulator').setStyle({
			width:'70%'
		});
		$('left_bar').setStyle({
			width:'23%',
			'margin-top': '-30px',
			'padding-left':'15px',
			'padding-right':'15px'
		});
		$('left_bar').select('.item_bar').each(function(e){
			e.setStyle({
				'border-bottom':'none',
				'border-right': e.hasClassName('last')?'':'3px solid #5f9ea0',
				width:"17%"
			});
		});
		$$('#footer ul[class="center_bar"]').each(function(e){
			e.setStyle({
				'margin-right':"5%"
			});
		});
	}
}
