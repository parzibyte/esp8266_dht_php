<?php
if (!isset($_GET["start"]) || !isset($_GET["end"])) {
    echo json_encode([]);
    exit;
}
$start = $_GET["start"];
$end = $_GET["end"];
include_once "functions.php";
echo json_encode(getSensorData($start, $end));