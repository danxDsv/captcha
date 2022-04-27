<?php
session_start();

include 'fonction.php';
include 'captcha.php';

blacklistFORM();
resetCpt();
$BoolCaptcha = BoolCaptcha();

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

//verification submit
if(isset($_POST["send"])){
    
    //verification pot de miel CSS vide
    if(isset($_POST["validation"]) && empty($_POST["validation"])){
        
        //verification pot de miel JS vide
        if (isset($_POST["telephone"]) && empty($_POST["telephone"])) {
            
            //verification que les champs sont remplis
            if(
                isset($_POST["nom"]) && !empty($_POST["nom"]) &&
                isset($_POST["prenom"]) && !empty($_POST["prenom"])
            ){
                $nom = strip_tags($_POST["nom"]);
                $prenom = strip_tags($_POST["prenom"]);

                //si le captcha est présent
                if ($BoolCaptcha) {
                    //verifie le résultat du Captcha
                    verifCaptcha($limiteTps);
                } else {
                    //Verifie le nb de form envoyés selon le temps indiqué
                    verifNbForm($limiteTps);
                }
            } else {
                header('location: formulaire.php');
            }
        }else{
            blacklist(); 
        }
    }else {
        blacklist();    
    }
}else{
    header('location: formulaire.php');
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
  <script src="js/script.js"></script>
</body>
</html>