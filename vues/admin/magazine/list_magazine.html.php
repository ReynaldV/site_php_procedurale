<h1>Admin Magazine</h1>
<hr>
<a href="?page=admin_magazine&action=create"><button type="button" class="btn btn-success">+ Ajouter</button></a>
<table class="table table-striped">
    <tr>
        <td><strong>#</strong></td>

        <td><strong>Titre</strong></td>
        <td class="contenu"><strong>Contenu</strong></td>
        <td class="text-center"><strong>Image</strong></td>
        <td><strong>Auteur</strong></td>

        <td><strong>Date</strong></td>
        <td class="text-center"><strong>Action</strong></td>
    </tr>
    <?php foreach ($donnee as $article): ?>

        <?php if ($article->publier == 0) { ?>
            <tr class="redBg">
                <td><?php echo $article->articleId; ?></td>
                <td><?php echo $article->titre; ?><br /><strong>BROUILLON</trong></td>
            <?php } else { ?>
            <tr>
                <td><?php echo $article->articleId; ?></td>
                <td><?php echo $article->titre; ?></td>
            <?php } ?>


            <td class="contenu"><?php echo extrait($article->contenu); ?></td>
            <td class="text-center imageTd">
                <?php if ($article->image != null): ?>
                    <img class="img-thumbnail imageTab" src="<?php echo REP_THUMB . $article->image; ?>" alt="<?php echo htmlentities($article->titre, ENT_QUOTES); ?>">
                <?php endif; ?>
            </td>
            <td><?php echo $article->login; ?></td>
            <td><?php echo formatDate($article->date); ?></td>
            <td>
                <a href="?page=admin_magazine&action=update&id=<?php echo $article->articleId; ?>"><button type="button" class="btn btn-warning">Editer</button></a>
                <a href="?page=admin_magazine&action=delete&id=<?php echo $article->articleId; ?>" onclick="return confirm('Sur ?');"><button type="button" class="btn btn-danger">Supprimer</button></a>

            </td>
        </tr>

    <?php endforeach; ?>
</table>