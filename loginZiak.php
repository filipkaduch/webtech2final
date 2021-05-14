<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
try {
    $conn = new PDO("mysql:host=localhost;dbname=final", "xkaduch", "madrid");
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
if (isset($_POST['login'])) {

    $token = $_POST['token'];
    $firstname = $_POST['firstname'];
    $surname = $_POST['surname'];
    $query = $conn->prepare("SELECT * FROM tests WHERE token=:token");
    $query->bindParam("token", $token);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="utf-8">
    <title>WEBTECH2 - final</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>

<body>
<div class="container">

    <h2>Prihlásenie žiaka</h2>

    <div class="col-lg-12 telo">

        <?php
        if (isset($_SESSION['user_login'])) {
            echo "<div class=" . "'p-3 mb-2 bg-secondary text-white'>Prihlásený úžívateľ: " . $_SESSION['user_login'] . "</div>";
        }
        ?>

        <?php
        if (isset($_POST['login'])) {
            if (!$result) {

                echo "<div class=" . "'alert alert-danger'" . " role= alert" . ">Nesprávne meno alebo hesloo!</div>";
            } else {
                if ($token == $result['token']) {

                    $sql = "INSERT INTO users (token, firstname, surname, test_id) VALUES (?,?,?,?)";
                    $stm = $conn->prepare($sql);
                    $stm->execute([$token, $firstname, $surname, $result['id']]);
                    $ziak_id = $conn->lastInsertId();
                    $_SESSION['user_login'] = $_POST['firstname'];
                    $_SESSION['ziak_id'] = $ziak_id;
                    //doplniť presmerovanie na stránku učiteľa
                    header("location: https://wt70.fei.stuba.sk/webtech-final/indexZiak.php");

                } else {
                    echo "<div class=" . "'alert alert-danger'" . " role= alert" . ">Nesprávne meno alebo heslo!</div>";
                }
            }
        }

        ?>

        <form method="post" action="loginZiak.php" name="signin-form">
            <div class="form-element">
                <label>Kód:</label><br>
                <input type="text" name="token"  required />
            </div>
            <div class="form-element">
                <label>Meno:</label><br>
                <input type="text" name="firstname" pattern="[a-zA-Z0-9]+" required />
            </div>
            <div class="form-element">
                <label>Priezvisko:</label><br>
                <input type="password" name="surname" pattern="[a-zA-Z0-9]+" required />
            </div>
            <br>
            <button class="btn btn-success" type="submit" name="login" value="login">Log In</button>

        </form>
        <br>
        <button class="btn btn-danger" onclick="location.href='logout.php'">Log Out</button>
        <br>
        <button class="btn btn-block bg-info my-3" onclick="location.href='index.php'">Späť na hlavnú stránku</button>

    </div>
</div>

</body>

</html>
