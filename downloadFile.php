<?php

header('Content-Type: application/json');
require_once "controller/controller.php";

$controller = new Controller();
$aResult = array();

if( !isset($_POST['testId']) && !isset($_FILES['file'])) { $aResult['error'] = 'No  arguments!'; }

if( !isset($aResult['error']) && isset($_POST['imgBase64']) ) {
    $img = $_POST['imgBase64'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $fileData = base64_decode($img);
    //saving
    $uniquesavename = time().uniqid(rand());
    $fileName = "../files/".$uniquesavename.".png";
    file_put_contents($fileName, $fileData);
    $jsonString = '{"path":"'.$uniquesavename.".png".'"}';
    $controller->saveAnswer($_POST['testId'], $_POST['userId'], $_POST['questionId'], $jsonString);

} else if ( !isset($aResult['error']) && isset($_FILES['file']) && isset($_POST['testId']) && isset($_POST['questionId']) && isset($_POST['userId']))    {
    $fileName = $_FILES['file']['name'];
    $fileType = $_FILES['file']['type'];
    $fileError = $_FILES['file']['error'];
    $testId = $_POST['testId'];
    $userId = $_POST['userId'];
    $questionId = $_POST['questionId'];
    $newDir = $_SERVER['DOCUMENT_ROOT'];
    $destination = $newDir."/files/";

    echo json_encode($fileType);
    $fileContent = file_get_contents($_FILES['file']['tmp_name']);
    if(move_uploaded_file($_FILES['file']['tmp_name'],  $destination . $fileName . ".png")) {
        file_put_contents($fileName, $fileContent);
        $jsonString = '{"path":"'.$fileName.'"}';
        $controller->saveAnswer($testId, $userId, $questionId, $jsonString);
        echo json_encode("Success: " . $_FILES['file']['name']);
    } else {
        echo json_encode("Not uploaded because of error " . $_FILES["file"]["error"]);
    }
}

