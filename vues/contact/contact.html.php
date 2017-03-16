<h1>CONTACT</h1>

<div class="form-group">
    <form method="post">
        <?php
        if ($success !== ''):
            ?>
            <p class="alert alert-success" style="border-radius: 5px;padding:15px;color:green;">Bonjour <?php echo $genre; ?> <?php echo $nom; ?> confirmation de votre abonnement</p>

            <?php
            var_dump($success);
        endif;
        if ($erreur !== ''):
            ?>
            <p class="alert alert-danger" style="border-radius: 5px;padding:15px;color:red;"><strong><?php echo $erreur; ?></strong></p>
            <?php
        endif;
        ?>
        <fieldset>
            <legend>Gardons le contact...</legend>
            <div>
                <label class="radio-inline">Mme</label>
                <input type="radio" name="genre" value="Mme" />
                <label class="radio-inline">Mr</label>
                <input type="radio" name="genre" value="Mr" />
            </div>
            <div class="form-group">
                <label for="nom">Nom</label>
                <input class="form-control" id="nom" name="nom" type="text" placeholder="Votre nom">
            </div>

            <div class="form-group">
                <label for="email">E-mail</label>
                <input class="form-control" id="email" name="email" type="email" placeholder="Votre e-mail">
            </div>
            <label for="email">Objet</label>
            <select name="objet" class="form-control">
                <option value="0" selected>Sélectionner...</option>
                <option value="truc">Service truc</option>
                <option value="machin">Service machin</option>
            </select>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" name="message" placeholder="Votre message"></textarea>
            </div>
            <input class="btn btn-primary" name="ok" type="submit" value="ENVOYER">
        </fieldset>
    </form>
</div>