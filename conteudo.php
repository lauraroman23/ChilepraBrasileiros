<!DOCTYPE html>
<?php
include 'includes/conexao.php';
include 'includes/funcoes.php';

$idCategoria = $_GET['idCategoria'];
?>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <title>Chile para brasileiros</title>
        <link href="css/estilo.css" rel="stylesheet"/>
        <link href="css/responsive.css" rel="stylesheet"/>
        <link rel="icon" type="image/jpg" sizes="32x32" href="img/favicom-chile.jpg">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta name="keywords" content="Chile, brasileiros">
         <!-- Meu kit de fontawesome -->
        <script src="https://kit.fontawesome.com/0389ff20e6.js" crossorigin="anonymous"></script>
    </head>
    <body>

        <div id="container">
            <?php include 'header.php'; ?>

            <!--Conteúdo-->
            <div class="main">
                <?php
                $registroCat = mysqli_query($conexao, "select nome from categoria where id=$idCategoria");
                $nomeCat = mysqli_fetch_array($registroCat);
                ?>

                <!--Breadcrumbs-->
                <ul class="breadcrumb">
                    <li><a href="index.php">Início</a></li>
                    <li><?php echo $nomeCat['nome']; ?></li>
                </ul>

                <?php
                $resultado = mysqli_query($conexao, "select * from conteudo where idCategoria=$idCategoria ORDER BY subcategoria");
                while ($registro = mysqli_fetch_array($resultado)) {

                    $idConteudo = $registro['id'];
                    $count = mysqli_query($conexao, "select count(*) nro from comentarios where idConteudo=$idConteudo");
                    $registroCount = mysqli_fetch_array($count);
                    $qtCom = $registroCount['nro'];
                    ?>

                    <div class="row2">
                        <h3><?php echo $registro['titulo']; ?></h3><br>
                        <div class="column2">
                            <picture>
                                <source type="image/webp" srcset="img/img<?php echo $idCategoria . '/' . $registro['imagem']; ?>" alt="<?php echo $registro['alt']; ?>">
                                <source type="image/jpeg" srcset="img/img<?php echo $idCategoria . '/' . $registro['imagem']; ?>" alt="<?php echo $registro['alt']; ?>">
                                <img src="img/img<?php echo $idCategoria . '/' . $registro['imagem']; ?>" alt="<?php echo $registro['alt']; ?>">
                            </picture>

                            <!-- Go to www.addthis.com/dashboard to customize your tools
                            <div class="addthis_inline_share_toolbox"></div> -->
                            <div class="comments">
                                <span class="secao-forum"> 
                                    <a class="forum-site" href="#forum">
                                        <i class="far fa-comment-alt" style="font-size: 15px; cursor: pointer;"></i>
                                    </a>
                                </span>
                                <div class="forum-site" id="forum">
                                    <form action="enviarComentario.php" method="post" enctype="multipart/form-data" style="padding: 10px;">
                                        <textarea rows="3" cols="90" placeholder="Digite seu comentário aqui... " name="comentario" required="true" style="width: 100%;"></textarea><br>

                                        <p>Preencha os seus dados abaixo para fazer um comentário</p>
                                        <input type="email" name="email" placeholder="E-mail" required="true" style="width: 100%;"><br>
                                        <input type="text" name="nome" placeholder="Nome" required="true" style="width: 100%;"><br>
                                        <input type="checkbox" name="aviso" value="0" class="checkbox"><label> Avise-me sobre novos comentários por e-mail</label><br>

                                        <input type="hidden" name="resposta" value="0">
                                        <input type="hidden" name="comentario_resp_id" value="">
                                        <input type="hidden" name="idConteudo" value="<?php echo $idConteudo; ?>">
                                        <input type="hidden" name="idCategoria" value="<?php echo $idCategoria; ?>">
                                        <input type="submit" value="Publicar comentário" class="buttonForum" style="font-size: 13px;">
                                    </form>
                                </div>

                                <span class="secao-comentarios"> 
                                    <a class="comentarios" href="#com" style="font-family: 'Open Sans', sans-serif; font-size: 15px;">
                                        <?php echo $qtCom; ?> Comentários</a>
                                </span>
                                <div class="comentarios" id="com">
                                    <?php
                                    main($idConteudo);
                                    ?> 
                                </div>
                            </div>
                        </div>
                        <div class="column2">
                            <!--<p style="text-align: left;"><?php echo substr($registro['subcategoria'], 2); ?></p>-->
                            <!--<p><?php echo $registro['data_publicacao']; ?></p>-->
                            <p><?php echo $registro['texto']; ?></p><br>
                            <p style="text-align: left;"><?php echo $registro['link']; ?></p><br>
                        </div>
                    </div>
                    <hr size="1">
                    <?php
                }
                mysqli_free_result($resultado);
                mysqli_close($conexao);
                ?>
            </div>
            <?php include 'footer.php'; ?>
        </div>

        <script>
            //Collapse cadastro comentário
            var com = document.getElementsByClassName("secao-forum");
            var i;

            for (i = 0; i < com.length; i++) {
                com[i].addEventListener("click", function () {
                    this.classList.toggle("activeForum");
                    var content = this.nextElementSibling;
                    if (content.style.display === "block") {
                        content.style.display = "none";
                    } else {
                        content.style.display = "block";
                    }
                });
            }
        </script>

        <script>
            //Collapse dos comentários
            var com = document.getElementsByClassName("secao-comentarios");
            var i;

            for (i = 0; i < com.length; i++) {
                com[i].addEventListener("click", function () {
                    this.classList.toggle("activeComments");
                    var content = this.nextElementSibling;
                    if (content.style.display === "block") {
                        content.style.display = "none";
                    } else {
                        content.style.display = "block";
                    }
                });
            }
        </script>

        <script>
            //Collapse nos botões de resposta
            var coll = document.getElementsByClassName("buttonForum");
            var i;

            for (i = 0; i < coll.length; i++) {
                coll[i].addEventListener("click", function () {
                    this.classList.toggle("active");
                    var content = this.nextElementSibling;
                    if (content.style.display === "block") {
                        content.style.display = "none";
                    } else {
                        content.style.display = "block";
                    }
                });
            }
        </script>

        <script>
            //Paginação
            var pag = document.getElementsByClassName("link_paginacao");

            pag.addEventListener("click", function () {
                window.location.href = '#forum';
            });
        </script>

        <!-- Go to www.addthis.com/dashboard to customize your tools
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5cfff3b67830fe0c"></script>-->
    </body>
</html>