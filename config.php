<?php

//CAPTCHA
$booleanCaptcha = true;
$limiteErreur = 3;
$tpsPunition = 60;//*5; //en secondes
//operateur en plus
$operateur2 = true;

//COMPTEURS
//activation des compteurs de visiteurs/spams -> permet seulement de compter
$compteur = true;
//active les limites pour gérer l'affichage du captcha
$limites = true;
//valeurs des limites
$limiteVisiteur = 0;
$limiteSpam = 0;

//POTS DE MIEL
//pot de miel CSS
$pmCSS = true;
$nomPmCSS = "validation";
//pot de miel JS
$pmJS = true;
$nomPmJS = "telephone";

//FORMULAIRE
//Nombre max de form pouvant être envoyés selon le temps ci dessous
$nbMaxForm = 3;
//temps en secondes
$limiteTps = 60;//*4;


?>