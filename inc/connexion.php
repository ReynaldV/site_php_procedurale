<?php

if ((isset($_POST['submit']))) {
//if ($_POST) {
    if (((($_POST["token"]) == $_SESSION['token']) && ((time() - $_SESSION['tokenTime']) <= 60 * 5))) { //5mn //si jeton est bon
        $login = $_POST['login'];
        $password = $_POST['password'];
        $result = $db->prepare("SELECT id,login,pwd FROM auteur WHERE login=:login");
        $result->bindParam(':login', $login);
        $result->execute();
        $donnee = $result->fetch();
        //var_dump($donnee);
        if ($donnee == false) {
            echo 'Le login n\'existe pas';
        } else {
            $hash = $donnee->pwd;
            //var_dump($hash);
            if (password_verify($password, $hash) == false) {
                sleep(1); // pour ralentir les robots
                echo'mauvais mot de passe';
            } else {
                $_SESSION['auth'] = true; //si authentification OK
                // enregistrement des variables de session
                $_SESSION['login'] = $donnee->login;

                $_SESSION['id'] = $donnee->id;
                $_SESSION['IPaddress'] = sha1($_SERVER['REMOTE_ADDR']);
                $_SESSION['userAgent'] = sha1($_SERVER['HTTP_USER_AGENT']);
                //var_dump($_SESSION);
                setcookie(session_name(), session_id(), time() + 3600, '/', null, null, true);
                header('Location: admin.php');

                exit();
            }
        }
    } else {
        sleep(1);
        echo 'le jeton n\'est pas bon';
    }
}

$token = sha1(uniqid(rand(), true));
$tokenTime = time();
$_SESSION['token'] = $token;
$_SESSION['tokenTime'] = $tokenTime;



include 'vues/admin/connexion.html.php';
