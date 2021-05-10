<?php

require_once "controller/controller.php";
$controller = new Controller();

$questions = $controller->getTestQuestions(1);

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

<header>
    <h1 style="margin: 20px;">WEBTECH2 - final</h1>
</header>




<div class="container my-3">
    <div class="row">
        <h1>Pohlad ziaka- Test</h1>
    </div>
    <div class="row">
        <div class="row justify-content-center d-inline-flex my-5">
            <button type="button" class="btn btn-secondary mr-1" onclick="show('createTest')">Odovzdat test</button>
        </div>
    </div>
</div>

<div class="container rounded bg-white mb-5 w-100" style="min-height: 1200px; border: 3px solid black;">
    <?php
        foreach($questions as $q) {
            echo "<div class='row m-4'><h3>Nazov otazky:</h3> ".$q['name']." <h3>Typ:</h3> ".$q['type']."</div>";
        }
    ?>
</div>
<script type="text/javascript">





</script>


<script src="script/script.js"></script>

</body>


</html>
<style>
    .control-bar {
        height: 300px;
        background-color: cornsilk;
        border: 2px solid lightslategray;
        margin-top: 30px;
        border-radius: 8px;
        display: flex;
        justify-content: center;
        padding: 30px;
    }
</style>

<script type="text/javascript">


</script>
