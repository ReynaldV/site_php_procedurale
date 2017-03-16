<?php

//var_dump($_GET); //$_GET est une variable prédéfinie de PHP (plus exactement un array vide)
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
    case 'categorie': categorieAction();
        break;
    case 'listAllProduit': listAllProduit();
        break;
//    case 'detail': detailAction();
//        break;
//    case 'tag': tagAction();
//        break;
    case 'create': createCategorie();
        break;
    case 'update': updateCategorie();
        break;
    case 'delete': deleteCategorie();
        break;
endswitch;

//function
function indexAction() {
    global $db;
    //$result = $db->query('SELECT COUNT(*) count,categorie.id,titre,contenu FROM categorie LEFT JOIN produit ON categorie.id=categorie_id GROUP BY categorie.id;');
    $result = $db->query('SELECT categorie.id,titre,contenu,slug, (SELECT COUNT(*) FROM produit WHERE categorie_id=categorie.id) count, (SELECT COUNT(*) FROM produit) countAll FROM categorie;');
    $categories = $result->fetchAll();
    //var_dump($categories);

    include 'vues/admin/catalogue/list_catalogue.html.php';
}

function listAllProduit() {
    global $db;
    //$id = $_GET['id'];
    $result = $db->prepare('SELECT categorie.titre categorieTitre, produit.id idprod,categorie_id,libelle,description,image,date,prix,publier,image_originale FROM produit LEFT JOIN categorie ON categorie_id=categorie.id;');
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->execute();
    $produits = $result->fetchAll();
    //var_dump($produits);

    $result = $db->prepare("SELECT tag.id,tag.nom, produit.libelle FROM tag LEFT JOIN produit_tag ON tag_id=tag.id LEFT JOIN produit ON produit.id=produit_id WHERE produit.id=:id");
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->execute();
    $donnee_tag = $result->fetchAll();
    //var_dump($donnee_tag);
    include 'vues/admin/produit/listAllProduit.html.php';
}

function categorieAction() {
    global $db;
    $id = $_GET['id'];
    $result = $db->prepare('SELECT categorie.titre categorieTitre, produit.id idprod,categorie_id,libelle,description,image,date,prix,publier,image_originale FROM produit LEFT JOIN categorie ON categorie_id=categorie.id WHERE categorie_id=:id;');
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->execute();
    $produits = $result->fetchAll();
    //var_dump($produits);

    $result = $db->prepare("SELECT tag.id,tag.nom, produit.libelle FROM tag LEFT JOIN produit_tag ON tag_id=tag.id LEFT JOIN produit ON produit.id=produit_id WHERE produit.id=:id");
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->execute();
    $donnee_tag = $result->fetchAll();
    //var_dump($donnee_tag);
    include 'vues/admin/produit/list_produit.html.php';
}

function createCategorie() {



    $erreur = '';
    $success = '';
    if ($_POST) {

        if (($_POST['titre']) != ''):
            $titre = htmlspecialchars($_POST['titre']);
        else:
            $erreur = '- Remplir le champ titre SVP<br/>';
        endif;
        if ((!isset($_POST['contenu'])) || (strlen($_POST['contenu']) > 2)):
            $contenu = htmlspecialchars($_POST['contenu']);

        else:
            $erreur .= "- Le contenu doit comporter plus de 2 caractères<br/>";

        endif;
////////////tests finis -> insertion
        if ($erreur == ''):

            global $db;
            //$id = $_SESSION['id'];
            //var_dump($_SESSION);
            $titre = $_POST['titre'];
            $slug = str_replace(' ', '-', $titre);
            $contenu = $_POST['contenu'];
            $result = $db->prepare('INSERT INTO categorie (id,titre,contenu,slug) VALUES (NULL,:titre,:contenu,:slug);');
            //$result->bindParam(':id', $id, PDO::PARAM_INT);
            $result->bindParam(':titre', $titre, PDO::PARAM_STR, 12);
            $result->bindParam(':contenu', $contenu, PDO::PARAM_STR, 12);
            $result->bindParam(':slug', $slug, PDO::PARAM_STR, 12);

            if ($result->execute()):

                $success = "enregistrement réussi";

            else:
                $erreur = "probleme d'envoi à la BDD";
            endif;


        endif;
        //var_dump($success);
        //var_dump($erreur);
    }

    include 'vues/admin/catalogue/create_categorie.html.php';
}

function updateCategorie() {
    global $db;

    $erreur = '';
    $success = '';

    $id = $_GET['id'];
    if ($_POST) {

        if (($_POST['titre']) != ''):
            $titre = htmlspecialchars($_POST['titre']);
        else:
            $erreur = '- Remplir le champ titre SVP<br/>';
        endif;
        if ((!isset($_POST['contenu'])) || (strlen($_POST['contenu']) > 2)):
            $contenu = htmlspecialchars($_POST['contenu']);

        else:
            $erreur .= "- Le contenu doit comporter plus de 2 caractères<br/>";

        endif;


////////////tests finis -> insertion
        if ($erreur == '') {
            $success = 'UPDATE OK';

            var_dump($id);
            $titre = $_POST['titre'];
            $contenu = $_POST['contenu'];
            $result = $db->prepare("UPDATE categorie
      SET titre = :titre, contenu = :contenu WHERE categorie.id=:id;");
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            $result->bindParam(':titre', $titre, PDO::PARAM_STR, 12);
            $result->bindParam(':contenu', $contenu, PDO::PARAM_STR, 12);
            $result->execute();

            var_dump($result);
        }
    }


    $result = $db->prepare('SELECT categorie.id categorieId,titre,contenu FROM categorie WHERE categorie.id=:id');
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->execute();
    $donnee = $result->fetch();

    include 'vues/admin/catalogue/update_categorie.html.php';
}

function deleteCategorie() {
    $id = $_GET['id'];
    global $db;

    $success = "catégorie effacé !";
    $result = $db->prepare("DELETE FROM `categorie`
WHERE `id` =:id;");
    $result->bindParam(':id', $id, PDO::PARAM_INT);

    $result->execute();

    header('Location:admin.php?page=admin_catalogue');
    exit();
}
