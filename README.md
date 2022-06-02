# Actispam

Captcha antispam incluant différentes techniques antispam : pots de miel (CSS et JS), captcha de calcul mathématiques avec images que l'on peut configurer.


## Présentation

### Pages  

* init.php : fichier inclus dans chaque page permettant de gérer les variables de session et de vérifier la blacklist  
* captcha.php : fichier contenant toutes les fonctions en lien avec le captcha  
* fonction.php : fichier contenant toutes les autres fonctions (compteurs, blacklist, verification du formulaire)  
* traitement.php : gère le traitement du formulaire   

### Configuration du Système

Modifier les différentes variables du fichier *config.php* :  affichage / activation des différents éléments du système, fixation des limites et des différents temps d'attente.

* Captcha  
`* booleanCaptcha (booleen) : permet de gérer l'affichage du captcha de calcul`   
`* limiteErreur (int) : nombre max d'erreurs de captcha pour un utilisateur`   
`* tpsPunition (int) : temps d'attente en secondes lorsque l'utilisateur a dépassé le nombre max d'erreurs`    
`* operateur2 (booleen) : permet de passer à un calcul avec 3 chiffres et 2 opérateurs`    

* Pots de Miel   
`* pmCSS / pmJS (booleen) : permet de gérer l'activation des pots de miel`     
                                                                    
* Compteurs   
`* compteur (booleen) : active / désactive le fonctionnement des compteurs de visiteurs/spams`  
`* limites (booleen) : active / désactive les limites de compteurs qui permettent d'afficher le captcha en fonction des compteurs`  
`* limiteVisiteur / limiteSpam (int) : limites selon lesquelles le captcha est affiché si les limites sont activées`  

* Formulaire  
`* limiteTps (int) : temps de session en secondes qui permet de gérer le nombre max de formulaires que l'utilsateur peut envoyer`  
`* nbMaxForm (int) : nombre max de formulaires que l'utilisateur peut envoyer pendant le temps ci-dessus`   

### Modifications

Pour l'adapter à un site web :  
* modification des redirections.  
* vérifier *cpt.txt*, *cptVisiteurs.txt*, *date.txt*  
* adapter la page *formulaire.php* et *traitement.php* aux champs de formulaire voulus.
* inclure *init.php* dans les différentes pages du site.



## Fabriqué avec

* [VSC](https://code.visualstudio.com/) - Editeur de textes
* [PHP](https://www.php.net/) - 8.1.4
* [CSS]
* [JS]


## Versions


## License

