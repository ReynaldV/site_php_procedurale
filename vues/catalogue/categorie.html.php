<h1>Produits de la <?php echo $produits[0]->titre; ?></h1>
<hr>

<?php foreach ($produits as $donnee): ?>
    <div class="row">
        <article>
            <?php if ($donnee->image_originale != null) { ?>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <img class="img-thumbnail" src="<?php echo REP_IMAGES . $donnee->image_originale; ?>" alt="<?php echo htmlentities($donnee->libelle, ENT_QUOTES); ?>">
                </div>
                <div class="col-xs-12 col-sm-6 col-md-8">
                <?php } else { ?>
                    <div class="col-xs-12 col-sm-6 col-md-12">

                    <?php } ?>

                    <a href="<?php echo REP_RACINE ?>produit/<?php echo $donnee->slug; ?>-<?php echo $donnee->idprod; ?>"><h2 class="text-uppercase"><?php echo $donnee->libelle; ?></h2></a>

                    <p><?php echo extrait($donnee->description); ?></p>
                    <h3>Date : <?php echo formatDate($donnee->date); ?></h3>
                    <h4>Prix : <?php echo $donnee->prix; ?></h4>
                </div>
        </article>
    </div>
<?php endforeach; ?>