<?php
function calc($operateur2)
{
    //liste de nombres en toute lettre
    $liste = array('zero', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf', 'dix',
                    'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize', 'dix-sept', 'dix-huit', 'dix-neuf', 'vingt',
                    'vingt-et-un', 'vingt-deux', 'vingt-trois', 'vingt-quatre', 'vingt-cinq', 'vingt-six', 'vingt-sept',
                    'vingt-huit', 'vingt-neuf', 'trente');

    //tirage de l'opérateur 0->plus ; 1->moins
    $op = rand(0, 1);

    //tirage de 2 chiffres aléatoire entre 0 et 10
    $nb1 = rand(0, 10);
    $nb2 = rand(0, 10);
    //resultat du calcul en chiffre et en lettre + phrase à afficher
    if ($op==0) {
        $resultat = $nb1 + $nb2;
        $txt = array($nb1, 'plus', $nb2);
    } else {
        //if pour ne pas avoir de résultat négatif pour la soustraction
        if ($nb1 >= $nb2) {
            $resultat = $nb1 - $nb2;
            $txt = array($nb1, 'moins', $nb2);
        } else {
            $resultat = $nb2 - $nb1;
            $txt = array($nb2, 'moins', $nb1);
        }
    }
    //ajout d'un operateur
    if ($operateur2) {
        //tirage
        $op2 = rand(0, 1);
        $nb3 = rand(0, 10);
        //tirage plus
        if ($op2==0) {
            $resultat += $nb3;
            array_push($txt, 'plus', $nb3);
        } else {
            //tirage moins
            if ($resultat >= $nb3) {
                $resultat -= $nb3;
                array_push($txt, 'moins', $nb3);
            } else {
                $nb3 = rand(0, $resultat);
                $resultat -= $nb3;
                array_push($txt, 'moins', $nb3);
            }
        }
    }
    $resultatLettre = $liste[$resultat];
    return array($resultat, $resultatLettre, $txt);
}

function captcha($operateur2)
{
    list($resultat, $resultatLettre, $txt) = calc($operateur2);
    $_SESSION['captcha'] = $resultat;
    $_SESSION['captchaLettre'] = $resultatLettre;
    return $txt;
}

function verifCaptcha($limiteTps, $nbMaxForm, $limiteErreur, $tpsPunition)
{
    //si le captcha a été envoyé et qu'il n'est pas vide ou pour 0 que c'est une valeur numérique
    if (isset($_POST["captcha"]) && (is_numeric($_POST["captcha"]) || !empty($_POST["captcha"]))) {

        //si le résultat en chiffre et en lettre sont faux
        if (($_POST["captcha"] != $_SESSION["captcha"]) && (strcasecmp($_POST["captcha"], $_SESSION["captchaLettre"]) != 0)) {
            verifNbErreur($tpsPunition, $limiteErreur);
        } else {
            //supprimer resultat pour que le resultat puisse changer avec retour en arrière
            unset($_SESSION["captcha"]);
            unset($_SESSION["captchaLettre"]);
            //Supprime les sauvegardes du formulaire s'il est réussi
            unset($_SESSION["inscription"]["nom"]);
            unset($_SESSION["inscription"]["prenom"]);
            //A COMPLETER SI AJOUT D'AUTRES CHAMPS
            
            verifNbErreur2($tpsPunition, $limiteErreur, $limiteTps, $nbMaxForm);
        }
    }
}

function afficher($data)
{
    //affichage des opérateurs
    if ($data == "plus") {
        echo '<img src="img/plus.png" id="nbr" alt="plus"/>';
    } elseif ($data == "moins") {
        echo '<img src="img/moins.png" id="nbr" alt="moins"/>';
    } else {
        //affichage des nombres
        $taille = strlen($data);
        //si plusieurs chiffres
        if ($taille > 1) {
            //decompose
            $tab = str_split($data);
            for ($i=0; $i < $taille ; $i++) {
                echo '<img src="img/'.$tab[$i].'.png" id="nbr" alt="'.$tab[$i].'"/>';
            }
        } else {
            echo '<img src="img/'.$data.'.png" id="nbr" alt="'.$data.'"/>';
        }
    }
}
?>