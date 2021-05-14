<html lang="sk">

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>WEBTECH2 - final</title>
</head>

<body>

<header>
    <h1 class="m-5">WEBTECH2 - final</h1>
</header>

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
    <div class="d-flex justify-content-end mt-5">
        <button id="myBtn" class="btn btn-secondary">Dokumentácia</button>
    </div>

</div>


<div id="myModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Dokumentácia a rozdelenie uloh</h2>
            <span class="close">&times;</span>
        </div>
        <div class="modal-body">
            <p class="mt-3">
                V úvode dokumentácie by sme sa chceli ospravedlniť za nesplnenie niektorých požiadaviek projektu.
                5. člen nášho teamu nám dal dosť neskoro vedieť o tom, že svoje časti v projekte nevypracuje, tým pádom sme na ňom pracovali len štyria.
                Z tohoto dôvodu sme niektoré časti nestihli úplne dokončiť.
            </p>
            <br>
            <h3>Funkcionalita požiadaviek</h3>
            <p>
                Prihlasovanie a registrácia:
                Výber prihlasovania/registrácie je nastavený ako úvodná strana, teda index.php.
                V nej sú jednotlivé buttony, ktoré zmenia url na vybraný typ prihlásenia, registrácie alebo dokumentácie.
                Prihlásenie žiaka nie je možné ak zadáva nesprávny kod testu. Rovnako nieje možné prihlásenie učiteľa bez správnych údajov.
                Obe z týchto prihlásení presmerujú študenta/učiteľa na jeho časť stránky.
            </p>
            <br>
            <p>
                Otázky s otvorenou odpoveďou a možnosťami:<br>
                Učiteľ - Zadáva nazov a zadanie otázky a 4 možnosti z ktorých môže označiť za správne ľubovolný počet.<br>
                Vyhodnotené sú nasledovne: 1 bod za správne a -1 bod za nesprávne označenú(neoznačenú) možnosť.<br>
                Žiak - Zobrazené je zadanie otázky s inštrukciami k jej vyplneniu, odpoveď je zaznamenaná pri odovzdaní testu
            </p>
            <br>
            <p>
                Informácie pre učiteľa:
                Učiteľ môže nahliadnuť na priebeh testu kde sa zobrazia všetci študenti ktorí sa prihlásili s prístupovým
                kódom daného testu a spustili ho.
                Je zobrazená aj informácia či už študent test odovzdal.<br>
                V prípade odovzdaného testu vie učiteľ zobraziť žiakove odpovede s tým že automaticky vyhodnotené otázky budú už obodované.
            </p>
            <br>
            <p>
                Kresliace a párovacie otázky:
            </p>
            <br>
            <p>
                Zadefinovanie viacerých testov:
            </p>
            <br>
            <p>
                Ukončenie testu:
                Teste sa zobrazí až po spustení tlačidla štart, na tento button sa spustí odpočítavanie testu a zapíše sa aktuálny čas do databázy.
                Po stlačení buttonu na odovzdanie, alebo po vypršaní času na test sa odpovede pošlú učiteľovi a do databázy sa zapíše čas odovzdania.
                Button na odovzdanie odovzdá odpovede len v prípade že sú v teste uložené. Ak ich žiak v teste uložené nemá odovzdá sa test bez nich.
            </p>
            <br>
            <p>
                Nefunkčné/Nevypracované požiadavky :
                Matematické výrazy, export pdf, export csv, docker
            </p>
            <h3>Rozdelenie úloh </h3>
            <p>
                Košťál:
                Matematické výrazy, export pdf, export csv
                Košík:
                Otázky s otvorenou odpoveďou a možnosťami, informácie pre učiteľa
                Kadúch:
                Kresliace a párovacie otázky, zadefinovanie viacerých testov
                Arvaj:
                Prihlasovanie a registrácia, ukončenie testu, docker
                Finalizácia projektu bola robená spoločne.
            </p>
        </div>
        <div class="modal-footer">
            <h4></h4>
        </div>
    </div>
</div>


</body>

<style>

    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 50px; /* Location of the box */
        padding-bottom: 50px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        position: relative;
        background-color: #fefefe;
        margin: auto;
        padding: 0;
        border: 1px solid #888;
        width: 80%;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
        -webkit-animation-name: animatetop;
        -webkit-animation-duration: 0.4s;
        animation-name: animatetop;
        animation-duration: 0.4s
    }

    /* Add Animation */
    @-webkit-keyframes animatetop {
        from {top:-300px; opacity:0}
        to {top:0; opacity:1}
    }

    @keyframes animatetop {
        from {top:-300px; opacity:0}
        to {top:0; opacity:1}
    }

    /* The Close Button */
    .close {
        color: white;
        float: right;
        font-size: 30px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    .modal-header {
        padding: 2px 16px;
        background-color: #00000050;
    }

    .modal-body {padding: 2px 16px;}

    .modal-footer {
        padding: 2px 16px;
        background-color: #00000050;
    }

</style>

<script>

    var modal = document.getElementById("myModal");
    var btn = document.getElementById("myBtn");
    var span = document.getElementsByClassName("close")[0];
    btn.onclick = function() {
        modal.style.display = "block";
    }
    span.onclick = function() {
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

</script>

</html>

