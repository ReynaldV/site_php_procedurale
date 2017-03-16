<h1>Edito</h1>
<hr>
<div class="row">
    <article>

        <?php if ($donnee->image_originale != null) { ?>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <img class="img-thumbnail" src="<?php echo REP_IMAGES . $donnee->image_originale; ?>" alt="<?php echo htmlentities($donnee->titre, ENT_QUOTES); ?>">
            </div>
            <div class="col-xs-12 col-sm-6 col-md-8">
            <?php } else { ?>
                <div class="col-xs-12 col-sm-6 col-md-12">

                <?php } ?>

                <h2 class="text-uppercase"><?php echo $donnee->titre; ?></h2>

                <p><?php echo $donnee->contenu; ?></p>
                <h3>Auteur : <?php echo $donnee->login; ?></h3>
                <h4>Date : <?php echo formatDate($donnee->date); ?></h4>
            </div>
    </article>
</div>