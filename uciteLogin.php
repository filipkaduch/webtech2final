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

    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = $conn->prepare("SELECT * FROM ucitel WHERE username=:username");
    $query->bindParam("username", $username, PDO::PARAM_STR);
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

    <h2>Prihlásenie učiteľa</h2>

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
                if ($password ==$result['password']) {
                    $_SESSION['user_login'] = $_POST['username'];
                    //doplniť presmerovanie na stránku učiteľa
                    header("location: https://wt70.fei.stuba.sk/webtech-final/index.php/.php");
                    echo "<div class=" . "'p-3 mb-2 bg-secondary text-white'>Prihlásený úžívateľ: " . $_SESSION['user_login'] . "</div>";
                } else {
                    echo "<div class=" . "'alert alert-danger'" . " role= alert" . ">Nesprávne meno alebo heslo!</div>";
                }
            }
        }

        ?>

        <form method="post" action="uciteLogin.php" name="signin-form">
            <div class="form-element">
                <label>Username:</label><br>
                <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
            </div>
            <div class="form-element">
                <label>Password:</label><br>
                <input type="password" name="password" required />
            </div>
            <br>
            <button class="btn btn-success" type="submit" name="login" value="login">Log In</button>

        </form>
        <br>
        <button class="btn btn-danger" onclick="location.href='logout.php'">Log Out</button>
        <br>
        <button class="btn btn-block bg-info my-3" onclick="location.href='indexLogin.php'">Späť na hlavnú stránku</button>

    </div>
</div>

</body>

</html>
