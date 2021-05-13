<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$testId  = $_GET['id'];

require_once "controller/controller.php";
$controller = new Controller();

$test = $controller->getTest($testId);

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
        <h1>Pohlad ucitela - Sledovat test</h1>
    </div>
    <div class="row">
        <div class="row justify-content-center d-inline-flex my-5">
            <button type="button" class="btn btn-secondary mr-1" onclick="show('index')">Späť</button>
        </div>
    </div>
</div>

<div class="container border rounded bg-info mb-5 w-100" style="min-height: 200px;">
    <h2 class="text-center mt-2"><?php echo $test[0]['name']?></h2>
    <table class="table table-light mt-3">
        <thead class="thead-dark">
            <th>Student</th>
            <th>Status</th>
        </thead>
        <tbody>
            <tr>
                <td>Meno studenta</td>
                <td>robi/dokoncil</td>
            </tr>
        </tbody>
    </table>
</div>

<script type="text/javascript">





</script>


<script src="script/script.js"></script>

</body>

</html>