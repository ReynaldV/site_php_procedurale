<?php

var_dump($_GET); //$_GET est une variable prédéfinie de PHP (plus exactement un array vide)
//1- test si un lien est cliqué
if (isset($_GET['page'])):
    $page = $_GET['page'];
else:
    $page = 'accueil';
endif;

switch ($page) :

    default:
    case 'accueil':
        $body = 'accueil.php';
        break;
    case 'catalogue':
        $body = 'catalogue.php';
        break;
    case 'magazine':
        $body = 'magazine.php';
        break;
    case 'contact':
        $body = 'contact.php';
        break;
endswitch;


include 'config.php';
include 'inc/bdd.php';
include 'lib/tools.php';

ob_start();
include 'inc/' . $body;
$contenu = ob_get_clean();
include 'template/layout.php';
?>
