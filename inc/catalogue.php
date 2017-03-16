<?php

var_dump($_GET); //$_GET est une variable prédéfinie de PHP (plus exactement un array vide)
//1- test si un lien est cliqué
if (isset($_GET['action'])):
    $action = $_GET['action'];
else:
    $action = 'index';
endif;

$file = 'cache/' . md5($_SERVER['QUERY_STRING']) . '.cache';

if (((file_exists($file)) && time() - filemtime($file) < 5)):
    readfile($file);
else:
//début cache
    ob_start();


    switch ($action) :
        default:
        case 'index': indexAction();
            break;
        case 'categorie': categorieAction();
            break;
        case 'detail': detailAction();
            break;
        case 'tag': tagAction();
            break;
    endswitch;

//fin cache
    $buffer = ob_get_flush(); //afficher au moins 1 fois avant de mettre en cache
    file_put_contents($file, $buffer);
endif;

//function
function indexAction() {
    global $db;
    $result = $db->query('SELECT COUNT(*) count,categorie.id,titre,contenu,categorie.slug FROM categorie LEFT JOIN produit ON categorie.id=categorie_id WHERE publier=true GROUP BY categorie.id;');
    //$result = $db->query('SELECT categorie.id,titre,contenu, (SELECT COUNT(*) FROM produit WHERE categorie_id=categorie.id && publier = true) count FROM categorie;');
    $categories = $result->fetchAll();
    var_dump($categories);
    include 'vues/catalogue/index.html.php';
}

function categorieAction() {
    global $db;
    $id = $_GET['id'];
    $result = $db->prepare('SELECT categorie.titre, produit.id idprod,categorie_id,libelle,description,image,date,prix,image_originale,produit.slug FROM produit LEFT JOIN categorie ON categorie_id=categorie.id WHERE categorie_id=:id && publier=true;');
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->execute();
    $produits = $result->fetchAll();
    var_dump($produits);
    include 'vues/catalogue/categorie.html.php';
}

function detailAction() {
    global $db;
    $id = $_GET['id'];
    $result = $db->prepare("SELECT categorie_id,libelle,description,date,image,prix,image_originale,categorie.slug categorieSlug,categorie.id categorieId FROM produit LEFT JOIN categorie ON categorie_id=:id WHERE produit.id=:id && publier=true;");
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->execute();
    $donnee = $result->fetch();
    var_dump($donnee);


    $result = $db->prepare("SELECT tag.id,tag.nom, produit.libelle FROM tag LEFT JOIN produit_tag ON tag_id=tag.id LEFT JOIN produit ON produit.id=produit_id WHERE produit.id=:id");
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->execute();
    $donnee_tag = $result->fetchAll();
    var_dump($donnee_tag);

    include 'vues/catalogue/detail.html.php';
}

function tagAction() {
    global $db;
    $id = $_GET['id'];
    $result = $db->prepare("SELECT tag.id tagId,tag.nom,produit.libelle,produit.id FROM produit LEFT JOIN produit_tag ON produit_id=produit.id LEFT JOIN tag ON tag_id=tag.id WHERE tag.id=:id");
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->execute();
    $donnee_tag = $result->fetchAll();
    var_dump($donnee_tag);
    include 'vues/catalogue/tag.html.php';
}
