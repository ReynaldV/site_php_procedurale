<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <title><?php echo $objet; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>
        <body>

            <table border="1" width="100%" style="max-width: 500px;">
                <thead>
                    <tr>
                        <th><?php echo $objet; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><p>Bonjour <?php echo $genre; ?> <?php echo $nom; ?> !</p></td>
                    </tr>
                    <tr>
                        <td>Nous sommes le <?php echo date('d-m-Y H\h:i\mn:s\s'); ?></td>
                    </tr>
                    <tr>
                        <td>Votre email est : <?php echo $email; ?></td>
                    </tr>
                    <tr>
                        <td>Votre message est : <?php echo $message; ?></td>
                    </tr>
                </tbody>
            </table>
        </body>
    </body>
</html>

