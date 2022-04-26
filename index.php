<?php
session_start();

include 'fonction.php';

blacklistFORM();
resetCpt();

//supp le compteur de formulaire si ça fait plus de 24h
if (isset($_SESSION['start'])) {
	if ((time()-$_SESSION['start']) > 60*2) {
		unset($_SESSION['start']);
    	unset($_SESSION['nbForm']);
		echo 'reset';
	}
} else {
	$_SESSION['start'] = time();
}

//variable session qui compte le nombre de formulaire transmis
if (!isset($_SESSION["nbForm"])) {
    $_SESSION["nbForm"] = 0;
}
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
</body>
<script src="js/script.js"></script>
</html>