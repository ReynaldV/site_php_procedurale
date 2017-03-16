<h1>AdminOKOK - Produits de la <?php echo $produits[0]->titre; ?></h1>
<hr>
<a href="?page=admin_produit&action=create"><button type="button" class="btn btn-success">+ Ajouter</button></a>
<table class="table table-striped">
    <tr>
        <td><strong>#</strong></td>

        <td><strong>Titre</strong></td>
        <td class="contenu"><strong>Contenu</strong></td>
        <td class="text-center imagetd"><strong>Image</strong></td>
        <td><strong>Prix</strong></td>

        <td><strong>Date</strong></td>
        <td class="text-center"><strong>Action</strong></td>
    </tr>
    <?php
    foreach ($produits as $donnee):
        var_dump($donnee);
        ?>
        <?php if ($donnee->publier == 0) : ?>
            <tr class="redBg">
                <td><?php echo $donnee->id; ?></td>
                <td><?php echo $donnee->libelle; ?><br /><strong>BROUILLON</trong></td>
            <?php else: ?>
            <tr>
                <td><?php echo $donnee->id; ?></td>
                <td><?php echo $donnee->libelle; ?></td>
            <?php endif; ?>
            <td class="contenu"><?php echo extrait($donnee->description); ?></td>
            <td class="text-center imageTd">
                <?php if ($donnee->image != null): ?>
                    <img class="img-thumbnail imageTab" src="<?php echo REP_THUMB . $donnee->image; ?>" alt="<?php echo htmlentities($donnee->libelle, ENT_QUOTES); ?>">
                <?php endif; ?>
            </td>
            <td>Prix : <?php echo $donnee->prix; ?></td>
            <td>Date : <?php echo formatDate($donnee->date); ?></td>
            <td>
                <a href="?page=admin_produit&action=update&id=<?php echo $donnee->id; ?>"><button type="button" class="btn btn-warning">Editer</button></a>
                <a href="?page=admin_produit&action=delete&id=<?php echo $donnee->id; ?>" onclick="return confirm('Sur ?');"><button type="button" class="btn btn-danger">Supprimer</button></a>


            </td>
        </tr>

        <?php
    endforeach;
    ?>
</table>