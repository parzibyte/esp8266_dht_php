<?php
if (!isset($_GET["temperature"]) || !isset($_GET["humidity"])) {
	exit("temperature and humidity are required");
}

$temperature = $_GET["temperature"];
$humidity = $_GET["humidity"];
include_once "functions.php";
saveDhtData($temperature, $humidity);
exit("ok");
