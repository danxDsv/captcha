//pot de miel sur input telephone
document.getElementById('telephone').style.display = 'none';

function confirmer(){
    if (confirm("Êtes-vous sur de vouloir envoyer ce formulaire?")) {
        formulaire.submit();
    }
}