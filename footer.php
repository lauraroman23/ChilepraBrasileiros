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

        <!--Rodapé-->
        <footer>
            <ul class="footer_ul">
                <li><a href="sobre_nos.php">Sobre nós</a></li>
                <li><a href="contato.php">Contato</a></li>
            </ul>
            <p id="f"></p>
        </footer>

        <script>
            var d = new Date();
            document.getElementById("f").innerHTML = "Desenvolvido por chileparabrasileiros. Copyright " +
                    d.getFullYear();
        </script> 

    </body>
</html>