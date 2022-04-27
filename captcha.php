<?php
function calc()
{
    //liste de nombres en toute lettre
    $liste = array('zero', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf', 'dix', 'onze', 'douze', 'treize',
                    'quatorze', 'quinze', 'seize', 'dix-sept', 'dix-huit', 'dix-neuf', 'vingt');

    //tirage de l'opérateur 0->plus ; 1->moins
    $op = rand(0, 1);

    //tirage de 2 chiffres aléatoire entre 0 et 10
    $nb1 = rand(0, 10);
    $nb2 = rand(0, 10);
    //resultat du calcul en chiffre et en lettre + phrase à afficher
    if ($op==0) {
        $resultat = $nb1 + $nb2;
        $txt = $liste[$nb1].' plus '.$liste[$nb2];
    } else {
        //if pour ne pas avoir de résultat négatif pour la soustraction
        if ($nb1 >= $nb2) {
            $resultat = $nb1 - $nb2;
            $txt = $liste[$nb1].' moins '.$liste[$nb2];
        } else {
            $resultat = $nb2 - $nb1;
            $txt = $liste[$nb2].' moins '.$liste[$nb1];
        }
    }  
    $resultatLettre = $liste[$resultat];
    return array($resultat, $resultatLettre, $txt);
}

function captcha()
{
    list($resultat, $resultatLettre, $txt) = calc();
    $_SESSION['captcha'] = $resultat;
    $_SESSION['captchaLettre'] = $resultatLettre;
    return $txt;
}

function verifCaptcha($limiteTps) 
{
    //si le captcha a été envoyé et qu'il n'est pas vide ou pour 0 que c'est une valeur numérique
    if (isset($_POST["captcha"]) && (is_numeric($_POST["captcha"]) || !empty($_POST["captcha"]))) {

        //si le résultat en chiffre et en lettre sont faux
        if ( ($_POST["captcha"] != $_SESSION["captcha"]) && (strcasecmp($_POST["captcha"], $_SESSION["captchaLettre"]) != 0 )) {
            echo "<script type=\"text/javascript\">";
            echo "alert('Le résultat du calcul est faux');";
            echo "document.location.href='formulaire.php';";
            echo "</script>";
        } else {
            //supprimer resultat pour que le resultat puisse changer avec retour en arrière
            unset($_SESSION["captcha"]);
            unset($_SESSION["captchaLettre"]);
            
            verifNbForm($limiteTps);
        }
    }
}
?>