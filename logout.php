<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();
unset($_SESSION["user_login"]);
//unset($_SESSION['prihlaseny']);

//Destroy entire session
session_destroy();

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
    <div class="col-lg-12 header">
        <h1>Odhlásenie</h1>
        <br>
    </div>
    <div class="alert alert-danger" role= alert>Odhlásenie prebehlo úspešne!</div>
</div>
<div class="container">
    <div class="row">
        <button class="btn btn-block bg-info my-3" onclick="location.href='loginZiak.php'">Žiak - prihlásenie</button>
    </div>
    <div class="row">
        <button class="btn btn-block bg-info my-3" onclick="location.href='ucitelLogin.php'">Učiteľ - prihlásenie</button>
    </div>
    <div class="row">
        <button class="btn btn-block bg-info my-3" onclick="location.href='register.php'">Učiteľ - registrácia</button>
    </div>
</div>
</body>

</html>
