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
    case 'index': indexProduit();
        break;
    case 'create': createProduit();
        break;
    case 'update': updateProduit();
        break;
    case 'delete': deleteProduit();
        break;
endswitch;

//function

function indexProduit() {
    global $db;
    $id = $_GET['id'];
    $result = $db->prepare("SELECT categorie_id,libelle,description,date,image,prix,publier,image_originale,categorie.titre categorieTitre FROM produit LEFT JOIN categorie ON categorie_id=:id WHERE produit.id=:id;");
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->execute();
    $donnee = $result->fetch();
    var_dump($donnee);
    //var_dump($donnee);
//
//    $result = $db->prepare("SELECT tag.id,tag.nom, produit.id produitId,produit.libelle FROM tag LEFT JOIN produit_tag ON tag_id=tag.id LEFT JOIN produit ON produit.id=produit_id WHERE produit.id=:id");
//    $result->bindParam(':id', $id, PDO::PARAM_INT);
//    $result->execute();
//    $donnee_tag = $result->fetchAll();
//    var_dump($donnee_tag);


    include 'vues/admin/produit/list_produit.html.php';
}

function createProduit() {


    global $db;
    $erreur = '';
    $success = '';
    if ($_POST) {

        if (($_POST['libelle']) != ''):
            $titre = htmlspecialchars($_POST['libelle']);
        else:
            $erreur = '- Remplir le champ titre SVP<br/>';
        endif;
        if ((!isset($_POST['description'])) || (strlen($_POST['description']) > 2)):
            $contenu = htmlspecialchars($_POST['description']);

        else:
            $erreur .= "- Le contenu doit comporter plus de 2 caractères<br/>";

        endif;
////////////tests finis -> insertion
        if (($erreur == '') && $_FILES['imgfile']['error'] == 0) {
            $result = upload('images/upload', $_FILES['imgfile']);
            var_dump($result);

            if ($result['upload']) {
                $imageOriginale = $result['message'];
                $image = minImg('images/upload' . '/' . $imageOriginale, 'images/thumbnails');
            } else {
                $erreur .= $result['message'];
            }
        } else {
            $image = null;
            $imageOriginale = null;
        }

////////////tests finis -> insertion
        if ($erreur == ''):
//
//            if ($_POST['choixCat'] == $_GET['categorie_id']) {
//                $id = $_POST['choixCat'];
//            } else {
//                $id = $_GET['categorie_id'];
//            }
            $id = $_POST['choixCat'];
            //$id = $_SESSION['id'];
            //var_dump($_SESSION);
            $titre = $_POST['libelle'];
            $slug = str_replace(' ', '-', $titre);
            $contenu = $_POST['description'];
            $prix = $_POST['prix'];
            if (isset($_POST['publier'])) {
                $publier = 0;
            } else {
                $publier = 1;
            }

            $produits = $db->prepare('INSERT INTO produit (id,libelle,description,date,image,prix,categorie_id,publier,image_originale,slug) VALUES (NULL,:titre,:contenu,NOW(),:image,:prix,:id,:publier,:imageOriginale,:slug);');
            $produits->bindParam(':id', $id, PDO::PARAM_INT);
            $produits->bindParam(':titre', $titre, PDO::PARAM_STR, 12);
            $produits->bindParam(':contenu', $contenu, PDO::PARAM_STR, 12);
            $produits->bindParam(':prix', $prix, PDO::PARAM_STR, 12);
            $produits->bindParam(':publier', $publier, PDO::PARAM_BOOL, 12);
            $produits->bindParam(':image', $image, PDO::PARAM_STR, 12);
            $produits->bindParam(':imageOriginale', $imageOriginale, PDO::PARAM_STR, 12);
            $produits->bindParam(':slug', $slug, PDO::PARAM_STR, 12);
            var_dump($produits);
            if ($produits->execute()):

                $success = "enregistrement réussi";

            else:
                $erreur = "probleme d'envoi à la BDD";
            endif;


        endif;
        //var_dump($success);
        //var_dump($erreur);
    }

    $result = $db->prepare('SELECT categorie.id catId,categorie.titre catNom FROM categorie');
    $result->execute();
    $donneeAllCat = $result->fetchAll();
    $id = $_GET['categorie_id'];
    $result = $db->prepare('SELECT categorie.id catId,categorie.titre catNom FROM categorie WHERE categorie.id=:id');
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->execute();
    $donneeCat = $result->fetch();

    include 'vues/admin/produit/create_produit.html.php';
}

