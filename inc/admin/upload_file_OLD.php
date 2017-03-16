
<hr>
<form method="POST" action="inc/admin/image.php" enctype="multipart/form-data">

    <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
    <?php
    if (isset($edito->editoId)) {
        ?>
        <input type="hidden" name="idEdito" value="<?php echo $edito->editoId; ?>"/>
        <?php
    } elseif (isset($article->articleId)) {
        ?>
        <input type="hidden" name="idArticle" value="<?php echo $article->articleId; ?>"/>
        <?php
    }
    ?>
    <label for="titre">Modifier image</label>
    <input class="text-left" id="imgfile" name="imgfile" type="file" />(format .jpg/.gif/.png)

    <input class="btn btn-primary" name="ok" type="submit" value="Enregistrer">
</form>