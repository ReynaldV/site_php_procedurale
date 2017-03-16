<h1>Detail produit A EDITE</h1>
<hr>

<article>

    <h2 class="text-uppercase"><?php echo $donnee->libelle; ?></h2>

    <p><?php echo $donnee->description; ?></p>
    <h3>Date : <?php echo formatDate($donnee->date); ?></h3>
    <h4>Prix : <?php echo $donnee->prix; ?></h4>
    <div>
        <a href="?page=admin_produit&action=update&id=<?php echo $donnee_tag[0]->produitId; ?>"><button type="button" class="btn btn-warning">Editer</button></a>
        <a href="?page=admin_produit&action=delete&id=<?php echo $donnee_tag[0]->produitId; ?>" onclick="return confirm('Sur ?');"><button type="button" class="btn btn-danger">Supprimer</button></a>
    </div>
    <?php foreach ($donnee_tag as $key => $value) { ?>

        <a href="?page=admin_catalogue&action=tag&id=<?php echo $value->id; ?>"><input class="btn btn-primary" name="ok" type="submit" value="<?php echo $value->nom; ?>"></a>
    <?php }
    ?>
</article>
<div>
    <?php if ($donnee->image != null):
        ?>
        <img class="img-thumbnail" src="<?php echo REP_IMAGES . $donnee->image; ?>" alt="<?php echo htmlentities($donnee->libelle, ENT_QUOTES); ?>">
    <?php endif; ?>
</div>
<a href="?page=admin_catalogue&action=categorie&id=<?php echo $donnee->categorie_id; ?>"> <h2 class="text-uppercase">Retour sur la catégorie</h2></a>