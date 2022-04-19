<?php

//fonction pour recup ip
function get_ip(){
    $ip = $_SERVER["REMOTE_ADDR"];
    return $ip;
}

//permet de noter l'ip du spam dans un txt pour le ralentir à court terme
function blacklist(){
    //Recuperation de l'ip
    $ip = get_ip();

    //compteur de spam
    cptPlus();

    //Ouverture du fichier blacklist en ecriture (a : pointeur fin de fichier) et en lecture
    $fa = fopen("ips.txt", "a");
    $fr = fopen("ips.txt", "r");
    $filer = fgets($fr, 4096);

    //Recherche si ip est dans la blacklist
    //si oui -> out
    if (preg_match('.^'.preg_quote($ip).'$.m', $filer)) {
        fclose($fa);
        fclose($fr); 
        header('location: aurevoir.php');
    } else { 
        //si pas trouvée -> écriture puis out
        fputs ($fa, "$ip\n");
        //echo ("ecriture");
        fclose($fa);
        fclose($fr); 
        header('location: aurevoir.php');
    } 
}

//verification de la blacklist dans chaque page
function blacklistFORM(){
    //Recuperation de l'ip
    $ip = get_ip();

    //Ouverture du fichier blacklist
    $fr = fopen("ips.txt", "r");
    $filer = fgets($fr, 4096);

    //Recherche si ip est dans la blacklist
    //si oui -> out
    if (preg_match('.^'.preg_quote($ip).'$.m', $filer)) {
        fclose($fr); 
        header('location: aurevoir.php');
    }
}  

function captcha(){
    $limiteSpam = 5;
    $captcha = false;

    $fc = fopen("cpt.txt", "r");
    $valSpam = fgets($fc, 4096);

    if ($valSpam >= $limiteSpam) {
        $captcha = true;
    }

    fclose($fc); 
    return $captcha;
    //ouverture cpt.txt en lecture
    //lire val et comparer à la limite
    //si cpt >= limit -> captcha = true
    //return captcha
}

//fonction permettant d'incrémenter le compteur de spam
function cptPlus(){

    //récuperation de la valeur du fichier
    $cpt = file_get_contents("cpt.txt");
    $cpt = trim($cpt);
    //incrémentation
    $cpt = $cpt + 1;

    //ouverture + écriture + fermeture
    $fcpt = fopen("cpt.txt", "w+");
    fputs ($fcpt, $cpt);
    fclose($fcpt); 
}

function resetCpt(){
    //si date > 1 semaine -> cpt = 0
}
?>