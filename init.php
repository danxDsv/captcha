<?php
session_start();

include 'fonction.php';
include 'captcha.php';

blacklistFORM();
resetCpt();
$needCaptcha = needCaptcha();

//supp le compteur de formulaire si ça fait plus de 24h (60*60*24)
//limite de temps d'attente en secondes
$limiteTps = 60*4;
if (isset($_SESSION['start'])) {
	if ((time()-$_SESSION['start']) > $limiteTps) {
		unset($_SESSION['start']);
    	unset($_SESSION['nbForm']);
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