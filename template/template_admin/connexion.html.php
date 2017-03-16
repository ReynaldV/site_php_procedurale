<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="Catalogue formation human booster">


        <title>Admin Catalogue human booster</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


        <!-- Custom styles for this template -->
        <link href="template/css/main.css" rel="stylesheet">


    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form method="post" class="form-horizontal">
                        <div class="form-group">
                            <label for="nom" class="col-sm-2 control-label">Nom:</label>
                            <input type="text" name="login" id="nom" placeholder="Entrez votre nom" autofocus>
                        </div>

                        <div class="form-group">
                            <label for="password">Password :</label>
                            <input type="password" name="password" id="password" placeholder="Entrez votre pass">
                        </div>
                        <br/>

                        <input type="hidden" name="token" value="<?php echo $token; ?>">
                        <div class="col-sm-offset-2 col-sm-10">

                            <button class="btn btn-primary" type="submit" name="submit" value="envoyer">envoyer</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </body>
    <footer>
    </footer>
</html>
