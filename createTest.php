
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "controller/controller.php";
$controller = new Controller();

$newId = $controller->getNewTestId();
echo "<div id='testId' style='display: none;'>".$newId."</div>";

$questions = $controller->getTestQuestions($newId);

?>
<html lang="sk">

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/konva@7.2.5/konva.min.js"></script>
    <script src="node_modules/@jsplumb/core/js/jsplumb.core.umd.js"></script>
    <script src="node_modules/@jsplumb/browser-ui/js/jsplumb.browser-ui.umd.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>WEBTECH2 - final</title>
</head>

<body>

<header>
    <h1 style="margin: 20px;">WEBTECH2 - final</h1>
</header>




<div class="container my-3">
    <h1>Pohlad ucitela - vytvorenie testu</h1>
    <div class="row">
        <div class="row justify-content-center d-inline-flex my-5">
            <button type="button" class="btn btn-secondary mr-1" onclick="show('indexUcitel')">Testy</button>
            <button class="btn btn-danger" onclick="location.href='logout.php'">Log Out</button>
        </div>
    </div>
</div>


<div class="container border rounded bg-info mb-5">
    <div class="row m-3">
        <div class="col-6">
            <div class="form-group" style="display: contents;">
                <label for="testName">Nazov testu: </label>
                <input type="text" class="form-control" id="testName" name="testName">
                <label for="time">Trvanie testu (v minutach): </label>
                <input type="number" class="form-control" name="time" id="time" min="5" max="180" step="5">
                <label for="startTimeDate">Start testu datum: </label>
                <input type="date" class="form-control" id="startTimeDate" name="startTimeDate">
                <label for="startTime">Start testu cas (HH:mm): </label>
                <input type="text" class="form-control" id="startTime" name="startTime">
            </div>
            <?php
                echo "<button class='btn btn-block btn-primary mt-2' onclick='saveTest()'>Ulozit test</button>";
                echo "<button class='btn btn-block btn-warning mt-2' onclick='deleteTest()'>Zmazat test</button>"
            ?>
        </div>
        <div class="col-6">
            <div class="row m-2">
                <button type="button" class="btn btn-secondary mr-1" onclick="showModal('myModalAnswer')">Pridat otazku s otvorenou odpovdeou +</button>
            </div>
            <div class="row m-2">
                <button type="button" class="btn btn-secondary mr-1" onclick="showModal('myModalOptions')">Pridat otazku s moznostami +</button>
            </div>
            <div class="row m-2">
                <button type="button" class="btn btn-secondary mr-1" onclick="showModal('myModal')">Pridat kresliacu otazku +</button>
            </div>
            <div class="row m-2">
                <button type="button" class="btn btn-secondary mr-1" onclick="showModal('myModal2')">Pridat parovaciu otazku +</button>
            </div>
        </div>
    </div>
    <div class="questions">
        <table class="table table-light">
            <thead class="thead-dark">
                <th>Id</th>
                <th>Nazov</th>
                <th>Typ</th>
                <th>Akcia</th>
            </thead>
            <tbody id="tableBody">
            <?php
            foreach($questions as $row) {
                echo "<tr><th>".$row["id"]."</th><th>".$row["name"]."</th><th>".$row["type"]."</th><th><button class='btn btn-warning' onclick='deleteQuestion(".$row["id"].")'>Zmazat</button></th></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<!-- modal pre otazku s otvorenou odpovedou -->
<div id="myModalAnswer" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="name" class="modal-title">Pridanie otazky s otvorenou odpovedou</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    Nazov otazky: <input type="text" class="form-control" id='questionName3' name="questionName3">
                </div>
                <div class="form-group">
                    Zadanie: <input type="textarea" class="form-control" name="questionText3" id='questionText3'>
                </div>
                <div class="form-group">
                    Spravna odpoved: <input type="text" class="form-control" id="answer" name="answer">
                </div>
                <button class="btn btn-primary" type="button" name="submit" onclick="addAnswer()">Pridat odpoved +</button>
                <!-- <div id="container"></div> -->
                <?php
                // $answers = $controller->getAnswers($questionID);
                ?>
                <div class="mt-2">
                    <table class="">
                        <thead class="">
                            <th>Spravne odpovede:</th>
                        </thead>
                        <tbody id="tableAnswers">
                        <?php
                        // foreach($answers as $row) {
                        //     echo "<tr><th>".$row["answer"]."</th></tr>";
                        // }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" name="submit" onclick="addAnswerQuestion()">Ulozit otazku</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- modal pre otazku s moznostami -->
<div id="myModalOptions" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="name" class="modal-title">Pridanie otazky s moznostami</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    Nazov otazky: <input type="text" class="form-control" id='questionName4' name="questionName4">
                </div>
                <div class="form-group">
                    Zadanie: <input type="textarea" class="form-control" name="questionText4" id='questionText4'>
                </div>
                <h5>Moznosti</h5>
                <div class="form-group row">
                    <label for="option1" class="col-sm-2 col-form-label">a)</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="option1" name="option1">
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="option1Check">
                        <label class="form-check-label" for="option1Check">
                            Oznacit za spravnu
                        </label>
                    </div>
                    </div>

                </div>
                <div class="form-group row">
                    <label for="option2" class="col-sm-2 col-form-label">b)</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="option2" name="option2">
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="option2Check">
                        <label class="form-check-label" for="option2Check">
                            Oznacit za spravnu
                        </label>
                    </div>
                    </div>

                </div>
                <div class="form-group row">
                    <label for="option3" class="col-sm-2 col-form-label">c)</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="option3" name="option3">
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="option3Check">
                        <label class="form-check-label" for="option3Check">
                            Oznacit za spravnu
                        </label>
                    </div>
                    </div>

                </div>
                <div class="form-group row">
                    <label for="option4" class="col-sm-2 col-form-label">d)</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="option4" name="option4">
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="option4Check">
                        <label class="form-check-label" for="option4Check">
                            Oznacit za spravnu
                        </label>
                    </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" name="submit" onclick="addOptionsQuestion()">Ulozit otazku</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="name" class="modal-title">Pridanie kresliacej otazky</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    Nazov otazky: <input type="text" class="form-control" id='questionName' name="questionName">
                </div>
                <div class="form-group">
                    Zadanie: <input type="textarea" class="form-control" name="questionText" id='questionText'>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" name="submit" onclick="addPaintQuestion()">Ulozit otazku</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="myModal2" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="name" class="modal-title">Pridanie parovacej otazky</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    Nazov otazky: <input type="text" class="form-control" id='questionName2' name="questionName2">
                </div>
                <div class="form-group">
                    Zadanie: <input type="textarea" class="form-control" name="questionText2" id='questionText2'>
                </div>
                <div class="form-group">
                    Kluc: <input type="text" class="form-control" id="key" name="key">
                    Hodnota: <input type="text" class="form-control" id="value" name="value">
                </div>
                <button class="btn btn-primary" type="button" name="submit" onclick="addPair()">Pridat par +</button>
                <div class="jtk-demo-main">
                    <div class="" id="canvas" style="height: 600px;">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" name="submit" onclick="addPairQuestion()">Ulozit otazku</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="container bg-white border">
    <div class="row bg-info">

    </div>
