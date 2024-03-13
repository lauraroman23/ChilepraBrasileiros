<!DOCTYPE html>
<?php
include 'conexao.php';
?>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <title>Chile para brasileiros</title>
        <link href="../css/estilo.css" rel="stylesheet"/>
        <link href="../css/responsive.css" rel="stylesheet"/>
        <link rel="icon" type="image/jpg" sizes="32x32" href="img/favicom-chile.jpg">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta name="keywords" content="Chile, brasileiros">
    </head>
    <body>

        <?php
        function main($idConteudo) {
            GLOBAL $conexao;
            $idCategoria = $_GET['idCategoria'];
            $total_reg = "10";

            $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
            if (!$pagina) {
                $pc = "1";
            } else {
                $pc = $pagina;
            }

            $inicio = $pc - 1;
            $inicio = $inicio * $total_reg;

            $todos = mysqli_query($conexao, "SELECT id FROM comentarios WHERE resposta = '0' and IdConteudo=$idConteudo");
            $tr = mysqli_num_rows($todos); // verifica o número total de registros
            $tp = ceil($tr / $total_reg); // verifica o número total de páginas

            $resultado = mysqli_query($conexao, "SELECT id, email_usuario, nome_usuario, comentario, data_public_comentario FROM comentarios "
                    . "WHERE resposta = '0' and IdConteudo=$idConteudo and flag_bloqueio=0 ORDER BY data_public_comentario DESC LIMIT $inicio,$total_reg");

            if (mysqli_num_rows($resultado) == 0) {
                echo "<br><p>Não há comentários no fórum</p>";
            } else {
                while ($main_line = mysqli_fetch_array($resultado)) {
                    $pv = "";
                    $countRespostas = mysqli_query($conexao, "select count(*) n from (select * from comentarios where "
                    . "resposta = '1' and flag_bloqueio=0 order by comentario_resp_id, id) comentatios_sorted, "
                    . "(select @pv := " . $main_line['id'] . ") initialisation where find_in_set(comentario_resp_id, @pv) "
                    . "and length(@pv := concat(@pv, ',', id))");

                    $nroRespostas = mysqli_fetch_array($countRespostas);
                    $numResp = $nroRespostas['n'];
                    
                    $idPai = $main_line['id'];

                    echo "<ul class='lista_forum'>";
                    echo "<li>" . $main_line['nome_usuario'] . "</li>"
                    . "<li>" . $main_line['data_public_comentario'] . "</li><br><br>"
                    . "<li>" . $main_line['comentario'] . "</li><br>"
                    . "<li><button class='buttonForum'>Responder</button>";                   
                    userName($idConteudo, $idPai);
                    echo "</li>";

                    echo "<li><button class='buttonForum'>$numResp Comentários</button>";

                    $resultado2 = mysqli_query($conexao, "SELECT id, email_usuario, nome_usuario, comentario, data_public_comentario, IdConteudo FROM comentarios
                       WHERE comentario_resp_id = " . $main_line['id'] . "
                       AND resposta = '1' and flag_bloqueio=0 ORDER BY data_public_comentario");
                    if (mysqli_num_rows($resultado2) != 0)
                        expand($resultado2, $idConteudo);
                    echo "</li>";
                    echo "</ul>";
                }
            }

            $anterior = $pc - 1;
            $proximo = $pc + 1;
            echo "<div class='pagination'>";
            if ($pc > 1) {
                echo "<a href=\"conteudo.php?pagina=$anterior" . "&idConteudo=" . $idConteudo . "&idCategoria=" . $idCategoria . "\" class='link_paginacao'>&#60; Anterior</a>";
            }
            if ($pc < $tp) {
                echo "<a href=\"conteudo.php?pagina=$proximo" . "&idConteudo=" . $idConteudo . "&idCategoria=" . $idCategoria . "\" class='link_paginacao'>Próximo &#62;</a> ";
            }
            echo "</div>";
        }

        function expand($query, $idConteudo) {
            GLOBAL $conexao;
            $idCategoria = $_GET['idCategoria'];

            echo "<div class='div_respostas'>";
            while ($ex_line = mysqli_fetch_array($query)) {
                $pv = "";
                $countRespResp = mysqli_query($conexao, "select count(*) num from (select * from comentarios where "
                        . "resposta = '1' and flag_bloqueio=0 order by comentario_resp_id, id) comentatios_sorted, "
                        . "(select @pv := " . $ex_line['id'] . ") initialisation where find_in_set(comentario_resp_id, @pv) "
                        . "and length(@pv := concat(@pv, ',', id))");

                $nroRespResp = mysqli_fetch_array($countRespResp);
                $numRespResp = $nroRespResp['num'];
                
                $idPai = $ex_line['id'];

                echo "<ul class='lista_forum'>";
                echo "<li>" . $ex_line['nome_usuario'] . "</li>"
                . "<li>" . $ex_line['data_public_comentario'] . "</li><br><br>"
                . "<li>" . $ex_line['comentario'] . "</li><br>"
                . "<li><button class='buttonForum'>Responder</button>";                  
                userName($idConteudo, $idPai);
                echo "</li>";
                
                echo "<li><button class='buttonForum'>$numRespResp Comentários</button>";

                $ex_sql2 = mysqli_query($conexao, "SELECT id, email_usuario, nome_usuario, comentario, data_public_comentario, IdConteudo FROM comentarios
                  WHERE comentario_resp_id = " . $ex_line['id'] . "
                  AND resposta = '1' and flag_bloqueio=0 ORDER BY data_public_comentario");
                if (mysqli_num_rows($ex_sql2) != 0)
                    expand($ex_sql2, $idConteudo);
                echo "</li>";
                echo "</ul>";
            }
            echo "</div>";
        }
        
        function userName($idConteudo, $idPai) { 
            $idCategoria = $_GET['idCategoria'];
            
            echo "<div id='forum'>"
            . "<form action='enviarComentario.php' method='post' enctype='multipart/form-data' style='padding: 10px;'>
                    <textarea rows='3' cols='90' placeholder='Digite seu comentário aqui... ' name='comentario' required='true' style='width: 100%;'></textarea><br>
                    
                    Preencha os seus dados abaixo para fazer um comentário
                    <input type='email' name='email' placeholder='E-mail' required='true' style='width: 100%;'><br>
                    <input type='text' name='nome' placeholder='Nome' required='true' style='width: 100%;'><br>
                    <input type='checkbox' name='aviso' value='0' class='checkbox'> Avise-me sobre novos comentários por e-mail<br>

                    <input type='hidden' name='resposta' value='1'>
                    <input type='hidden' name='comentario_resp_id' value='$idPai'>   
                    <input type='hidden' name='idConteudo' value='$idConteudo'> 
                    <input type='hidden' name='idCategoria' value='$idCategoria'> 
                    <input type='submit' value='Publicar comentário' class='buttonForum'>
                </form>
            </div>";
        }
        ?> 
    </body>
</html>