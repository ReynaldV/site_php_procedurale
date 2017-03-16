<?php

$result = $db->query('SELECT titre,contenu,date,image,login,image_originale FROM edito LEFT JOIN auteur ON auteur_id=auteur.id ORDER BY date DESC;');
$donnee = $result->fetch();
var_dump($donnee);


include 'vues/accueil.html.php';
