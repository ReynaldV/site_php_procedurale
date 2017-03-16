<?php

//1- test si un lien est cliqué


if (isset($_GET['action'])):
    $action = $_GET['action'];
else:
    $action = 'listing';

endif;




switch ($action) :
    default:
    case 'listing': listMagazine();
        break;
    case 'create': createMagazine();
        break;
    case 'update': updateMagazine();
        break;
    case 'delete': deleteMagazine();
        break;
endswitch;

//function
function listMagazine() {
    global $db;
    $result = $db->query('SELECT article.id articleId,titre,contenu,date,image,publier,login FROM article LEFT JOIN auteur ON auteur_id=auteur.id ORDER BY article.id DESC;');
    $donnee = $result->fetchAll();
//var_dump($donnee);


    include 'vues/admin/magazine/list_magazine.html.php';
}

function createMagazine() {



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

            global $db;
            $id = $_SESSION['id'];
            //var_dump($_SESSION);
            $titre = $_POST['titre'];
            $slug = str_replace(' ', '-', $titre);
            $contenu = $_POST['contenu'];
            if (isset($_POST['publier'])) {
                $publier = 0;
            } else {
                $publier = 1;
            }
            var_dump($_POST);
            $result = $db->prepare('INSERT INTO article (id,titre,contenu,date,image,auteur_id,publier,image_originale,slug) VALUES (NULL,:titre,:contenu,NOW(),:image,:id,:publier,:imageOriginale,:slug);');
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            $result->bindParam(':titre', $titre, PDO::PARAM_STR, 12);
            $result->bindParam(':contenu', $contenu, PDO::PARAM_STR, 12);
            $result->bindParam(':publier', $publier, PDO::PARAM_BOOL, 12);
            $result->bindParam(':image', $image, PDO::PARAM_STR, 12);
            $result->bindParam(':imageOriginale', $imageOriginale, PDO::PARAM_STR, 12);
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

    include 'vues/admin/magazine/create_magazine.html.php';
}

function updateMagazine() {
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
        if (($erreur == '') && ($_FILES['imgfile']['error'] == 0)) {
            $result = upload('images/upload', $_FILES['imgfile']);
            var_dump($result);

            if ($result['upload']) {
                $imageOriginale = $result['message'];
                $image = minImg('images/upload/' . $imageOriginale, 'images/thumbnails');
                $result = $db->prepare('SELECT image,image_originale FROM article WHERE id=:id');
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


            var_dump($id);
            $titre = $_POST['titre'];
            $contenu = $_POST['contenu'];
            $auteurId = $_SESSION['id'];
            if (isset($_POST['publier'])) {
                $publier = 0;
            } else {
                $publier = 1;
            }

            var_dump($_POST);
            $sql = "UPDATE article SET titre = :titre, contenu = :contenu, date = NOW(), auteur_id=:auteurId, publier = :publier";
            if (isset($image))
                $sql .= ', image="' . $image . '", image_originale="' . $imageOriginale . '"';
            $sql .= ' WHERE id=:id;';

            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            $result->bindParam(':titre', $titre, PDO::PARAM_STR, 12);
            $result->bindParam(':contenu', $contenu, PDO::PARAM_STR, 12);
            $result->bindParam(':auteurId', $auteurId, PDO::PARAM_INT);
            $result->bindParam(':publier', $publier, PDO::PARAM_BOOL);
            $result->execute();

            var_dump($result);
            if ($result->execute())
                $success = 'UPDATE OK';
            else
                $erreur .= 'Erreur BDD';
        }
    }


    $result = $db->prepare('SELECT * FROM article WHERE article.id=:id');
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->execute();
    $donnee = $result->fetch();

    include 'vues/admin/magazine/update_magazine.html.php';
}

function deleteMagazine() {
    $id = $_GET['id'];
    global $db;

    $success = "article effacé !";
    $result = $db->prepare("DELETE FROM `article`
WHERE `id` =:id;");
    $result->bindParam(':id', $id, PDO::PARAM_INT);

    $result->execute();

    header('Location:admin.php?page=admin_magazine');
    exit();
}
