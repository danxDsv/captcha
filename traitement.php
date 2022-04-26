<?php
session_start();

include 'fonction.php';

blacklistFORM();
resetCpt();
$Boolcaptcha = BoolCaptcha();

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
            }/*else{
                echo "<script type=\"text/javascript\">";
                echo "alert('Complétez tous les champs');";
                echo "window.history.back();";
                echo "</script>";
            }*/ 
            
            //limite le nombre de formulaire à 3 par jour
            $_SESSION["nbForm"] += 1;
            if ($_SESSION["nbForm"] > 3) {
                echo "<script type=\"text/javascript\">";
                echo "alert('Vous ne pouvez plus envoyer de formulaire pour le moment');";
                echo "document.location.href='formulaire.php';";
                echo "</script>";
            }
            //si le captcha est présent
            if ($Boolcaptcha) {
                //si le captcha a été envoyé et qu'il n'est pas vide
                if (isset($_POST["captcha"]) && !empty($_POST["captcha"])) {
                    //si le résultat en chiffre et en lettre sont faux
                    if ( ($_POST["captcha"] != $_SESSION["captcha"]) && ($_POST["captcha"] != $_SESSION["captchaLettre"]) ) {
                        echo "<script type=\"text/javascript\">";
                        echo "alert('Le résultat du calcul est faux');";
                        echo "document.location.href='formulaire.php';";
                        echo "</script>";
                    } else {
                        //supprimer resultat pour que le resultat puisse changer avec retour en arrière
                        unset($_SESSION["captcha"]);
                        unset($_SESSION["captchaLettre"]);
                    }
                }
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
	<meta charset="utf-8" />
	<title></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
 
       
    if(isset($nom) && isset($prenom)){
        echo "<p>Bonjour $prenom $nom</p>";
        echo "<p>Formulaire validé</p>";
        echo $_SESSION["nbForm"]."\n";
    } 
     
       
?>
</body>
<script src="js/script.js"></script>
</html>
