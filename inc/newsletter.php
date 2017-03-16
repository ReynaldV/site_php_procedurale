<?php

//////////TXT

$erreur = '';
$success = '';
if (isset($_POST['newsletter'])) {

    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur .= 'Mauvais format email';
    } else {
        $file = 'cache/mail_newsletter.txt';
        if (file_exists($file))
            $emails = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        else
            $emails = [];

        if (in_array($email, $emails))
            $erreur .= 'Déjà inscrit';
        else {
            file_put_contents($file, $email . "\r\n", FILE_APPEND);
            $success = 'Inscription ok';
        }
    }
}


//////////CSV


$erreur = '';
if (isset($_POST['newsletter'])) {

    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur .= 'Mauvais format email';
    } else {
        $file = 'cache/mail_newsletter.csv';
        if (file_exists($file)) {
            $fp = fopen($file, 'r');
            while (($emails = fgetcsv($fp)) !== false) {
                if (in_array($email, $emails)) {
                    $erreur .= 'Déjà inscrit';
                    fclose($fp);
                    break;
                }
            }
        }
        if ($erreur == '') {
            $fp = fopen($file, 'a');
            fputcsv($fp, [$email]);
            fclose($fp);
            $success = 'Inscription ok';
        }
    }
}



include 'vues/newsletter/newsletter.html.php';
