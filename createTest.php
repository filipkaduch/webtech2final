
<?php



require_once "controller/controller.php";
$controller = new Controller();

$newId = $controller->getNewTestId() + 1;
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
                <label for="time">Trvanie testu: </label>
                <input type="number" class="form-control" name="time" id="time" min="5" max="180" step="5">
                <label for="startTimeDate">Start testu datum: </label>
                <input type="date" class="form-control" id="startTimeDate" name="startTimeDate">
                <label for="startTime">Start testu cas (HH:mm): </label>
                <input type="text" class="form-control" id="startTime" name="startTime">
            </div>
            <?php
                echo "<button class='btn btn-block btn-primary mt-2' onclick='saveTest('".$newId."')'>Ulozit test</button>";
                echo "<button class='btn btn-block btn-warning mt-2' onclick='deleteTest('".$newId."')'>Zmazat test</button>"
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
            <tbody>
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
                <div id="container"></div>
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

    let i = 1;

    let layer = new Konva.Layer();

    function addPairQuestion() {
        $('#myModal2').modal('hide');
        let id = $('#testId').text();
        let text = $('#questionText2').val();
        let questionName = $('#questionName2').val();
        let json = stage.toJSON();
        let myJSON = JSON.stringify(json);
        console.log(myJSON);
        //let contents = $('#contents').text();
        jQuery.ajax({
            type: "POST",
            url: 'savePairQuestion.php',
            dataType: 'json',
            data: {testId: id, name: questionName, text: text, content: myJSON},

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

    function addPaintQuestion() {
        $('#myModal').modal('hide');
        let id = $('#testId').text();
        let text = $('#questionText').val();
        let questionName = $('#questionName').val();
        //let contents = $('#contents').text();
        jQuery.ajax({
            type: "POST",
            url: 'savePaintQuestion.php',
            dataType: 'json',
            data: {testId: id, name: questionName, text: text, content: ''},

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

    function saveTest(id) {
        let testName = $('#testName').val();
        let time = $('#time').val();
        let startTime = $('#startTime').val();
        let startTimeDate = $('#startTimeDate').val();
        //let contents = $('#contents').text();
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
        stage.clear();
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

        let rectangleKey = new Konva.Group({
            x: i*25,
            y: i*25,
            width: 130,
            height: 25,
            draggable: true,
            stroke: 'black',
            strokeWidth: 2,
        });

        rectangleKey.add(new Konva.Rect({
            width: 130,
            height: 25,
            fill: 'lightblue'
        }));
        rectangleKey.add(new Konva.Text({
            text:key,
            fontSize: 18,
            fontFamily: 'Calibri',
            fill: '#000',
            width: 130,
            padding: 5,
            align: 'center'
        }));

        let rectangleValue = new Konva.Group({
            x: 25,
            y: 25,
            width: 130,
            height: 25,
            draggable: true,
            stroke: 'black',
            strokeWidth: 2,
        });

        rectangleValue.add(new Konva.Rect({
            width: 130,
            height: 25,
            fill: 'blue'
        }));
        rectangleValue.add(new Konva.Text({
            text:value,
            fontSize: 18,
            fontFamily: 'Calibri',
            fill: '#000',
            width: 130,
            padding: 5,
            align: 'center'
        }));
        layer.add(rectangleKey);
        layer.add(rectangleValue);
        stage.add(layer);
        i++;
    }

</script>