function updateProduit() {
    global $db;

    $erreur = '';
    $success = '';

    $id = $_GET['id'];
    if ($_POST) {

        if (($_POST['libelle']) != ''):
            $titre = htmlspecialchars($_POST['libelle']);
        else:
            $erreur = '- Remplir le champ titre SVP<br/>';
        endif;
        if ((!isset($_POST['description'])) || (strlen($_POST['description']) > 2)):
            $contenu = htmlspecialchars($_POST['description']);

        else:
            $erreur .= "- Le contenu doit comporter plus de 2 caractères<br/>";

        endif;

        if (($erreur == '') && ($_FILES['imgfile']['error'] == 0)) {
            $result = upload('images/upload', $_FILES['imgfile']);
            var_dump($result);

            if ($result['upload']) {
                $imageOriginale = $result['message'];
                $image = minImg('images/upload/' . $imageOriginale, 'images/thumbnails');
                $result = $db->prepare('SELECT image,image_originale FROM produit WHERE id=:id');
                $result->bindParam(':id', $id, PDO::PARAM_INT);
                $result->execute();
                $images = $result->fetchObject();
                if ($images->image) {
                    unlink('images/thumbnails/' . $images->image);
                }
                if ($images->image_originale) {
                    unlink('images/upload/' . $images->image_originale);
                }
            } else {
                $erreur .= $result['message'];
            }
        }
////////////tests finis -> insertion
        if ($erreur == '') {
            $success = 'UPDATE OK';

            $id = $_GET['id'];
            $idCatSelect = $_POST['choixCat'];
            $titre = $_POST['libelle'];
            $contenu = $_POST['description'];
            if (isset($_POST['publier'])) {
                $publier = 0;
            } else {
                $publier = 1;
            }
            $sql = "UPDATE produit SET libelle = :titre, description = :contenu, publier = :publier, categorie_id=:idCatSelect ";
            if (isset($image))
                $sql .= ', image="' . $image . '", image_originale="' . $imageOriginale . '"';
            $sql .= ' WHERE produit.id=:id;';

            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            $result->bindParam(':idCatSelect', $idCatSelect, PDO::PARAM_INT);
            $result->bindParam(':titre', $titre, PDO::PARAM_STR, 12);
            $result->bindParam(':contenu', $contenu, PDO::PARAM_STR, 12);
            $result->bindParam(':publier', $publier, PDO::PARAM_BOOL);
            $result->execute();

            var_dump($result);
            if ($result->execute())
                $success = 'UPDATE OK';
            else
                $erreur .= 'Erreur BDD';
            var_dump($result);
        }
    }

    $result = $db->prepare('SELECT categorie.id catId,categorie.titre catNom FROM categorie');
    $result->execute();
    $donneeAllCat = $result->fetchAll();

    $idCat = $_GET['categorie_id'];
    $result = $db->prepare('SELECT categorie.id catId,categorie.titre catNom FROM categorie WHERE categorie.id=:idCat');
    $result->bindParam(':idCat', $idCat, PDO::PARAM_INT);
    $result->execute();
    $donneeCat = $result->fetch();
    var_dump($donneeCat);

    $id = $_GET['id'];
    $result = $db->prepare('SELECT produit.id produitId,libelle,description,publier FROM produit WHERE produit.id=:id');
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->execute();
    $donnee = $result->fetch();

    include 'vues/admin/produit/update_produit.html.php';
}

function deleteProduit() {
    $id = $_GET['id'];
    global $db;

    $success = "produit effacé !";
    $result = $db->prepare("DELETE FROM `produit`
WHERE `id` =:id;");
    $result->bindParam(':id', $id, PDO::PARAM_INT);

    $result->execute();

    header('Location:admin.php?page=admin_catalogue');
    exit();
}
