

/**
 * [bindInputs Enlaza los eventos correspondientes para la validacionoes]
 * @param  {[type]} containter [description]
 * @return {[type]}            [description]
 */
function bindInputs(containter){

	$(containter).select('input.number').each(function(element){
		element.observe('keydown',validOnlyNumberFormat);
		element.observe('focusout',changeInput);
	});
}

/**
 * [validOnlyNumberFormat Valida que se esten introducciendo solo teclas valiads para valores numericos]
 * @param  {Event} event Evento del keydown
 * @return {boolean}  True si paso la validacion y false si no, ademas de que evita el evento
 */
function validOnlyNumberFormat(event){
	
	if ( window.event ){
		keynum = event.keyCode;
	}else{
		keynum = event.which;
	}
	if( ( keynum > 47 && keynum < 58 ) || ( keynum > 36 && keynum < 41 )  
		|| keynum == 8 || keynum == 0 || keynum == 95  || keynum ==46 || keynum ==9
		|| keynum == 190 || keynum == 110 ||  ( keynum > 95 && keynum < 106 )){

		return true;
	}else{
		event.preventDefault();
		return false;
	}
}

/**
 * [changeInput Funcion que valida que lo introducido sea un numero]
 * @param  {Objet} element Elemento input a validar
 */
function changeInput(element){
	var num = Number(element.target.value);
	if(isNaN(num)){
		element.target.value = 0;
	}
}