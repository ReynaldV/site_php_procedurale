<h1>Create Catégorie</h1>

<div class="form-group">
    <form method="post">
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
            <legend>Créez une nouvelle catégorie</legend>

            <div class="form-group">
                <label for="titre">Titre</label>
                <input class="form-control" id="titre" name="titre" type="text" placeholder="Le titre">
            </div>

            <div class="form-group">
                <label for="contenu">contenu</label>
                <textarea class="form-control ckeditor" id="contenu" name="contenu" placeholder="Votre contenu"></textarea>
            </div>
            <input class="btn btn-primary" name="ok" type="submit" value="ENREGISTRER">
        </fieldset>
    </form>
</div>