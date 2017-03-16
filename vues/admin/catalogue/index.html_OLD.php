<h1>Admin Catalogue</h1>
<hr>
<?php foreach ($categories as $donnee): ?>
    <article>

        <a href="?page=admin_catalogue&action=categorie&id=<?php echo $donnee->id; ?>"> <h2 class="text-uppercase"><?php echo $donnee->titre; ?> (<?php echo $donnee->count; ?>)</h2></a>

        <p><?php echo $donnee->contenu; ?></p>

    </article>
<?php endforeach; ?>