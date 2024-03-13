<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <title>Chile para brasileiros</title>
        <link href="css/estilo.css" rel="stylesheet"/>
        <link href="css/responsive.css" rel="stylesheet"/>
        <link rel="icon" type="image/jpg" sizes="32x32" href="img/favicom-chile.jpg">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta name="keywords" content="Chile, brasileiros">
    </head>
    <body>

        <div id="container">
            <?php include 'header.php'; ?>

            <article>
                <h2>Entre em contato conosco</h2>
                <form action="enviar.php" method="POST" enctype="multipart/form-data">
                    <label for="email">E-mail</label><br>
                    <input type="email" id="email" name="email" placeholder="Insira seu email" size="40" required="true"><br>
                    <label for="assunto">Assunto</label><br>
                    <input type="text" id="assunto" name="assunto" placeholder="Assunto" size="40" required="true"><br>
                    <label for="mensagem">Mensagem</label><br>
                    <textarea name="mensagem" id="mensagem" placeholder="Escreva sua mensagem aqui" rows="6" cols="45" required="true"></textarea><br>
                    <input type="submit" value="Enviar" class="button">
                </form>
            </article>

            <?php include 'footer.php'; ?>
        </div>

    </body>
</html>