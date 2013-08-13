<?php 
/**
 * Archivo para el uso de la redireccion del url mediante el controlador
 */
include ("Router.php");

date_default_timezone_set('UTC');

set_error_handler("my_warning_handler", E_ALL);
function my_warning_handler($errno, $errstr, $errfile, $errline, $errcontext) {
	throw new Exception( $errstr );
}

$router = new Router();
$router -> route();

?>