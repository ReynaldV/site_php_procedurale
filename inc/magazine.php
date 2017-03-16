<?php

var_dump($_GET); //$_GET est une variable prédéfinie de PHP (plus exactement un array vide)
//1- test si un lien est cliqué
if (isset($_GET['action'])):
    $action = $_GET['action'];
else:
    $action = 'index';
endif;

switch ($action) :
    default:
    case 'index': indexAction();
        break;
    case 'detail': detailAction();
        break;
endswitch;

function indexAction() {
    global $db;
    $result = $db->query('SELECT article.id,titre,contenu,date,image,login,image_originale,slug FROM article LEFT JOIN auteur ON auteur_id=auteur.id WHERE publier=1 ORDER BY date DESC;');
    $articles = $result->fetchAll();
    var_dump($articles);
    include 'vues/magazine/index.html.php';
}

function detailAction() {
    global $db;
    $id = $_GET['id'];
    $result = $db->prepare("SELECT titre,contenu,date,image,login,image_originale,slug FROM article LEFT JOIN auteur ON auteur_id=auteur.id WHERE article.id=:id;");
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->execute();
    $donnee = $result->fetch();
    var_dump($donnee);
    include 'vues/magazine/detail.html.php';
}
