<?php

//fonction pour recup ip
function get_ip(){
    if(isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
        $ip = $_SERVER["HTTP_CLIENT_IP"]; 
    } else {
        $ip = $_SERVER["REMOTE_ADDR"];
    }
    return $ip;
}

//permet de noter l'ip du spam dans un txt pour le ralentir à court terme
function blacklist(){
    //Recuperation de l'ip
    $ip = get_ip();

    //Ouverture du fichier blacklist
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
?>