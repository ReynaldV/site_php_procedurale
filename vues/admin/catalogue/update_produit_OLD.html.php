<h1>Update - <?php echo $donnee->libelle; ?></h1>

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
            <legend>Updater le produit</legend>

            <div class="form-group">
                <label for="titre">Libelle</label>
                <input class="form-control" id="libelle" name="libelle" type="text" value="<?php echo $donnee->libelle; ?>" placeholder="Le titre">
            </div>

            <div class="form-group">
                <label for="contenu">Description</label>
                <textarea class="form-control ckeditor" id="description" name="description" placeholder="Votre description"><?php echo $donnee->description; ?></textarea>
            </div>
            <input class="btn btn-primary" name="ok" type="submit" value="ENREGISTRER">
        </fieldset>
    </form>
</div>