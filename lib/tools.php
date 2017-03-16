<?php

//fonction EXTRAIT
function extrait($text, $max = 250) {
    $text = strip_tags($text);
    $len = strlen($text);

    switch ($len) {
        case ($len > $max) :
            $extrait = substr($text, 0, $max);
            $pos = strrpos($extrait, ' ');
            if ($pos != false) {
                $extrait = substr($text, 0, $pos);
            }
            return $extrait . ' [...]';
            break;
        case ($len < $max):
            echo $text;
            break;
    }
    //    if ($len > $max) {
//        $extrait = substr($text, 0, $max);
//        $pos = strrpos($extrait, ' ');
//        if ($pos != false) {
//            $extrait = substr($text, 0, $pos);
//        }
//    } else {
//        echo $text;
//    }
//    //var_dump($extrait);
//    return $extrait . ' [...]';
}

function formatDate($str) {
    /*
      $date = utf8_encode(strftime("%A %d %B %Y", strtotime($str)));
      return $date;
     */
    echo utf8_encode(strftime("%A %d %B %Y", strtotime($str)));
}

////////////////////////////////////////////////////


function upload($dir, $file) {
    if (!is_dir($dir)) {
        return ['upload' => false, 'message' => 'Ce dossier n\'existe pas'];
    }
    if ((($file['error']) != 0)) {
        switch ($file['error']) {
            case UPLOAD_ERR_INI_SIZE://case 1
                $message = "Erreur : " . UPLOAD_ERR_INI_SIZE . " - La taille du fichier téléchargé excède la valeur de upload_max_filesize (2M), configurée dans le php.ini";
                break;
            case UPLOAD_ERR_FORM_SIZE://case 2
                $message = "Erreur : " . UPLOAD_ERR_FORM_SIZE . " - La taille du fichier téléchargé excède la valeur de MAX_FILE_SIZE, qui a été spécifiée dans le formulaire HTML.";
                break;
            case UPLOAD_ERR_PARTIAL://case 3
                $message = "Erreur : " . UPLOAD_ERR_PARTIAL . " -  Le fichier n'a été que partiellement téléchargé.";
                break;
            case UPLOAD_ERR_NO_FILE://case 4
                $message = "Erreur : " . UPLOAD_ERR_NO_FILE . " -  Aucun fichier n'a été téléchargé.";
                break;
            default :
                $message = "ERREUR UPLOAD";
        }
        return ['upload' => false, 'message' => $message];
    }
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $extension = strtolower($extension); //mettre en minuscule
    //$extension_valide = ['jpg', 'jpeg', 'gif', 'png']; // méthode pas assez sécurisée car ne détecte que l'extension et pas le contenu du fichier

    $typesMime = ['image/jpg', 'image/jpeg', 'image/gif', 'image/png'];

    $finfo = new finfo(FILEINFO_MIME_TYPE); //donner argument type mime au constructeur  de la classe finfo
    $type = $finfo->file($file['tmp_name']);
    var_dump($type);
    if (!in_array($type, $typesMime)) {

        return ['upload' => false, 'message' => 'CHOISIR UNE IMAGE AU BON FORMAT'];
    }
    $fileName = sha1(uniqid(rand(), true)) . '.' . $extension;
    $destination = $dir . '/' . $fileName;
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return ['upload' => true, 'message' => $fileName];
    } else {
        return ['upload' => false, 'message' => 'Erreur copie fichier'];
    }
}

//////////////////////////////////
function minImg($source, $destination, $width = 150, $height = 150) {
    $extension = pathinfo($source, PATHINFO_EXTENSION);
    $extension = strtolower($extension); //mettre en minuscule
    $file = pathinfo($source, PATHINFO_FILENAME);
    var_dump($source);


    // Créer une ressource image $src_image copie  à partir de l'originale
    switch ($extension) {
        case 'jpg':
        case 'jpeg':
            $src_image = imagecreatefromjpeg($source);
            break;
        case 'gif':
            $src_image = imagecreatefromgif($source);
            break;
        case 'png':
            $src_image = imagecreatefrompng($source);
            break;
    }
    //Crée la miniature en couleurs vraies
    $dst_image = imagecreatetruecolor($width, $height);

    //définir une couleur de fond en RVB à associé à l'image
    $r = 255;
    $v = 255;
    $b = 255;
    $couleur_fond = imagecolorallocate($dst_image, $r, $v, $b);

    //Effectue un remplissage avec la couleur $couleur_fond, dans l'image $dst_image, à partir du point de coordonnées (0,0) (le coin supérieur gauche est l'origine (0,0)).
    imagefill($dst_image, 0, 0, $couleur_fond);

    //appliquer transparence sur la couleur de fond
    imagecolortransparent($dst_image, $couleur_fond);



    // Retourne la taille de l'image originale $source
//    $dimensions = getimagesize($source);
//    var_dump($dimensions);
//    $src_w = $dimensions[0];
//    $src_h = $dimensions[1];
//équivalent à (plus court avec fonction list pour retourner la taille de l'image originale $source)
    list($src_w, $src_h) = getimagesize($source);

//Calcul des dimensions de la miniature en fonction du ratio de l'image originale
    $ratio_orig = $src_w / $src_h;
    //initialiser les variables
    $dst_w = $width;
    $dst_h = $height;

    if ($dst_w / $dst_h > $ratio_orig) {
        $dst_w = $dst_h * $ratio_orig;
    } else {
        $dst_h = $dst_w / $ratio_orig;
    }
    echo 'Ratio =' . $ratio_orig;
    echo '<br/>';
    echo 'Height =' . $dst_h;
    echo '<br/>';
    echo 'Width =' . $dst_w;

    //Calcul des point de coordonnées x et y dans la miniature pour la centrer dans son contenant
    $dst_x = ($width - $dst_w) / 2;
    $dst_y = ($height - $dst_h) / 2;
    var_dump($dst_x, $dst_y);

//Copie, redimensionne, rééchantillonne une image dans la destination
    $result = imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);

    //WATERMARK 1
    $copyright = "copyright";
    $couleurText = imagecolorallocate($dst_image, 0, 0, 0);
    imagestring($dst_image, 1, 0, 30, $copyright, $couleurText);
    var_dump($result);

//WATERMARK 2
//    $wm = imagecreatefrompng('images/watermark.png');
//    list($wm_w, $wm_h) = getimagesize('images/watermark.png');
//    imagecopyresampled($dst_image, $wm, 0, 0, 0, 0, $width, $height, $wm_w, $wm_h);
    // Affichage
    //la fonction imagepng Envoie une image PNG vers un navigateur ou un fichier
    if (imagepng($dst_image, $destination . '/' . $file . '.png')) {

        return $file . '.png';
    } else {
        return null;
    }


//var_dump($test);
}

?>