</div>

<script src="script/script.js"></script>
<script src="script/jsplumb.js"></script>

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

    .window {
        height: 40px;
        width: 40px;
        border: 2px solid black;
    }
</style>


<script type="text/javascript">

    let i = 1;
    let b = 2;
    let pairContent = [];



    //otvorena odpoved
    function addAnswerQuestion() {
        $('#myModalAnswer').modal('hide');
        let id = $('#testId').text();
        let text = $('#questionText3').val();
        let questionName = $('#questionName3').val();
        let answer = $('#answer').val();
        jQuery.ajax({
            type: "POST",
            url: 'saveAnswerQuestion.php',
            dataType: 'json',
            data: {testId: id, name: questionName, text: text, content: answer},

            success: function (obj, textstatus) {
                if( !('error' in obj) ) {
                    console.log(obj);
                    $('#tableBody').text('');
                    for(let i = 0; i < obj.length; i++) {
                        $('#tableBody').append('<tr><th>' + obj[i].id + '</th><th>'+obj[i].name+ '</th><th>' + obj[i].type + '</th><th><button class=\'btn btn-warning\' onclick=\'deleteQuestion('+obj[i].id+')\'>Zmazat</button>');
                    }
                }
                else {
                    console.log(obj.error);
                }
            }
        });
    }

    //pridat odpoved - nefunguje tak som jebal na to
    function addAnswer() {
        let id = $('#testId').text();
        let answer = $('#answer').val();
        jQuery.ajax({
            type: "POST",
            url: 'saveAnswer.php',
            dataType: 'json',
            data: {testId: id, content: answer},

            success: function (obj, textstatus) {
                if( !('error' in obj) ) {
                    console.log(obj);
                    $('#tableAnswers').text('');
                    $('#tableAnswers').append('<tr><th>' + obj[i].answer + '</th></tr>');
                }
                else {
                    console.log(obj.error);
                }
            }
        });
    }

    //otazka s moznostami
    function addOptionsQuestion() {
        $('#myModalOptions').modal('hide');
        let id = $('#testId').text();
        let text = $('#questionText4').val();
        let questionName = $('#questionName4').val();
        let option1 = $('#option1').val();
        let option1Check = $('#option1Check').is(":checked");
        let option2 = $('#option2').val();
        let option2Check = $('#option2Check').is(":checked");
        let option3 = $('#option3').val();
        let option3Check = $('#option3Check').is(":checked");
        let option4 = $('#option4').val();
        let option4Check = $('#option4Check').is(":checked");
        let json = {option1:option1, option1Check:option1Check, option2:option2, option2Check:option2Check,
             option3:option3, option3Check:option3Check, option4:option4, option4Check:option4Check};
        let myJSON = JSON.stringify(json);
        console.log(myJSON);
        jQuery.ajax({
            type: "POST",
            url: 'saveOptionsQuestion.php',
            dataType: 'json',
            data: {testId: id, name: questionName, text: text, content: myJSON},

            success: function (obj, textstatus) {
                if( !('error' in obj) ) {
                    console.log(obj);
                    $('#tableBody').text('');
                    for(let i = 0; i < obj.length; i++) {
                        $('#tableBody').append('<tr><th>' + obj[i].id + '</th><th>'+obj[i].name+ '</th><th>' + obj[i].type + '</th><th><button class=\'btn btn-warning\' onclick=\'deleteQuestion('+obj[i].id+')\'>Zmazat</button>');
                    }
                }
                else {
                    console.log(obj.error);
                }
            }
        });
    }



    function addPairQuestion() {
        $('#myModal2').modal('hide');
        let id = $('#testId').text();
        let text = $('#questionText2').val();
        let questionName = $('#questionName2').val();
        let myJSON = JSON.stringify(pairContent);

        jQuery.ajax({
            type: "POST",
            url: 'savePairQuestion.php',
            dataType: 'json',
            data: {testId: id, name: questionName, text: text, content: myJSON},

            success: function (obj, textstatus) {
                console.log(obj);
                if( !('error' in obj) ) {
                    $('#tableBody').text('');
                    for(let i = 0; i < obj.length; i++) {
                        $('#tableBody').append('<tr><th>' + obj[i].id + '</th><th>'+obj[i].name+ '</th><th>' + obj[i].type + '</th><th><button class=\'btn btn-warning\' onclick=\'deleteQuestion('+obj[i].id+')\'>Zmazat</button>');
                    }
                }
                else {
                    console.log(obj.error);
                }
            }
        });
    }

    function addPaintQuestion() {
        $('#myModal').modal('hide');
        let id = $('#testId').text();
        let text = $('#questionText').val();
        let questionName = $('#questionName').val();
        let contents = $('#contents').text();
        jQuery.ajax({
            type: "POST",
            url: 'savePaintQuestion.php',
            dataType: 'json',
            data: {id: id, name: questionName, text: text, content: ''},

            success: function (obj, textstatus) {
                if( !('error' in obj) ) {
                    console.log(obj);
                    $('#tableBody').text('');
                    for(let i = 0; i < obj.length; i++) {
                        $('#tableBody').append('<tr><th>' + obj[i].id + '</th><th>'+obj[i].name+ '</th><th>' + obj[i].type + '</th><th><button class=\'btn btn-warning\' onclick=\'deleteQuestion('+obj[i].id+')\'>Zmazat</button>');
                    }
                    // window.location.reload();
                }
                else {
                    console.log(obj.error);
                }
            }
        });
    }

    function saveTest() {
        let testName = $('#testName').val();
        let time = $('#time').val();
        let startTime = $('#startTime').val();
        let startTimeDate = $('#startTimeDate').val();
        let id = $('#testId').text();
        //let contents = JSON.stringify(pairContent);
        jQuery.ajax({
            type: "POST",
            url: 'saveTest.php',
            dataType: 'json',
            data: {id: id, name: testName, startTime: startTime, startTimeDate: startTimeDate, time: time},

            success: function (obj, textstatus) {
                if( !('error' in obj) ) {
                    console.log(obj);
                    window.location = "https://wt70.fei.stuba.sk/webtech-final/indexUcitel.php";
                }
                else {
                    console.log(obj.error);
                }
            }
        });
    }

    function deleteTest() {
        let id = $('#testId').text();
        jQuery.ajax({
            type: "POST",
            url: 'deleteTest.php',
            dataType: 'json',
            data: {id: id},

            success: function (obj, textstatus) {
                if( !('error' in obj) ) {
                    console.log(obj);
                    window.location = "https://wt70.fei.stuba.sk/webtech-final/";
                }
                else {
                    console.log(obj.error);
                }
            }
        });
    }

    function deleteQuestion(id) {
        jQuery.ajax({
            type: "POST",
            url: 'deleteQuestion.php',
            dataType: 'json',
            data: {questionId: id},

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

    function showModal(a) {
        $('#key').val('');
        $('#value').val('');
        $('#questionText').val();
        $('#questionName').val();
        $('#questionText2').val();
        $('#questionName2').val();
        //
        $('#answer').val('');
        $('#questionText3').val();
        $('#questionName3').val();
        $('#questionText4').val();
        $('#questionName4').val();
        //
        $('#'+a).modal('show');
    }

    function addPair() {
        let key = $('#key').val();
        let value = $('#value').val();

        jsPlumb.ready(function() {
            let bottom = i * 10;
            $('#canvas').append("<div class='window' id='"+"dragDropWindow"+i.toString()+"' style='position: relative; bottom: -"+bottom+"px'>"+key+"</div>");
            $('#canvas').append("<div class='window' id='"+"dragDropWindow"+(i+1).toString()+"' style='position: relative; right: -400px; bottom: -"+bottom+"px'>"+value+"</div>");
            pairContent.push({key: key, value: value});
            var instance = jsPlumb.getInstance({
                DragOptions: { cursor: 'pointer', zIndex: 2000 },
                PaintStyle: { stroke: '#666' },
                EndpointHoverStyle: { fill: "orange" },
                HoverPaintStyle: { stroke: "orange" },
                EndpointStyle: { width: 20, height: 16, stroke: '#666' },
                Endpoint: "Rectangle",
                Container: "canvas"
            });
            var endpointSourceOptions = { endpoint:["Rectangle",{ width:10, height:10, position: 'relative'}], isSource:true,  beforeDrop: function (params) {
                    return confirm("Spojit " + params.sourceId + " s " + params.targetId + "? Potvrdenim sa uz nemozete vratit spat.");
                }
            };
            var endpointTargetOptions = { endpoint:["Rectangle",{ width:10, height:10, position: 'relative'}], isTarget:true,  beforeDrop: function (params) {
                    return confirm("Spojit " + params.sourceId + " s " + params.targetId + "? Potvrdenim sa uz nemozete vratit spat.");
                }
            };
            var window3Endpoint = jsPlumb.addEndpoint('dragDropWindow'+i.toString(), { anchor:"Right" }, endpointSourceOptions );
            var window4Endpoint = jsPlumb.addEndpoint('dragDropWindow'+b.toString(), { anchor:"Left" }, endpointTargetOptions );
            instance.importDefaults({
                Connector : [ "Bezier", { curviness: 35 } ],
                Anchors : [ "Top" ]
            });

            /*jsPlumb.connect({
                source:window3Endpoint,
                target:window4Endpoint,
                connector: [ "Bezier", { curviness:35 } ],
                paintStyle:{ strokeWidth:10, stroke:'yellow' }
            });*/


/*
            var endpointOptions = {
                connector : "Straight",
                connectorStyle: { strokeWidth:20, stroke:'blue' },
                scope:"blueline",
                dragAllowedWhenFull:false
            };
            var window3Endpoint = jsPlumb.addEndpoint('dragDropWindow1', { anchor:"Top" }, endpointOptions );
            var window4Endpoint = jsPlumb.addEndpoint('dragDropWindow2', { anchor:"BottomCenter" }, endpointOptions );*/
        });
        b += 2;
        i+=2;
    }






</script>