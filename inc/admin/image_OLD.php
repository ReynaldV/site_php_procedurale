<?php
var_dump($_POST);
var_dump($_FILES);
include '../../config.php';
include '../bdd.php';

if (isset($_FILES['imgfile'])) {
    $result = upload('../../images/', $_FILES['imgfile']);
    var_dump($result);
}

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
        ?>
        <p class="alert alert-danger" style="border-radius: 5px;padding:15px;color:red;"><strong><?php echo $message; ?></strong></p>
        <?php
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
        global $db;
        if (isset($_POST['idEdito'])) {
            $id = $_POST['idEdito'];
            $result = $db->prepare("UPDATE edito SET image = :image WHERE edito.id=:id;");
            header('Location:../../admin.php');
        }
        if (isset($_POST['idArticle'])) {
            $id = $_POST['idArticle'];
            $result = $db->prepare("UPDATE article SET image = :image WHERE article.id=:id;");
            header('Location:../../admin.php?page=admin_magazine');
        }
        $result->bindParam(':id', $id, PDO::PARAM_STR, 12);
        $result->bindParam(':image', $fileName, PDO::PARAM_STR, 12);
        $result->execute();

        var_dump($result);


        return ['upload' => true, 'message' => $fileName];
    } else {


        return ['upload' => true, 'message' => 'Erreur copie fichier'];
    }
}
?>