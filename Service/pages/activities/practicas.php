<?php
/*
Archivo para el uso de la redireccion del url mediante el controlador
 */
include ("../control/AccessHelper.php");

$link = new AccessHelper();

/*$router = new Router();
$router -> route();*/
echo "<a href='http://wowinteractive.com.mx/lab_fisica/App/access.html#data=".$link -> generateData('localhost',13)."'> Practica 13 </a>";
echo "<br /><br />";
echo "<a href='http://wowinteractive.com.mx/lab_fisica/App/access.html#data=".$link -> generateData('localhost',9)."'> Practica 9 (Plano inclinado) </a>";
echo "<br /><br />";
echo "<a href='http://wowinteractive.com.mx/lab_fisica/App/access.html#data=".$link -> generateData('localhost',15)."'> Practica 15 (Friccion 1) </a>";
echo "<br /><br />";
echo "<a href='http://wowinteractive.com.mx/lab_fisica/App/access.html#data=".$link -> generateData('localhost',16)."'> Practica 16 (Friccion 2) </a>"

?>
