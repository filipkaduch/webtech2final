<?php

header('Content-Type: application/json');
require_once "controller/controller.php";

$controller = new Controller();
$aResult = array();
$newDir = $_SERVER['DOCUMENT_ROOT'];
$newDir = $newDir."/files/";
if( !isset($_POST['testId']) ) { $aResult['error'] = 'No  arguments!'; }

if( !isset($aResult['error']) ) {
    $img = $_POST['imgBase64'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $fileData = base64_decode($img);
    //saving
    $uniquesavename = time().uniqid(rand());
    $fileName = "../files/".$uniquesavename.".png";
    file_put_contents($fileName, $fileData);
    $jsonString = '{"path":"'.$_POST['content'].'"}';
    $controller->saveAnswer($_POST['testId'], $_POST['userId'], $_POST['questionId'], $jsonString);

}

echo json_encode($aResult);
