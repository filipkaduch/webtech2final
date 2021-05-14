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
    <h2>Dokumentácia</h2>

    <p>
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
        Krátke a viaceré otázky:
    </p>
    <br>
    <p>
        Informácie pre učiteľa:
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
        Krátke a viaceré otázky, informácie pre učiteľa

        Kadúch:
        Kresliace a párovacie otázky, zadefinovanie viacerých testov

        Arvaj:
        Prihlasovanie a registrácia, ukončenie testu, docker

        Finalizácia projektu bola robená spoločne.

    </p>


</div>
<br>
<button class="btn btn-block bg-info my-3" onclick="location.href='index.php'">Späť na hlavnú stránku</button>
</body>


</html>