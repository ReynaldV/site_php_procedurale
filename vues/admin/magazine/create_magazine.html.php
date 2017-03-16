<h1>Create Article</h1>

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
            <legend>Remplissez le Nouvel Article</legend>

            <div class="form-group">
                <label for="titre">Titre</label>
                <input class="form-control" id="titre" name="titre" type="text" placeholder="Le titre">
            </div>

            <div class="form-group">
                <label for="contenu">contenu</label>
                <textarea class="form-control ckeditor" id="contenu" name="contenu" placeholder="Votre contenu"></textarea>
            </div>
            <div class="form-group">

                <label>
                    <input type="checkbox" id="publier" name="publier" value="0">
                    Brouillon
                </label>
            </div>

        </fieldset>
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
    </form>
</div>