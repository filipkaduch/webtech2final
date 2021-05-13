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

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = $conn->prepare("SELECT * FROM ucitel WHERE username=:username");
    $query->bindParam("username", $username, PDO::PARAM_STR);
    $query->execute();
    var_dump($_POST);
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
    <h2>Registrácia učiteľa</h2>
    <div class="col-lg-12">

        <?php
        if (isset($_SESSION['user_login'])) {
            echo "<div class=" . "'p-3 mb-2 bg-secondary text-white'>Prihlásený úžívateľ: " . $_SESSION['user_login'] . "</div>";
        }
        ?>

        <?php
        if (isset($_POST['register'])) {
            if ($query->rowCount() > 0) {
                echo "<div class=" . "'alert alert-danger'" . " role= alert" . ">Tento username už je v databáze</div>";
            }
            if ($query->rowCount() == 0) {
                $query = $conn->prepare("INSERT INTO ucitel(username, password) VALUES (:username, :password)");
                $query->bindParam("username", $username, PDO::PARAM_STR);
                $query->bindParam("password", $password, PDO::PARAM_STR);
                $result = $query->execute();
                if ($result) {
                    echo "<div class=" . "'alert alert-success'" . " role= alert" . ">Registrácia bola úspešná!</div>";
                } else {
                    echo "<div class=" . "'alert alert-danger'" . " role= alert" . ">Registrácia neprebehla! Došlo k chybe!</div>";
                }
            }
        }
        ?>

        <form method="post" action="register.php" name="signup-form">

            <div class="form-element">
                <label>Meno:</label>
                <br>
                <input type="text" name="username" pattern="[a-zA-Z0-9]+" value="<?php if (isset($_POST['register'])) echo $username ?>" required />
            </div>
            <div class="form-element">
                <label>Heslo:</label>
                <br>
                <input type="password" name="password" pattern="[a-zA-Z0-9]+" value="<?php if (isset($_POST['register'])) echo $password ?>" required />
            </div>
            <button class="btn btn-success" type="submit" name="register" value="register">Register</button>
        </form>
        <br>
        <button class="btn btn-block bg-info my-3" onclick="location.href='indexLogin.php'">Späť na hlavnú stránku</button>
    </div>

</div>
</body>

</html>