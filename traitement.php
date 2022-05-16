<?php
include 'init.php';

//verification submit
if (isset($_POST["send"])) {
    
    //verification pot de miel CSS vide
    if ((isset($_POST["validation"]) && empty($_POST["validation"])) || ($pmCSS == false)) {
        
        //verification pot de miel JS vide
        if ((isset($_POST["telephone"]) && empty($_POST["telephone"])) || ($pmJS == false)) {
            
            //verification que les champs sont remplis
            if (
                isset($_POST["nom"]) && !empty($_POST["nom"]) &&
                isset($_POST["prenom"]) && !empty($_POST["prenom"])
            ) {
                $nom = strip_tags($_POST["nom"]);
                $prenom = strip_tags($_POST["prenom"]);

                //si le captcha est présent
                if ($needCaptcha) {
                    //verifie le résultat du Captcha
                    verifCaptcha($limiteTps, $nbMaxForm, $limiteErreur, $tpsPunition);
                } else {
                    //Verifie le nb de form envoyés selon le temps indiqué
                    verifNbForm($limiteTps, $nbMaxForm);
                }
            } else {
                header('location: formulaire.php');
            }
        } else {
            blacklist($compteur);
        }
    } else {
        blacklist($compteur);
    }
} else {
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