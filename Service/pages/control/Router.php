<?php

/**
 * Clase que nos permite redireccionar las peticiones directas al controlador del blog,
 * esto con la facilidad de poder llamarlos mediante Ajax
 */
class Router { 
     public function __construct() {}

     public function route() {
     	
           $controller = $_GET['controller']; 
           $action = $_GET['action']; 

           if( !$controller ) $controller = 'SimulatorController'; 
           if( !$action ) $action = 'index';
		
           $controllerLocation = getcwd() . '/' . $controller . '.php'; 

           if( file_exists( $controllerLocation ) ) { 
                 include_once( $controllerLocation );
           } else { 
                 throw new Exception("No se encuentra el controlador $controllerLocation"); 
           } 

           if( class_exists( $controller, false ) ) { 
                  $cont = new $controller();
           } else { 
                  throw new Exception( "Controller Class not found $controller" ); 
           }

           if(method_exists( $cont, $action ) ) {
                  $cont->$action();
           } else {
                   throw new Exception( "Action not callable $action" ); 
           }

     } 
}
?>