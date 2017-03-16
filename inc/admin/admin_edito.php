<?php

//1- test si un lien est cliqué


if (isset($_GET['action'])):
    $action = $_GET['action'];
else:
    $action = 'listing';

endif;




switch ($action) :
    default:
    case 'listing': listEdito();
        break;
    case 'create': createEdito();
        break;
    case 'update': updateEdito();
        break;
    case 'delete': deleteEdito();
        break;
endswitch;

//function
function listEdito() {
    global $db;
    $result = $db->query('SELECT edito.id editoId,titre,contenu,date,image,login FROM edito LEFT JOIN auteur ON auteur_id=auteur.id ORDER BY edito.id DESC;');
    $donnee = $result->fetchAll();
//var_dump($donnee);


    include 'vues/admin/edito/listEdito.html.php';
}

function createEdito() {


    var_dump($_FILES);
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
            $contenu = $_POST['contenu'];


            $result = $db->prepare('INSERT INTO edito (id,titre,contenu,date,image,auteur_id,image_originale) VALUES (NULL,:titre,:contenu,NOW(),:image,:id,:imageOriginale);');
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            $result->bindParam(':titre', $titre, PDO::PARAM_STR, 12);
            $result->bindParam(':contenu', $contenu, PDO::PARAM_STR, 12);
            $result->bindParam(':image', $image, PDO::PARAM_STR, 12);
            $result->bindParam(':imageOriginale', $imageOriginale, PDO::PARAM_STR, 12);

            if ($result->execute()):

                $success = "enregistrement réussi";

            else:
                $erreur = "probleme d'envoi à la BDD";
            endif;


        endif;
        //var_dump($success);
        //var_dump($erreur);
    }

    include 'vues/admin/edito/create_edito.html.php';
}

function updateEdito() {
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
                $result = $db->prepare('SELECT image,image_originale FROM edito WHERE id=:id');
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

            $sql = "UPDATE edito SET titre = :titre, contenu = :contenu, auteur_id=:auteurId, date = NOW() ";
            if (isset($image))
                $sql .= ', image="' . $image . '", image_originale="' . $imageOriginale . '"';
            $sql .= ' WHERE id=:id;';

            var_dump($sql);
            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            $result->bindParam(':titre', $titre, PDO::PARAM_STR, 12);
            $result->bindParam(':contenu', $contenu, PDO::PARAM_STR, 12);
            $result->bindParam(':auteurId', $auteurId, PDO::PARAM_INT);


            if ($result->execute())
                $success = 'UPDATE OK';
            else
                $erreur .= 'Erreur BDD';
            var_dump($result);
        }
    }


    $result = $db->prepare('SELECT * FROM edito WHERE id=:id');
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->execute();
    $donnee = $result->fetch();

    include 'vues/admin/edito/update_edito.html.php';
}

function deleteEdito() {
    $id = $_GET['id'];
    global $db;

    $success = "edito effacé !";
    $result = $db->prepare("DELETE FROM `edito`
WHERE `id` =:id;");
    $result->bindParam(':id', $id, PDO::PARAM_INT);

    $result->execute();

    header('Location:admin.php?page=admin_edito');
    exit();
}
