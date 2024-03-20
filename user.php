<?
session_start();
require 'classes.php';
$db = new BDD();
$susers= new SimpleUsers($db);

// une fois inscrit et arrivé sur page user.php: 
// accès à rien fond de page vierge/flou et messsage qui pop pour envoyer demande validation au validateur/admin
// si accepté, accès à la page. Sinon message de refus et apparition demande de validation. 
