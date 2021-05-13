<?php

require_once "controller/controller.php";
$controller = new Controller();


$questions = $controller->getTestQuestions(96);
$test = $controller->getTest(96);


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
    <div class="container">
        <div class="row justify-content-center d-inline-flex my-5">
            <button type="button" class="btn btn-secondary mr-1" onclick="submitTest('createTest')">Odovzdat test</button>
            <button type="button" class="btn btn-secondary mr-1" onclick="">Spustit test</button>
        </div>
        <div class="row d-block my-5">
            <h3>Nazov: <?php echo $test['name']?></h3>
            <h3>Stav: <?php echo $test['state']?></h3>
            <h3>Trvanie: <?php echo $test['time']?></h3>
            <h3>Start: <?php echo $test['startTime']?></h3>
        </div>
    </div>
</div>
<div class="container">
<?php
echo "<div id='testId' style='display: none;'>".$test['id']."</div>";
if($test['state'] === 'disabled') {
    echo "<h4>TEST JE MOMENTALNE ZABLOKOVANY. ZACAT MA:".$test['startTime']."</h4>";
}
?>
</div>
<div class="container rounded bg-white mb-5 w-100" style="min-height: 1200px; visibility:<?php
if($test['state'] === 'disabled') {
    echo "hidden;";
} else {
    echo "visible;";
}
?>border: 3px solid black;">
    <?php
        $tem = 1;
        //PRIDAJTE SI DO IF ELSE STATEMENTU KOD PRE SVOJ TYP OTAZKY('math','short','multiple' napriklad)
        //POUZIVAM ID OTAZKY PRI GENEROVANI ELEMENTOV PRE PRIPAD VIACERYCH OTAZOK ROVNAKEHO TYPU
        //CLASS VYSLEDOK POUZIVAM KVOLI ODOVZDANIU TESTU ABY SA ZOZBIERALI VSETKY AUTOMATICKY OPRAVOVANE OTAZKY
        foreach($questions as $q) {
            $cou = 1;
            echo "<div class='row m-4 d-block p-2 bg-info rounded'><h4>".$tem." Nazov otazky: ".$q['name']."</h4><h4>Typ: ".$q['type']."</h4><h4>Zadanie: ".$q['text']."</h4></div>";
            if($q['type'] == 'paint') {
                echo "<div class='row m-2 align-items-center justify-content-between d-inline-flex w-100'><button class='btn btn-primary m-3' id='bttnQ".$q['id']."' onclick='showCanvas(this)'>Nakreslit v editore</button><label class='label' for='fileQ".$q['id']."'>Nahrat obrazok</label><input type='file' class='form-control mr-4' style='width: 300px;' name='file".$q['id']."' id='fileQ".$q['id']."' onclick='showCanvas(this)'></div><div id='cnv".$q['id']."' class='cnv' style='height: 600px;'><div id='canvas".$q['id']."'></div><button class='btn btn-primary' id='confP".$q['id']."' onclick='saveCanvas(this)'>Potvrdit nakres</button></div>";
            } else if($q['type'] == 'pair') {
                echo "<div class='row m-2 align-items-center justify-content-between d-inline-flex w-100'><button class='btn btn-primary m-3 ml-4' id='pairQ".$q['id']."' onclick='generatePair(this)' >Vygeneruj parove otazky</button><div class='vysledok mr-5' style='font-size: 25px;' id='pairR".$q['id']."'></div></div>";
                echo "<div class='jtk-demo-main mx-4 mt-3'><div id='pairCanvas".$q['id']."' style='height: 600px; width: 466px; position: relative'></div></div>";
            } else if($q['type'] == 'options') {
                $arrNumber = $cou - 1;
                $option = json_decode($q['content'], true);
                echo
                    "<div class='row m-2 align-items-center justify-content-between d-inline-flex w-100'>
                    <div class='form-check'>";
                for($i =1; $i <=4; $i++){
                    $optionNumber = 'option'.$i;
                    echo
                        "<input type='checkbox' class='form-check-input' id='".$optionNumber."Check'></input>
                        <label class='form-check-label' for='".$optionNumber."Check'>".$option[$optionNumber]."</label>
                        <br>";
                }
                echo
                "</div>
                </div>";

            }
            $tem += 1;
        }
        //generovanie otazok s otvorenou odpovedou a moznostami
        $count = 1;
        echo "<br><br><br>";
        foreach($questions as $question){
            if($question['type'] == 'answer'){
                echo 
                "<div class='mb-3'>
                    <div class=''>
                        <h4>".$count.".".$question['text']."</h4>
                    </div>
                    <div class=''>
                        <input class=''></input>
                    </div>
                </div>";
                $count++;
            }
            else if($question['type'] == 'options'){
                $arrNumber = $count - 1;
                $option = json_decode($questions[$arrNumber]['content'], true);
                echo 
                "<div class='mb-3'>
                    <div class=''>
                        <h4>".$count.". ".$question['text']."</h4>
                    </div>
                    <div class='form-check'>";
                    for($i =1; $i <=4; $i++){  
                        $optionNumber = 'option'.$i;                 
                        echo 
                        "<input type='checkbox' class='form-check-input' id='".$optionNumber."Check'></input>
                        <label class='form-check-label' for='".$optionNumber."Check'>".$option[$optionNumber]."</label>
                        <br>";
                    }
                echo
                    "</div>
                </div>";
                $count++;
            }
        }
    ?>
