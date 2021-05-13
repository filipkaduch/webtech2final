<?php

header('Content-Type: application/json');
require_once "controller/controller.php";
session_start();
$controller = new Controller();
$aResult = array();

if( !isset($_POST['id']) ) { $aResult['error'] = 'No  arguments!'; }

if( !isset($aResult['error']) && isset($_SESSION['ucitel_id'])) {
    $startTimeDate = $_POST['startTimeDate'];
    $startTime = $_POST['startTime'];
    $dateTime = date_create($startTimeDate.' '.$startTime);
    $date = $dateTime->format("Y-m-d H:m");
    $controller->saveTest($_POST['id'], $_POST['name'], $date, $_POST['time'], $_SESSION['ucitel_id']);

}

echo json_encode($aResult);
