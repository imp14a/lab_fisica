<?php
/*
Archivo para el uso de la redireccion del url mediante el controlador
 */
include ("../control/AccessHelper.php");

$link = new AccessHelper();

/*$router = new Router();
$router -> route();*/
echo "<a href='http://wowinteractive.com.mx/lab_fisica/App/access.html#data=".$link -> generateData('localhost',1)."'> Practica 1 </a>";
echo "<br /><br />";
echo "<a href='http://wowinteractive.com.mx/lab_fisica/App/access.html#data=".$link -> generateData('localhost',2)."'> Practica 2 (EFP 1) </a>";
echo "<br /><br />";
echo "<a href='http://wowinteractive.com.mx/lab_fisica/App/access.html#data=".$link -> generateData('localhost',3)."'> Practica 3 (EFP 2) </a>";
echo "<br /><br />";
echo "<a href='http://wowinteractive.com.mx/lab_fisica/App/access.html#data=".$link -> generateData('localhost',4)."'> Practica 4 (EFP 3) </a>";
echo "<br /><br />";
echo "<a href='http://wowinteractive.com.mx/lab_fisica/App/access.html#data=".$link -> generateData('localhost',5)."'> Practica 5 (EFP 4) </a>";
echo "<br /><br />";
echo "<a href='http://wowinteractive.com.mx/lab_fisica/App/access.html#data=".$link -> generateData('localhost',6)."'> Practica 6 (EFP 5) </a>";
echo "<br /><br />";
echo "<a href='http://wowinteractive.com.mx/lab_fisica/App/access.html#data=".$link -> generateData('localhost',7)."'> Practica 7 (EFP 6) </a>";
echo "<br /><br />";
echo "<a href='http://wowinteractive.com.mx/lab_fisica/App/access.html#data=".$link -> generateData('localhost',8)."'> Practica 8 (EFP 7) </a>";
echo "<br /><br />";
echo "<a href='http://wowinteractive.com.mx/lab_fisica/App/access.html#data=".$link -> generateData('localhost',9)."'> Practica 9 (Plano inclinado) </a>";
echo "<br /><br />";
echo "<a href='http://wowinteractive.com.mx/lab_fisica/App/access.html#data=".$link -> generateData('localhost',10)."'> Practica 10 (Plano inclinado 2) </a>";
echo "<br /><br />";
echo "<a href='http://wowinteractive.com.mx/lab_fisica/App/access.html#data=".$link -> generateData('localhost',11)."'> Practica 11 (Plano inclinado 3) </a>";
echo "<br /><br />";
echo "<a href='http://wowinteractive.com.mx/lab_fisica/App/access.html#data=".$link -> generateData('localhost',13)."'> Practica 13 (Caida libre) </a>";
echo "<br /><br />";
echo "<a href='http://wowinteractive.com.mx/lab_fisica/App/access.html#data=".$link -> generateData('localhost',14)."'> Practica 14 (Fuerzas concurrentes) </a>";
echo "<br /><br />";
echo "<a href='http://wowinteractive.com.mx/lab_fisica/App/access.html#data=".$link -> generateData('localhost',15)."'> Practica 15 (Friccion 1) </a>";
echo "<br /><br />";
echo "<a href='http://wowinteractive.com.mx/lab_fisica/App/access.html#data=".$link -> generateData('localhost',16)."'> Practica 16 (Friccion 2) </a>";
echo "<br /><br />";
echo "<a href='http://wowinteractive.com.mx/lab_fisica/App/access.html#data=".$link -> generateData('localhost',17)."'> Practica 17 (Fuerzas 1) </a>";
echo "<br /><br />";
echo "<a href='http://wowinteractive.com.mx/lab_fisica/App/access.html#data=".$link -> generateData('localhost',18)."'> Practica 18 (Fuerzas 2) </a>";
echo "<br /><br />";
echo "<a href='http://wowinteractive.com.mx/lab_fisica/App/access.html#data=".$link -> generateData('localhost',19)."'> Practica 19 (Fuerzas 3) </a>";
echo "<br /><br />";
echo "<a href='http://wowinteractive.com.mx/lab_fisica/App/access.html#data=".$link -> generateData('localhost',24)."'> Practica 24 (Tiro Parabolico) </a>";
echo "<br /><br />";
echo "<a href='http://wowinteractive.com.mx/lab_fisica/App/access.html#data=".$link -> generateData('localhost',25)."'> Practica 25 (Tiro Parabolico Colision) </a>";
echo "<br /><br />";

?>
