<?php

session_start(); //démarrage de la session
//Bouton pour fermer la session

include 'config.php';
include 'inc/bdd.php';
include 'lib/tools.php';


if (isset($_GET['fermer'])) {
    session_destroy();
    setcookie(session_name(), session_id(), time() - 3600, '/', null, null, true); //annulation du cookie coté client
    header('Location: admin.php');
    exit();
}
if ((isset($_SESSION['auth'])) && ($_SESSION['auth'] == true)) { //voir ligne 38 pour les variables de session
    //Si l'adresse IP et le navigateur correspondent au variables entrée ligne 38
    if ($_SESSION['IPaddress'] != sha1($_SERVER['REMOTE_ADDR'])) {
        exit('attention risque d\'attaque');
    }
    if ($_SESSION['userAgent'] != sha1($_SERVER['HTTP_USER_AGENT'])) {
        exit('attention risque d\'attaque');
    }
    if (isset($_GET['page'])):
        $page = $_GET['page'];
    else:
        $page = 'admin_edito';
    endif;

    switch ($page) :

        default:
        case 'admin_edito':
            $body = 'admin_edito.php';
            break;

        case 'admin_magazine':
            $body = 'admin_magazine.php';
            break;
        case 'admin_catalogue':
            $body = 'admin_catalogue.php';
            break;
        case 'admin_produit':
            $body = 'admin_produit.php';
            break;

    endswitch;


    ob_start();
    include 'inc/admin/' . $body;
    $contenu_admin = ob_get_clean();
    include 'template/template_admin/layout.php';

//echo 'affiche backoffice OKOKK';
} else {

    include 'inc/connexion.php';
}
?>