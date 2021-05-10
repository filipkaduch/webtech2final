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
    <script src="https://unpkg.com/konva@7.2.5/konva.min.js"></script>
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
            echo "<div class='row m-4 d-flex justify-content-center align-items-center'><h4>Nazov otazky: </h4>".$q['name']." <h4>Typ: </h4> ".$q['type']."<h4>Zadanie: </h4>".$q['text']."</div>";
            if($q['type'] == 'paint') {
                echo "<div id='canvas'></div>";
            } else if($q['type'] == 'pair') {
                echo "<div id='container'></div>";
            }
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
    let stage = new Konva.Stage({
        container: 'container',
        width: 460,
        height: 300,
    });
    let layer = new Konva.Layer();

    function createCanvas(parent, width, height) {
        var canvas = {};
        canvas.node = document.createElement('canvas');
        canvas.context = canvas.node.getContext('2d');
        canvas.node.width = width || 100;
        canvas.node.height = height || 100;
        parent.appendChild(canvas.node);
        return canvas;
    }

    function init(container, width, height, fillColor) {
        var canvas = createCanvas(container, width, height);
        var ctx = canvas.context;
        // define a custom fillCircle method
        ctx.fillCircle = function(x, y, radius, fillColor) {
            this.fillStyle = fillColor;
            this.beginPath();
            this.moveTo(x, y);
            this.arc(x, y, radius, 0, Math.PI * 2, false);
            this.fill();
        };
        ctx.clearTo = function(fillColor) {
            ctx.fillStyle = fillColor;
            ctx.fillRect(0, 0, width, height);
        };
        ctx.clearTo(fillColor || "#ddd");

        // bind mouse events
        canvas.node.onmousemove = function(e) {
            if (!canvas.isDrawing) {
                return;
            }
            var x = e.pageX - this.offsetLeft;
            var y = e.pageY - this.offsetTop;
            var radius = 10; // or whatever
            var fillColor = '#ff0000';
            ctx.fillCircle(x, y, radius, fillColor);
        };
        canvas.node.onmousedown = function(e) {
            canvas.isDrawing = true;
        };
        canvas.node.onmouseup = function(e) {
            canvas.isDrawing = false;
        };
    }

    var container = document.getElementById('canvas');
    init(container, 200, 200, '#ddd');

</script>
