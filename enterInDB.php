<?php
$con = mysql_connect("localhost", "root", "");
$db = mysql_select_db("btp");
$density = $_POST['density'];
$sidestep = $_POST['sidestep'];
$speed = $_POST['speed'];
$totalPed = $_POST['totalPed'];
$simulationStep = $_POST['simulationStep'];
$speedSQL = mysql_query("INSERT INTO speedvdensity (simulationStep, speed, density, totalPed) VALUES ('".$simulationStep."', '".$speed."', '".$density."', '".$totalPed."')");
$sideSQL = mysql_query("INSERT INTO sidestepvdensity (simulationStep, sidestep, density, totalPed) VALUES ('".$simulationStep."', '".$sidestep."', '".$density."', '".$totalPed."')");
?>