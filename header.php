<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <title>Chile para brasileiros</title>
        <link href="css/estilo.css" rel="stylesheet"/>
        <link href="css/responsive.css" rel="stylesheet"/>
        <link rel="icon" type="image/jpg" sizes="32x32" href="img/favicom-chile.jpg">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta name="keywords" content="Chile, brasileiros">
    </head>
    <body>

        <!--Banner-->
        <header class="header">
            <picture>
                <source type="image/webp" srcset="img/capaChile.webp" alt="Santiago com a cordilheira dos Andes no fundo">
                <source type="image/jpeg" srcset="img/capaChile.jpg" alt="Santiago com a cordilheira dos Andes no fundo">
                <img src="img/capaChile.jpg" alt="Santiago com a cordilheira dos Andes no fundo">
            </picture>
            <div class="text-block">
                <h1>Chile para brasileiros</h1>
                <h2>compras - turismo - lazer</h2>
            </div>

            <!--Compartilhamento nas redes sociais
            <div class="redes_sociais">
                <div class="addthis_inline_share_toolbox"></div>
            </div>-->
        </header>

        <!-- Menu -->
        <ul id="navbar"> 
            <li><a href="index.php">Início</a></li>
            <div id="myLinks">
                <li><a href="contato.php">Contato</a></li>
            </div>
            <a href="javascript:void(0);" class="icon" onclick="myFunction2()">
                <i class="fa fa-bars"></i>
            </a>
        </ul>

        <!-- Go to www.addthis.com/dashboard to customize your tools 
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5d48870cf279feed"></script>--> 

        <script>
            //Menu Fixo
            window.onscroll = function () {
                myFunction()
            };

            var navbar = document.getElementById("navbar");
            var sticky = navbar.offsetTop;

            function myFunction() {
                if (window.pageYOffset >= sticky) {
                    navbar.classList.add("sticky")
                } else {
                    navbar.classList.remove("sticky");
                }
            }
        </script>        

        <script>
            //Menu mobile
            function myFunction2() {
                var x = document.getElementById("myLinks");
                if (x.style.display === "block") {
                    x.style.display = "none";
                } else {
                    x.style.display = "block";
                }
            }
        </script>
    </body>
</html>