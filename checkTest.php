<?php

require_once "controller/controller.php";

$controller = new Controller();
$answers = [];
$user = null;
if(isset($_GET['testId']) && isset($_GET['userId'])) {
    $answers = $controller->getStudentAnswers($_GET['testId'], $_GET['userId']);
    $user = $controller->getStudent($_GET['userId']);
}

?>

<html lang="sk">

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>WEBTECH2 - final</title>
</head>

<body>

<div class="container my-3">
    <div class="row">
        <h1>Pohlad ucitela - Test ziaka</h1>
    </div>
    <div class="row">
        <div class="row justify-content-center d-inline-flex my-5">
            <button type="button" class="btn btn-secondary mr-1" onclick="show('index')">Späť</button>
        </div>
    </div>
    <div class="container rounded bg-white my-5 w-100" style="border: 2px solid black;">
        <?php
            $tem = 1;
            foreach($answers as $an) {
                $q = $controller->getQuestionById($an['question_id']);
                echo "<div class='row m-4 d-block p-2 bg-info rounded'><h4>".$tem." Nazov otazky: ".$q['name']."</h4><h4>Typ: ".$q['type']."</h4><h4>Zadanie: ".$q['text']."</h4></div>";
                if($q['type'] == 'pair') {
                    $json = json_decode($an['content']);
                    echo "<div class='row m-4'><h4>Vysledok (vyhodnotene automaticky): ".$json->result."</h4></div>";
                } else if($q['type'] == 'paint') {
                    $json = json_decode($an['content']);
                    echo "<img style='height:400px; margin-left:50px;' src='../files/".$json->path."' alt='img' />";
                }

                $tem += 1;
            }
        ?>
    </div>
</div>
<script src="script/script.js"></script>
</body>
</html>

<script type="text/javascript">

</script>
