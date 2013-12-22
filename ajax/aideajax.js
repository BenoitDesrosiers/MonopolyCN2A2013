/*
 -- Par Tommy Teasdale
*/
var ajax;   // Connection AJAX
var nbAide; // Nombre de message d'aide dans la base de donnée

// Récupérer un message de la BD
function getAide(){
    
    // Générer un nombre aléatoire entre 1 et le nombre de messages d'aide
    var randnum=Math.floor(Math.random()*nbAide)+1;
    
    ajax.onreadystatechange = function(){
        if(ajax.readyState == 4 && ajax.status == 200){
            texte=ajax.responseText;
            alert(texte);
        }
    }
    
    ajax.open("POST",URLbase+"ajax/aideajax.php");
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.send("action=getaide&aide="+randnum);
}

// Obtenir le nombre de message d'aide dans la bd
function getNbAide(){
    
    ajax.onreadystatechange = function(){
        if(ajax.readyState == 4 && ajax.status == 200){
            nbAide=parseInt(ajax.responseText);
        }
    }
    
    ajax.open("POST",URLbase+"ajax/aideajax.php");
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.send("action=getnbaide");
}

window.addEventListener('load',function(){
    
    // Créer l'instance XMLHttpRequest approprié pour le navigateur
    if(window.XMLHttpRequest){
        ajax = new XMLHttpRequest(); 
    }else if(window.ActiveXObject){ 
        try{
            ajax = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e){
            ajax = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }else{
        alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
        ajax = false;
        return 0;
    } 
    
    // Obtenir l'URI de base de la page
    array_URL = document.URL.split("/",4);
    URLbase=array_URL[0]+"\/"+array_URL[1]+"\/"+array_URL[2]+"\/"+array_URL[3]+"\/";
    
    // Attribut un Listener de l'évènement click au bouton d'aide
    var btnAide=document.getElementById('help');
    btnAide.addEventListener('click',getAide);
    
    // Obtenir le nombre de message d'aide dans la bd
    getNbAide();
});