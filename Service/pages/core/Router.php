<?php

/**
 * Clase que nos permite redireccionar las peticiones directas al controlador 
 * esto con la facilidad de poder llamarlos mediante Ajax
 */

include('../control/AccessHelper.php');

class Router {

     public function __construct() {}

     public function route() {
        session_start();
        if(!isset($_GET['controller'])){
            if(!isset($_GET['data'])){ echo json_encode(array('access'=>false)); return;};

            $data = $_GET['data'];
            // verificamos el acceso y decidimos si iniciamos la sesion si no lo redireccionamos a una pagina de error
            $ac = new AccessHelper();
            if($activity = $ac->validateAcces($data)){
                $_SESSION['activity']=$activity;
                echo json_encode(array('access'=>true));
            }else {
                echo '<h2>Liks de Acceso al Laboratorio</h2>';
                for($i=1;$i<=26;$i++){
                    echo "<h3>".$i."</h3>";
                    $ac->generateData('localhost',$i);

                }
                echo json_encode(array('access'=>false));
            }
        }elseif(isset($_SESSION['activity'])){
            // El url se forma por controller=[Controller]&action=[accion] ej: control=Activity&action=getActivity
            
            $controller = isset($_GET['controller'])?$_GET['controller'].'Controller':''; 
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
                throw new Exception( "Action not callable $action, for $controller" );
            }
        }else{
            //TODO cambiar esto
            echo "window.location = 'access_denied.html';";
        }
    }
}
?>