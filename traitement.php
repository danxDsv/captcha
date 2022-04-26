<?php
session_start();

include 'fonction.php';

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
                //si pas de captcha fin traitement du form
                if (!$BoolCaptcha) {
                    $_SESSION["nbForm"] += 1;
                    //limite le nombre de formulaire à 3 par jour
                    if ($_SESSION["nbForm"] > 3) {
                        //temps restant
                        $tps = ($limiteTps)-(time()-$_SESSION['start']);
                        $tpsMin = (int)($tps/60);
                        $tpsH = (int)($tpsMin/60);
                        
                        //message d'erreur
                        if ($tps < 60) {
                            echo "<script type=\"text/javascript\">";
                            echo "alert('Vous ne pouvez plus envoyer de formulaire pour le moment, Attendez '+'$tps'+' seconde(s)');";
                            echo "document.location.href='formulaire.php';";
                            echo "</script>";
                        } elseif ($tpsH >= 1) {
                            echo "<script type=\"text/javascript\">";
                            echo "alert('Vous ne pouvez plus envoyer de formulaire pour le moment, Attendez '+'$tpsH'+' heure(s)');";
                            echo "document.location.href='formulaire.php';";
                            echo "</script>";
                        } else {
                            echo "<script type=\"text/javascript\">";
                            echo "alert('Vous ne pouvez plus envoyer de formulaire pour le moment, Attendez '+'$tpsMin'+' minute(s)');";
                            echo "document.location.href='formulaire.php';";
                            echo "</script>";
                        }           
                    }
                    header('location: réussi.php');
                }
            } else {
                header('location: formulaire.php');
            }
            
            //si le captcha est présent
            if ($BoolCaptcha) {
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
                        $_SESSION["nbForm"] += 1;
                        //limite le nombre de formulaire à 3 par jour
                        if ($_SESSION["nbForm"] > 3) {
                            //temps restant
                            $tps = ($limiteTps)-(time()-$_SESSION['start']);
                            $tpsMin = (int)($tps/60);
                            $tpsH = (int)($tpsMin/60);
                            
                            //message d'erreur
                            if ($tps < 60) {
                                echo "<script type=\"text/javascript\">";
                                echo "alert('Vous ne pouvez plus envoyer de formulaire pour le moment, Attendez '+'$tps'+' seconde(s)');";
                                echo "document.location.href='formulaire.php';";
                                echo "</script>";
                            } elseif ($tpsH >= 1) {
                                echo "<script type=\"text/javascript\">";
                                echo "alert('Vous ne pouvez plus envoyer de formulaire pour le moment, Attendez '+'$tpsH'+' heure(s)');";
                                echo "document.location.href='formulaire.php';";
                                echo "</script>";
                            } else {
                                echo "<script type=\"text/javascript\">";
                                echo "alert('Vous ne pouvez plus envoyer de formulaire pour le moment, Attendez '+'$tpsMin'+' minute(s)');";
                                echo "document.location.href='formulaire.php';";
                                echo "</script>";
                            }           
                        }
                        header('location: réussi.php');
                    }
                }
            } else {
                header('location: réussi.php');
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