</div>
<script type="text/javascript">





</script>


<script src="script/script.js"></script>
<script src="script/jsplumb.js"></script>

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

    .window {
        height: 60px;
        width: auto;
        border: 2px solid black;
    }

    .vysledok {
        font-size: 25px;
    }

    .cnv {
        visibility: hidden;
    }
</style>

<script type="text/javascript">

    let answersTest = [];

    function isEmpty(str) {
        return (!str || str.length === 0 );
    }

    function submitTest() {
        let testId = $('#testId').text();
        $(".vysledok").each(function() {
            let id = $(this).attr('id');
            var lastChar = id.substring(5, id.length);
            let content = $(this).html();
            if(!isEmpty(content)) {
                $.ajax({
                    type: "POST",
                    url: "saveQuestionResult.php",
                    data: {
                        questionId: lastChar,
                        userId: 1,
                        testId: testId,
                        content: content
                    }
                }).done(function(o) {

                });
            }
        });
        $.ajax({
            type: "POST",
            url: "saveAnswers.php",
            data: {
                userId: 1,
                testId: testId
            }
        }).done(function(o) {

        });

    }

    function createCanvas(parent, width, height, id) {
        var canvas = {};
        canvas.node = document.createElement('canvas');
        canvas.context = canvas.node.getContext('2d');
        canvas.node.width = width || 100;
        canvas.node.height = height || 100;
        parent.appendChild(canvas.node);
        return canvas;
    }

    function init(container, width, height, fillColor, id) {
        var canvas = createCanvas(container, width, height, id);
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

    function saveCanvas(el) {
        let testId = $('#testId').text();
        let id = el.id;
        var lastChar = id.substring(5, id.length);
        var canvas = document.getElementById('canvas'+lastChar);
        var dataURL = canvas.lastChild.toDataURL();

        $.ajax({
            type: "POST",
            url: "downloadFile.php",
            data: {
                questionId: lastChar,
                userId: 1,
                testId: testId,
                imgBase64: dataURL
            }
        }).done(function(o) {

        });
    }

    function showCanvas(el) {
        let id = el.id;
        var lastChar = id.substring(5, id.length);
        console.log(lastChar);
        $('#cnv'+lastChar).removeClass('cnv');
        var container = document.getElementById('canvas'+lastChar);
        init(container, 800, 550, '#ddd', lastChar);
    }

    // change the type if u need to get another type of question
    function generatePair(el) {
        jsPlumb.ready(function() {
            let id = el.id;
            var lastChar = id.substring(5, id.length);
            let keys = [];
            jQuery.ajax({
                type: "POST",
                url: 'getQuestionContent.php',
                dataType: 'json',
                data: {id: lastChar},

                success: function (obj, textstatus) {
                    if( !('error' in obj) ) {
                        let tempArr = [];
                        keys = JSON.parse(obj.content).slice();
                        let correct = 0;
                        let test = "pairCanvas"+lastChar.toString();
                        var instance = jsPlumb.getInstance({
                            DragOptions: { cursor: 'pointer', zIndex: 2000 },
                            PaintStyle: { stroke: '#666' },
                            EndpointHoverStyle: { fill: "orange" },
                            HoverPaintStyle: { stroke: "orange" },
                            isSource:true,
                            isTarget:true,
                            EndpointStyle: { width: 20, height: 16, stroke: '#666', position: 'relative'},
                            Endpoint: "Rectangle",
                            Container: test
                        });

                        jsPlumb.bind('connection',function(info,ev){
                            let obj = {key: info.source.textContent, value: info.target.textContent};
                            tempArr.push(obj);

                            if(containsObject(obj, keys) === false) {
                                $('#pairR'+lastChar.toString()).text(correct.toString()+"/"+keys.length.toString());
                                return alert('Nespravna moznost!');
                            } else {
                                correct += 1;
                                $('#pairR'+lastChar.toString()).text(correct.toString()+"/"+keys.length.toString());
                                return alert('Spravna moznost!');
                            }
                            answersTest.push(tempArr);
                        });
                        jsPlumb.Defaults.Container = $('#'+test);
                        var endpointSourceOptions = { endpoint:["Rectangle",{ width:10, height:10, position: 'relative'}], isSource:true,  beforeDrop: function (params) {
                                return confirm("Spojit " + params.sourceId + " s " + params.targetId + "? Potvrdenim sa uz nemozete vratit spat.");
                            }
                        };
                        var endpointTargetOptions = { endpoint:["Rectangle",{ width:10, height:10, position: 'relative'}], isTarget:true,  beforeDrop: function (params) {
                                return confirm("Spojit " + params.sourceId + " s " + params.targetId + "? Potvrdenim sa uz nemozete vratit spat.");
                            }
                        };
                        instance.importDefaults({
                            Connector : [ "Bezier", { curviness: 35 } ],
                            Anchors : [ "Top" ]
                        });
                        let bot = 1;
                        let iter = 0;
                        for(let i = 0; i < keys.length; i+=2) {
                            let bottom = bot * 10;
                            $('#'+test).append("<div class='window' id='"+"dragDropWindow"+i.toString()+"' style='position: absolute; top: -"+bottom+"px'>"+"<p class='m-2'>"+keys[iter].key+"</p></div>");
                            $('#'+test).append("<div class='window' id='"+"dragDropWindow"+(i+1).toString()+"' style='position: absolute; right: -400px; top: -"+bottom+"px'>"+"<p class='m-2'>"+keys[iter].value+"</p></div>");
                            jsPlumb.addEndpoint('dragDropWindow'+i.toString(), { anchor:"Right" }, endpointSourceOptions );
                            jsPlumb.addEndpoint('dragDropWindow'+(i+1).toString(), { anchor:"Left" }, endpointTargetOptions );
                            iter++;
                            bot++;
                        }
                    }
                    else {
                        console.log(obj.error);
                    }
                }
            });


        });
    }

    function containsObject(obj, list) {
        var x;
        for (x in list) {
            if (list.hasOwnProperty(x)) {
                if(list[x].key.localeCompare(obj.key) === 0 && list[x].value.localeCompare(obj.value) === 0)
                return true;
            }
        }

        return false;
    }

</script>
