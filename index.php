<?php
session_start();

include 'fonction.php';

blacklistFORM();
resetCpt();

//variable session de visite
if (!isset($_SESSION["visite"])) {
    $_SESSION["visite"] = false;
}
//compteur de visite
if (!$_SESSION["visite"]) {
    $_SESSION["visite"] = true;
    cptPlus("cptVisiteur.txt");
}
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Formulaire</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav id="menu">
        <ul>
            
            <li><a href="traitement.php"><p>Traitement</p></a></li>
                        
            <li><a href="formulaire.php"><p>Formulaire</p></a></li>
                      
        </ul>
    </nav> 
    <script src="js/script.js"></script>
</body>
</html>