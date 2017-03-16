<h1>Admin Edito</h1>
<hr>
<a href="?action=create"><button type="button" class="btn btn-success">+ Ajouter</button></a>
<table class="table table-striped">
    <tr>
        <td><strong>#</strong></td>

        <td><strong>Titre</strong></td>
        <td class="contenu"><strong>Contenu</strong></td>
        <td class="text-center imagetd"><strong>Image</strong></td>
        <td><strong>Auteur</strong></td>

        <td><strong>Date</strong></td>
        <td class="text-center"><strong>Action</strong></td>
    </tr>
    <?php foreach ($donnee as $edito): ?>
        <tr>
            <td><?php echo $edito->editoId; ?></td>
            <td><?php echo $edito->titre; ?></td>
            <td class="contenu"><?php echo extrait($edito->contenu); ?></td>
            <td class="text-center imageTd">
                <?php if ($edito->image != null): ?>
                    <img class="img-thumbnail imageTab" src="<?php echo REP_THUMB . $edito->image; ?>" alt="<?php echo htmlentities($edito->titre, ENT_QUOTES); ?>">
                <?php endif; ?>
            </td>
            <td><?php echo $edito->login; ?></td>
            <td><?php echo formatDate($edito->date); ?></td>
            <td>
                <a href="?action=update&id=<?php echo $edito->editoId; ?>"><button type="button" class="btn btn-warning">Editer</button></a>
                <a href="?action=delete&id=<?php echo $edito->editoId; ?>" onclick="return confirm('Sur ?');"><button type="button" class="btn btn-danger">Supprimer</button></a>


            </td>
        </tr>

        <?php
    endforeach;
    ?>
</table>