<?php

//fonction pour recuperer l'ip
function get_ip(){
    $ip = $_SERVER["REMOTE_ADDR"];
    return $ip;
}

//permet de noter l'ip du spam dans un txt pour le ralentir à court terme
function blacklist(){
    //Recuperation de l'ip
    $ip = get_ip();

    //compteur de spam
    cptPlus("cpt.txt");

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

//renvoie un boolean qui permet de savoir si on a besoin d'un captcha
function BoolCaptcha(){
    //variables initiales 
    $limiteSpam = 5;        //limite de spam
    $limiteVisiteur = 50;   //limite de visiteur 
    $captcha = false;       //booleen qui permet de gérer l'affichage

    //ouverture cpt.txt en lecture
    $fc = fopen("cpt.txt", "r");
    $fv = fopen("cptVisiteur.txt", "r");
    //lecture de la valeur
    $valSpam = fgets($fc, 4096);
    $valVisiteur = fgets($fv, 4096);
    //comparaison avec la limite
    if ($valSpam >= $limiteSpam || $valVisiteur >= $limiteVisiteur) {
        $captcha = true; //si val est >= on affichera
    }

    fclose($fc); 
    return $captcha;
}

//incrémente le compteur de spam
function cptPlus($filename){

    //récuperation de la valeur du fichier
    $cpt = file_get_contents($filename);
    $cpt = trim($cpt);
    //incrémentation
    $cpt = $cpt + 1;

    //ouverture + écriture + fermeture
    $fcpt = fopen($filename, "w+");
    fputs ($fcpt, $cpt);
    fclose($fcpt); 
}

//réinitialise le compteur si besoin
function resetCpt(){
    //date actuelle jour-mois-année
    $dateavt = date("d-m-Y", time());
    $date = new DateTime($dateavt);

    //récupération de la date des compteurs
    $dateCptA = file_get_contents("date.txt");
    $dateCptA = trim($dateCptA);
    $dateCpt = new DateTime($dateCptA);

    //si date > 1 semaine -> cpt = 0
    $interval = $dateCpt->diff($date);
    if ($interval->days >= 7) {
        //ouverture + écriture + fermeture
        $fcpt = fopen("cpt.txt", "w+");
        fputs ($fcpt, "0");
        fclose($fcpt); 
        //ouverture + écriture + fermeture
        $fcptV = fopen("cptVisiteur.txt", "w+");
        fputs ($fcptV, "0");
        fclose($fcptV); 
        //ouverture + écriture + fermeture
        $fdate = fopen("date.txt", "w+");
        fputs ($fdate, $dateavt);
        fclose($fdate); 
    }
}
?>