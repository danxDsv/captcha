<?php
function calc() {
    //liste de nombres en toute lettre
    $liste = array('zero', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf', 'dix', 'onze', 'douze', 'treize',
                    'quatorze', 'quinze', 'seize', 'dix-sept', 'dix-huit', 'dix-neuf', 'vingt');

    //tirage de l'opérateur 0->plus ; 1->moins
    $op = rand(0,1);

    //tirage de 2 chiffres aléatoire entre 0 et 10 
    $nb1 = rand(0,10);
    $nb2 = rand(0,10);
    //resultat du calcul en chiffre et en lettre + phrase à afficher
    if ($op==0) {
        $resultat = $nb1 + $nb2;
        $resultatLettre = $liste[$resultat];
        $txt = $liste[$nb1].' plus '.$liste[$nb2];
    } else {
        //if pour ne pas avoir de résultat négatif pour la soustraction
        if ($nb1 >= $nb2) {
            $resultat = $nb1 - $nb2;
            $resultatLettre = $liste[$resultat];
            $txt = $liste[$nb1].' moins '.$liste[$nb2];
        } else {
            $resultat = $nb2 - $nb1;
            $resultatLettre = $liste[$resultat];
            $txt = $liste[$nb2].' moins '.$liste[$nb1];
        }       
    }
    return array($resultat, $resultatLettre, $txt);
}

function captcha() {
    list($resultat, $resultatLettre, $txt) = calc();
    $_SESSION['captcha'] = $resultat;
    $_SESSION['captchaLettre'] = $resultatLettre;
    return $txt;
}

?>