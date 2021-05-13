
<?php



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
            <button type="button" class="btn btn-secondary mr-1" onclick="show('index')">Testy</button>
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
                <div class="form-group">
                    Pridat obrazok: <input type="file" class="form-control" id='contents' name="contents">
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
                    window.location = "https://wt70.fei.stuba.sk/webtech-final/";
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
        $('#'+a).modal('show');
    }

    function addPair() {
        let key = $('#key').val();
        let value = $('#value').val();

        jsPlumb.ready(function() {
            let bottom = i * 10;
            $('#canvas').append("<div class='window' id='"+"dragDropWindow"+i.toString()+"' style='position: relative; bottom: -"+bottom+"px'>"+key+"</div>");
            $('#canvas').append("<div class='window' id='"+"dragDropWindow"+b.toString()+"' style='position: relative; right: -400px; bottom: -"+bottom+"px'>"+value+"</div>");
            pairContent.push({key: key, value: value});
            var instance = jsPlumb.getInstance({
                DragOptions: { cursor: 'pointer', zIndex: 2000 },
                PaintStyle: { stroke: '#666' },
                EndpointHoverStyle: { fill: "orange" },
                HoverPaintStyle: { stroke: "orange" },
                isSource:true,
                isTarget:true,
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
        b+=2;
        i+=2;
    }






</script>