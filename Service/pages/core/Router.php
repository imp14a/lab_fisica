<?php

/**
 * Clase que nos permite redireccionar las peticiones directas al controlador del blog,
 * esto con la facilidad de poder llamarlos mediante Ajax
 */

include('../control/AccessHelper.php');

class Router {

     public function __construct() {}

     public function route() {
        session_start();
        if(!isset($_SESSION['activity'])){
            $data = $_GET['data'];
            // verificamos el acceso y decidimos si iniciamos la sesion si no lo redireccionamos a una pagina de error
            $ac = new AccessHelper();
            if($activity = $ac->validateAcces($data)){
                $_SESSION['activity']=$activity;
            }else{

            }
        }else{
            print_r($_SESSION['activity']);
            $controller = isset($_GET['controller'])?$_GET['controller']:'SimulatorController'; 
            $action = isset($_GET['action'])?$_GET['action']:'simulator';
            $controllerLocation = '../control/' . $controller . '.php'; 
            
            if( file_exists( $controllerLocation ) ) { 
                include_once( $controllerLocation );
            }else{ 
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
}
?>