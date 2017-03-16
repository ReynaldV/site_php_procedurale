<?php

//configurer fichier http pour fermer l'accès à ce fichier pour renforcer la sécurité
$db = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $login, $password, [
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8', //déclaré jeux de carctere pour conserver les accents
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //afficher les erreur sql
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ //déclaré le mode de fetch par défaut
        ]
);
