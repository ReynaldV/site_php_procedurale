<h1>Detail article Magazine</h1>
<hr>

<article>

    <h2 class="text-uppercase"><?php echo $donnee->titre; ?></h2>

    <p><?php echo $donnee->contenu; ?></p>
    <h3>Auteur : <?php echo $donnee->login; ?></h3>
    <h4>Date : <?php echo formatDate($donnee->date); ?></h4>
</article>
<div>
    <?php if ($donnee->image != null): ?>
        <img class="img-thumbnail" src="<?php echo REP_IMAGES . $donnee->image_originale; ?>" alt="<?php echo htmlentities($donnee->titre, ENT_QUOTES); ?>">
    <?php endif; ?>
</div>