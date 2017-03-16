<h1>Update <?php echo $donnee->titre; ?></h1>

<div class="form-group">
    <form method="post" enctype="multipart/form-data">
        <?php
        if ($success !== ''):
            ?>
            <p class="alert alert-success" style="border-radius: 5px;padding:15px;color:green;"><?php echo $success; ?></p>

            <?php
        //var_dump($success);
        endif;
        if ($erreur !== ''):
            ?>
            <p class="alert alert-danger" style="border-radius: 5px;padding:15px;color:red;"><strong><?php echo $erreur; ?></strong></p>
            <?php
        endif;
        ?>
        <fieldset>
            <legend>Updater l' Article</legend>

            <div class="form-group">
                <label for="titre">Titre</label>
                <input class="form-control" id="titre" name="titre" type="text" value="<?php echo $donnee->titre; ?>" placeholder="Le titre">
            </div>

            <div class="form-group">
                <label for="contenu">Contenu</label>
                <textarea class="form-control ckeditor" id="contenu" name="contenu" placeholder="Votre contenu"><?php echo $donnee->contenu; ?></textarea>
            </div>
            <label>
                <?php if (((($donnee->publier) == 0)) || (($donnee->publier) == NULL)) { ?>
                    <input type="checkbox" id="publier" checked="checked" name="publier" value="0">

                <?php } else { ?>
                    <input type="checkbox" id="publier" name="publier" value="1">

                <?php } ?>
                Brouillon
            </label>
            <fieldset>

                <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
                <div class="form-group">
                    <label for="titre">Modifier l'image</label>
                    <input class="form-control" id="imgfile" name="imgfile" type="file" /> (format .jpg/.gif/.png)
                </div>

                <div class="form-group">
                    <input class="btn btn-primary" name="ok" type="submit" value="VALIDER">
                </div>
            </fieldset>
        </fieldset>
    </form>
</div>