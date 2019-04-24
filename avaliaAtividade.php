<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>SCAC - Sistema de Controle de Atividades Complementares</title>

    <!-- MetasTag -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Import CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" >
    <link rel="stylesheet" href="css/style.css">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

    <!-- Import Javacript-->
    <script src="offline/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="offline/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="offline/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </head>
  <body class="bgAluno">
    <div class="container">
	     <div class="cadAluno-container center-block">
            <div id="output"></div>
            <div class="avatar">
              <h1>SCAC</h1>
              <h2>Sistema de Controle de Atividades Complementares</h2>
            </div>
            <div class="form-box">

            <?php
              /* Chama a conexao */
              include_once("functions/conn.php");

              /* se receber da url o id da atividade */
              if(!empty($_GET['atividade'])){

                //Recupera o id da atividade atraves da url
                $idAtividade = $_GET['atividade'];

                //Se o botão de salvar a atividade for clicado
                if(isset($_POST['salvarAtividade'])){

                  $sqlCre = 'UPDATE atividades_comp SET avaliacao_salva = :avaliacao, comentario = :comentario WHERE id_atividade = :idAtividade';
                  try{
                    $create = $db->prepare($sqlCre);
                    $create->bindValue(':idAtividade', $idAtividade, PDO::PARAM_INT);
                    $create->bindValue(':avaliacao', 1, PDO::PARAM_INT);
                    $create->bindValue(':comentario', $_POST['comentario'], PDO::PARAM_STR);
                    if($create->execute()){
                      echo "<div class=\"sucesso\">Avaliação salva para continuar mais tarde!</div";

                    }
                  } catch (PDOException $e){
                    echo "<div class=\"erro\">Erro ao salvar avaliacao!</div>";
                  }

                } //End post


                //Se o botão de enviar avaliacao for clicado
                if(isset($_POST['enviarAvaliacao'])){

                  $sqlCre = 'UPDATE atividades_comp SET avaliacao_salva = :avaliacao, comentario = :comentario, status = :status WHERE id_atividade = :idAtividade';
                  try{
                    $create = $db->prepare($sqlCre);
                    $create->bindValue(':idAtividade', $idAtividade, PDO::PARAM_INT);
                    $create->bindValue(':avaliacao', 0, PDO::PARAM_INT);
                    $create->bindValue(':status', 1, PDO::PARAM_INT);
                    $create->bindValue(':comentario', $_POST['comentario'], PDO::PARAM_STR);
                    if($create->execute()){
                      echo "<div class=\"sucesso\">Avaliação concluida com sucesso!</div>";

                    }
                  } catch (PDOException $e){
                    echo "<div class=\"erro\">Erro ao submeter avaliação!</div>";
                  }

                } //End post



              //faz a pesquisa da atividade no banco de dados
              $sqlRead = "SELECT a.*, ati.* FROM aluno a, atividades_comp ati WHERE a.id_aluno = ati.id_aluno and ati.status = 4 and ati.id_atividade = :idAtividade ";

              try{
                  $read = $db->prepare($sqlRead);
                  $read->bindValue(':idAtividade', $idAtividade, PDO::PARAM_INT);
                  $read->execute();

                  $countResult = $read->rowCount();
              } catch (PDOException $e) {
                  echo $e->getMessage();
              }

              while ($rs = $read->fetch(PDO::FETCH_OBJ)){


            ?>



                <!-- Formulário -->
                <form method="POST">

                  <div class="dadosAtividade">
                    <strong>Nome Aluno: </strong><?php echo $rs->nome;?><br>
                    <strong>Titulo: </strong><?php echo $rs->titulo;?> <br>
                    <strong>Tipo: </strong> <?php echo $rs->tipo;?><br>
                    <strong>Carga Horaria: </strong><?php echo $rs->carga_horaria;?> <br>
                    <strong>Carga Aprovada: </strong><?php echo $rs->carga_computada;?> <br>
                    <strong>Data de submissão: </strong> <?php echo  date("d/m/Y H:i:s", strtotime($rs->data_envio));?><br>
                    <?php if(!$rs->impresso == 0){ ?>
                      <strong>Visualizar atividade: </strong><a href="atvd/<?php echo $rs->nome_arq;?>" target="_blank" title="Baixar arquivo"> <i class="fas fa-file-pdf"></i></a><br><br>
                    <?php }else{
                      echo "Atividade foi entregue impressa!<br>";
                    }?>
                    <strong>Professor: </strong> <?php echo $rs->professor;?><br>
                    <strong>Comentário: </strong><br>
                    <textarea name="comentario" rows="8" cols="50">  <?php if($rs->avaliacao_salva == 1){ echo $rs->comentario; }?></textarea>
                    <br><br>

                  </div> <!-- End dados atividades -->


                    <!-- Botoẽs para envio -->
                    <button type="submit" name="salvarAtividade" value="<?php echo $rs->id_atividade;?>" class="btn btn-danger">Salvar Rascunho</button>
                    <button type="submit" name="enviarAvaliacao" value="<?php echo $rs->id_atividade;?>" class="btn btn-primary">Submeter Avaliação</button>
                </form>
                <?php }  } ?>
            </div>
        </div>
    </div>
      <h6>Barra do Garças/MT &copy; <?php echo date("Y"); ?> - Todos os direitos não reservados</h6>
  </body>
</html>
