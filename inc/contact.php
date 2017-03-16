<?php

var_dump($_POST);

$erreur = '';
$success = '';

if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['nom']))):
//    if (isset($_POST['nom']){
//       if ($_POST){
//if (!empty($_POST)):

    if (isset($_POST['genre'])):
        $genre = htmlspecialchars($_POST['genre']);
    else:
        $erreur .= '- Cocher le genre SVP<br/>';
    endif;
    if ((!isset($_POST['nom'])) || (strlen($_POST['nom']) > 2)):
        $nom = htmlspecialchars($_POST['nom']);

    else:
        $erreur .= "- Le nom doit comporter plus de 2 caractères<br/>";

    endif;

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false):
        $email = $_POST['email'];
    else:
        $erreur .= "- L'E-mail n'est pas valide<br/>";
    endif;
    if (($_POST['objet']) != '0'):
        $objet = $_POST['objet'];
    else:
        $erreur .= "- Veuillez sélectionner un objet<br/>";
    endif;
    if ((!isset($_POST['message'])) || (strlen($_POST['message']) > 2)):
        $message = htmlspecialchars($_POST['message']);

    else:
        $erreur .= "- Le message doit comporter plus de 2 caractères<br/>";

    endif;
////////////tests finis -> insertion
    if ($erreur == ''):
        $id = NULL;
        $genre = $_POST['genre'];
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        $objet = $_POST['objet'];

        $result = $db->prepare('INSERT INTO contact (id,genre,nom,email,objet,message,date) VALUES (:id,:genre,:nom,:email,:objet,:message,NOW());');
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':genre', $genre, PDO::PARAM_STR, 12);
        $result->bindParam(':nom', $nom, PDO::PARAM_STR, 12);
        $result->bindParam(':email', $email, PDO::PARAM_STR, 12);
        $result->bindParam(':message', $message, PDO::PARAM_STR, 12);
        $result->bindParam(':objet', $objet, PDO::PARAM_STR, 12);

        if ($result->execute()):

            ob_start();
            include 'vues/contact/mail.html.php';
            $message_mail = ob_get_clean();


// Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            // Envoi
            mail("reynald.v@free.fr,$email", $objet, $message_mail, $headers);

            $success = "envoi réussi";

        else:
            $erreur = "probleme d'envoi à la BDD";
        endif;


    endif;
    var_dump($success);
    var_dump($erreur);
else:


endif;




include 'vues/contact/contact.html.php';


