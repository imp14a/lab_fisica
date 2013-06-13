/**
 *  WOW Interactive Mexico
 *  
 *	Ventana modal
 */
 
var Modal = Class.create({
	initialize: function() {						
		this.container = null;	
		this.overlay = null;						
		this.btn_ok = null;
		this.btn_cancel = null;
		this.title = null;
		this.content = null;

		this.buildModal();
		this.addObservers();		
  	},
  	
  	buildModal: function() { 
  		overlay = new Element('div', { 'class': 'full_screen'});
  		container = new Element('div', { 'class': 'w_modal' });
  		content = new Element('div', { 'class': 'modal_body' });  			  		  	
  		title = new Element('div', { 'class': 'modal_title' });	
  		toolbar = new Element('ul', { 'class': 'modal_toolbar' });		

  		btn_ok = new Element('a', { 'class': 'btn_ok', 'id': 'btn_ok'});
  		separator = new Element('a', { 'class': 'separator' });
  		btn_cancel = new Element('a', { 'class': 'btn_cancel', 'id': 'btn_cancel'});

  		document.body.insert(overlay);

		container.insert(title);		
		toolbar.insert(btn_ok);
		toolbar.insert(separator);
  		toolbar.insert(btn_cancel);	  		
  		container.insert(toolbar);  	
  		container.insert(content);  	  		

  		document.body.insert(container);

  		this.overlay = overlay;
  		this.container = container;
  		this.content = content;
  		this.title = title;
  		this.btn_ok = btn_ok;
		this.btn_cancel = btn_cancel;
  		
  		this.container.setStyle({display: 'none'});
  		this.overlay.setStyle({display: 'none'});  		  	
  	},
  
	addObservers: function() {		
		this.btn_cancel = $('btn_cancel');		
		this.btn_cancel.observe('click', this.hideModal.bindAsEventListener(this));		
	},
	
	setProperties: function(title, content, accept_event) {
		this.title.update(title);
		this.content.update(content);
		this.btn_ok = $('btn_ok');		
		this.btn_ok.observe('click', accept_event);		
	},

  	showModal: function(type) {    		
  		//ShowDialog()
		this.overlay.setStyle({
			position: "absolute",
		   	display: 'block'
		}); 
		this.container.setStyle({
			position: "absolute",
		   	display: 'block'
		}); 		
      return false;
  	},
  	
  	hideModal: function(event) {  	
  		this.overlay.setStyle({
			position: "absolute",
		   	display: 'none'
		}); 
		this.container.setStyle({
			position: "absolute",
		   	display: 'none'
		}); 		
		return false;
  	},

  	getPropertiesValues:function(event){
  		var result = $(this.content).select('.property');
  		var res = new Array();
  		res.each(
  			function(elemennt){
  				prop = {}
  				(elemennt
  			}
  		);

  	}
});