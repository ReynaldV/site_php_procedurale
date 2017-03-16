<h1>Create Produit</h1>

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
            <legend>Remplissez le Nouveau produit</legend>

            <div class="form-group">
                <label for="titre">Titre</label>
                <input class="form-control" id="libelle" name="libelle" type="text" placeholder="Le titre">
            </div>

            <div class="form-group">
                <label for="contenu">Contenu</label>
                <textarea class="form-control ckeditor" id="contenu" name="description" placeholder="Votre contenu"></textarea>
            </div>
            <label>
                <input type="checkbox" id="publier" name="publier" value="0">
                Brouillon
            </label>
            <br/>
            <label>Catégorie
                <select name="choixCat">
                    <?php foreach ($donneeAllCat as $donnee) { ?>
                        <?php if ($donnee->catId !== $donneeCat->catId) { ?>
                            <option value="<?php echo $donnee->catId; ?>"><?php echo $donnee->catNom; ?></option>
                        <?php } else { ?>
                            <option selected="selected" value="<?php echo $donneeCat->catId; ?>"><?php echo $donneeCat->catNom; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </label>
            <div class="form-group">
                <label for="prix">Prix</label>
                <input class="form-control" id="prix" name="prix" placeholder="Votre prix"/>
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