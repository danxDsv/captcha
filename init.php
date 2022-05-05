<?php
session_start();

include 'fonction.php';
include 'captcha.php';
include 'config.php';

//check blacklist sauf sur aurevoir pour éviter boucle infinie
if ($_SERVER["SCRIPT_NAME"] != "/aurevoir.php") {
	blacklistFORM();
}
resetCpt();
$needCaptcha = needCaptcha($booleanCaptcha, $limites, $limiteSpam, $limiteVisiteur, $compteur);

//supp le compteur de formulaire si ça fait plus que la limite
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
    cptPlus("cptVisiteur.txt", $compteur);
}
//reset chrono erreur
if (isset($_SESSION["punition"])) {
	if ((time()-$_SESSION["punition"]) > $tpsPunition) {
		unset($_SESSION["punition"]);
    	unset($_SESSION["erreur"]);
	}
}
//compteur d'erreur pour le captcha
if (!isset($_SESSION["erreur"])) {
    $_SESSION["erreur"] = 0;
}
//debut chrono trop d'erreurs
if (!isset($_SESSION["punition"])) {
    if ($_SESSION["erreur"] > $limiteErreur) {
        $_SESSION["punition"] = time();
    }
}
?>