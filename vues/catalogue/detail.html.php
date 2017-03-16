<h1>Detail produit</h1>
<hr>

<article>

    <h2 class="text-uppercase"><?php echo $donnee->libelle; ?></h2>

    <p><?php echo $donnee->description; ?></p>
    <h3>Date : <?php echo formatDate($donnee->date); ?></h3>
    <h4>Prix : <?php echo $donnee->prix; ?></h4>
    <?php foreach ($donnee_tag as $key => $value) { ?>

        <a href="<?php echo REP_RACINE ?>?page=catalogue&action=tag&id=<?php echo $value->id; ?>"><input class="btn btn-primary" name="ok" type="submit" value="<?php echo $value->nom; ?>"></a>
    <?php }
    ?>
</article>
<div>
    <?php if ($donnee->image_originale != null):
        ?>
        <img class="img-thumbnail" src="<?php echo REP_IMAGES . $donnee->image_originale; ?>" alt="<?php echo htmlentities($donnee->libelle, ENT_QUOTES); ?>">
    <?php endif; ?>
</div>
<a href="<?php echo REP_RACINE ?>?page=catalogue&action=categorie&id=<?php echo $donnee->categorie_id; ?>"> <h2 class="text-uppercase">Retour sur la catégorie</h2></a>