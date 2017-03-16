<?php
if ($erreur !== ''):
    ?>
    <p class="alert alert-danger" style="border-radius: 5px;padding:15px;color:red;"><strong><?php echo $erreur; ?></strong></p>
    <?php
else:
    if ($success !== ''):
        ?>
        <p class="alert alert-success" style="border-radius: 5px;padding:15px;color:green;"><strong><?php echo $success; ?></strong></p>
        <?php
    endif;
endif;
?>
<hr/>
<h1>Inscription Newsletter</h1>
<div class="form-group">

    <form method="post" action="">

        <div class="form-group">
            <label for="email">E-mail</label>
            <input class="form-control" id="email" name="email" type="email" placeholder="Votre e-mail">
        </div>

        <input class="btn btn-primary" name="newsletter" type="submit" value="Envoyer">
    </form>
</div>