<?php

require_once "controller/controller.php";

$controller = new Controller();
$answers = [];
$user = null;
if(isset($_GET['testId']) && isset($_GET['userId'])) {
    $answers = $controller->getStudentAnswers($_GET['testId'], $_GET['userId']);
    $user = $controller->getStudent($_GET['userId']);
    $questions = $controller->getTestQuestions($_GET['testId']);
}
// var_dump($answers);

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
        <div class="row justify-content-center d-inline-flex my-5 ml-1">
            <a class="btn btn-secondary mr-1" href="https://wt70.fei.stuba.sk/webtech-final/trackTest.php?id=<?php echo $_GET['testId']; ?>"
             role="button">Späť</a>
            <button class="btn btn-danger" onclick="location.href='logout.php'">Log Out</button>
        </div>
    </div>
    <div class="container rounded bg-white my-3" style="border: 2px solid black;">
        <div class="row p-2"><h4>Ziak: <?php echo $user[0]['firstname'];?></h4></div>
    </div>
    <div class="container rounded bg-white my-5 w-100" style="border: 2px solid black;">
        <?php
            $tem = 1;
            //NAVRHUJEM PRICITAVAT BODY PRI KAZDEJ ODPOVEDI ALE AK JE TO PICOVINA PRI PAROVACICH OTAZKACH TAK MOZME TO ROBIT INAK
            $points = 0;
            $totalPoints = 0;
            foreach($questions as $question){
                if($question['type'] == 'pair'){
                    $json = json_decode($question['content']);
                    $totalPoints += sizeof($json);
                } else if($question['type'] == 'answer'){
                    $totalPoints += 1;
                } else if($question['type'] == 'options'){
                    $totalPoints += 4;
                }
            }
            foreach($answers as $an) {
                $q = $controller->getQuestionById($an['question_id']);
                echo "<div class='row m-4 d-block p-2 bg-info rounded'><h4>".$tem.". Nazov otazky: ".$q['name']."</h4>
                      <h4>Typ: ".$q['type']."</h4><h4>Zadanie: ".$q['text']."</h4></div>";
                if($q['type'] == 'pair') {
                    $json = json_decode($an['content']);
                    echo "<div class='row m-4'><h4>Vysledok (vyhodnotene automaticky): ".$json->result."</h4></div>";
                    $points += substr($json->result, 0, -2);
                } else if($q['type'] == 'paint') {
                    $json = json_decode($an['content']);
                    echo "<img style='height:400px; margin-left:50px;' src='../files/".$json->path."' alt='img' />";
                } else if($q['type'] == 'answer') {
                    $correctAnswer = $q['content'];
                    $studentAnswer = json_decode($an['content'])->result;
                    if($correctAnswer == $studentAnswer){
                        $points += 1;
                        echo "<div class='row ml-4 mb-2'><h5 class='text-success'>1/1</h5></div>";
                    } else echo "<div class='row ml-4 mb-2'><h5 class='text-danger'>0/1</h5></div>";
                    echo "<div class='row ml-4'><h5>Odpoved ziaka: ".$studentAnswer."</h5></div>";
                    echo "<div class='row ml-4'><h6>Spravna odpoved: ".$correctAnswer."</h6></div>";
                } else if($q['type'] == 'options'){
                    $studentAnswer = json_decode($an['content'])->result;
                    $correctAnswer = json_decode($q['content']);
                    $studentAnswer = str_replace(array( '[', ']' ), '', $studentAnswer);
                    $studentAnswer = explode(",", $studentAnswer);
                    $correct = 0;
                    $incorrect = 0;
                    for($i = 1; $i <= 4; $i++){
                        $option = 'option'.$i.'Check';
                        if($correctAnswer->$option == $studentAnswer[$i - 1]){
                            $correct += 1;
                        } else if($correctAnswer->$option != 1){
                            if ($studentAnswer[$i - 1] == 'false') $correct += 1;
                            else $incorrect += 0.5;
                        }                       
                    }
                    $result = $correct - $incorrect;
                    if($result > 2) echo "<div class='row m-4'><h5 class='text-success'>".$result."/4</h5></div>";
                    else echo "<div class='row m-4'><h5 class='text-danger'>".$result."/4</h5></div>";
                    $points += $result;
                }

                $tem += 1;
            }
            if(!empty($answers)){
                echo "
                <div class='m-4 d-flex justify-content-end'>
                    <h4>Celkový počet bodov (z automaticky vyhodnotených otázok): ".$points."/".$totalPoints."</h4>
                </div>";
            }
        ?>
    </div>
</div>
<script src="script/script.js"></script>

</body>
</html>

<style>
    body {
        background-color: floralwhite;
    }
</style>

<script type="text/javascript">

</script>
