<h1>Admin Catégories</h1>
<hr>
<a href="?page=admin_catalogue&action=create"><button type="button" class="btn btn-success">+ Ajouter</button></a>
<table class="table table-striped">
    <tr>
        <td><strong>#</strong></td>

        <td><strong>Titre</strong></td>
        <td class="contenu"><strong>Contenu</strong></td>

        <td><a href="?page=admin_catalogue&action=listAllProduit"><button type="button" class="btn  btn-primary">Tous les produits (<?php echo $categories[0]->countAll; ?>)</button></a></td>
        <td class="text-center"><strong>Action</strong></td>
    </tr>
    <?php foreach ($categories as $value): ?>
        <tr>
            <td><?php echo $value->id; ?></td>
            <td><?php echo $value->titre; ?>

            </td>
            <td class="contenu"><?php echo extrait($value->contenu); ?></td>

            <td>
                <?php
                if ($value->count != 0) {
                    ?>
                    <a href="?page=admin_catalogue&action=categorie&id=<?php echo $value->id; ?>"><button type="button" class="btn btn-primary btn-sm"><?php echo $value->count; ?> prod.</button></a>
                    <?php
                } else {
                    ?>
                    aucun produit
                    <?php
                }
                ?>
            </td>
            <td>
                <a href="?page=admin_catalogue&action=update&id=<?php echo $value->id; ?>"><button type="button" class="btn btn-warning">Editer</button></a>
                <a href="?page=admin_catalogue&action=delete&id=<?php echo $value->id; ?>" onclick="return confirm('Sur ?');"><button type="button" class="btn btn-danger">Supprimer</button></a>

            </td>
        </tr>

    <?php endforeach; ?>
</table>