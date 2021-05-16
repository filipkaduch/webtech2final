<?php

require_once "controller/controller.php";
$controller = new Controller();
session_start();

if(isset($_SESSION['ucitel_id'])) {
    $ucitelId = $_SESSION['ucitel_id'];
    $tests = $controller->getTestsByUcitelId($ucitelId);
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

<header>
    <h1 style="margin: 20px;">WEBTECH2 - final</h1>
</header>




<div class="container my-3">
    <div class="row">
        <h1>Pohlad ucitela- Testy</h1>
    </div>
    <div class="">
        <div class="justify-content-between d-flex my-5">
            <button type="button" class="btn btn-secondary mr-1" onclick="show('createTest')">Vytvorit novy test</button>
            <button class="btn btn-danger" onclick="location.href='logout.php'">Log Out</button>
        </div>
    </div>
</div>

<div class="container border rounded bg-info mb-5 w-100" style="min-height: 200px;">
    <?php
        $count = 0;
        foreach($tests as $t) {
            if($count % 3 == 0) {
                echo "<div class='row m-4'>";
            }

            echo "<div class='col-4 p-4 bg-white border'><h3>Nazov: ".$t['name']."</h3><br><h4>Zaciatok: ".$t['startTime']."</h4><br>
            <h4>Trvanie: ".$t['time']."</h4><br><h4>Stav: ".$t['state']."</h4><br>
            <h4>Token:</h4><small class='mb-4'>".$t['token']."</small>
            <button class='btn btn-warning btn-block' id='".$t['id']."' onclick='setActive(this.id)'>Aktivuj/Deaktivuj</button><br>
            <button class='btn btn-warning btn-block' id='".$t['id']."' onclick='deleteTest(this.id)'>Zmazat</button>
            <a class='btn btn-warning btn-block mt-4' href='trackTest.php?id=".$t['id']."' role='button'>Sledovat</a>
            </div>";
            if($count % 3 == 2) {
                echo "</div>";
            }
            $count++;
        }
    ?>
</div>
<script type="text/javascript">





</script>


<script src="script/script.js"></script>


</body>


</html>
<style>
    body {
        background-color: floralwhite;
    }
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

    function saveTest() {
        jQuery.ajax({
            type: "POST",
            url: 'saveTest.php',
            dataType: 'json',
            data: {id: id, name: testName, startTime: startTime, startTimeDate: startTimeDate, time: time},

            success: function (obj, textstatus) {
                if( !('error' in obj) ) {
                    console.log(obj);
                    window.location.reload();
                }
                else {
                    console.log(obj.error);
                }
            }
        });
    }

    function setActive(id) {
        jQuery.ajax({
            type: "POST",
            url: 'setActive.php',
            dataType: 'json',
            data: {id: id},

            success: function (obj, textstatus) {
                if( !('error' in obj) ) {
                    console.log(obj);
                    window.location.reload();
                }
                else {
                    console.log(obj.error);
                }
            }
        });
    }

    function deleteTest(id) {
        //let contents = $('#contents').text();
        jQuery.ajax({
            type: "POST",
            url: 'deleteTest.php',
            dataType: 'json',
            data: {id: id},

            success: function (obj, textstatus) {
                if( !('error' in obj) ) {
                    console.log(obj);
                    window.location.reload();
                }
                else {
                    console.log(obj.error);
                }
            }
        });
    }

</script>