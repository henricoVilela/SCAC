<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>SCAC</title>

    <!-- MetasTag -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Import CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" >
    <link rel="stylesheet" href="css/style.css">

    <!-- Import Javacript-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="js/login.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
    <script>
    $(document).ready(function () {
        var $seuCampoCpf = $("#cpf");
        $seuCampoCpf.mask('000.000.000-00', {reverse: true});
    });$(document).ready(function () {
        var $seuCampoCpf = $("#data");
        $seuCampoCpf.mask('00/00/0000', {reverse: true});
    });
</script>
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
              //Se o botão de nome enviar for clicado
        			if(isset($_POST['cadastrar'])){

                  $ultimoId = Null;
                  //Insere os dados do aluno na tabela aluno
        		      $sql = "INSERT INTO aluno (RA, nome, sexo, curso, email, data_nsc, CPF, dataCad) VALUES (:RA, :nome, :sexo, :curso, :email, :data_nsc, :CPF, :dataCad)";

        					try{

        						$create = $db->prepare($sql);

        						$create->bindValue(':RA', $_POST['RA'], PDO::PARAM_STR);
        						$create->bindValue(':nome', $_POST['nome'], PDO::PARAM_STR);
        						$create->bindValue(':sexo', $_POST['sexo'], PDO::PARAM_STR);
                    $create->bindValue(':curso', $_POST['curso'], PDO::PARAM_STR);
                    $create->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
                    $create->bindValue(':data_nsc', $_POST['data_nsc'], PDO::PARAM_STR);
                    $create->bindValue(':CPF', $_POST['CPF'], PDO::PARAM_STR);
        						$create->bindValue(':dataCad', date('Y-m-d H:i:s'), PDO::PARAM_STR);

                    //Executa a query
        						if($create->execute()){
        							echo "Aluno cadastrado com Sucesso!";
        						} else {
                      echo "Falha no cadastro";
                    }
                    $ultimoId =  $db->lastInsertId();

        					} catch (PDOException $e){
        							echo "Erro: ".$e->getCode()." - Falha no cadastro do aluno!";
        					}

                  if($_POST['senha'] == $_POST['senhaconfirm']){

                    //Insere os dados na tabela usuário
                    $sql = "INSERT INTO usuarios (username, idAssociado, senha, status, tipo, data) VALUES (:username, :idAssociado, :senha, :status, :tipo, :data)";
                    try{

          						$create = $db->prepare($sql);

          						$create->bindValue(':username', $_POST['RA'], PDO::PARAM_STR);
                      $create->bindValue(':idAssociado', $ultimoId, PDO::PARAM_STR);
          						$create->bindValue(':senha', $_POST['senha'], PDO::PARAM_STR);
          						$create->bindValue(':status', 1, PDO::PARAM_STR);
                      $create->bindValue(':tipo', 1, PDO::PARAM_STR);
          						$create->bindValue(':data', date('Y-m-d H:i:s'), PDO::PARAM_STR);

                      //Executa a query
          						if($create->execute()){
          							echo "Aluno cadastrado com Sucesso!";
          						} else {
                        echo "Falha no cadastro";
                      }


          					} catch (PDOException $e){
          							echo "Erro: ".$e->getCode()." - Falha no cadastro do usuarioo!";
          					}
                  }else{
                    echo "As senhas não coincidem";
                  }

        				} //End post
            ?>





                <form id="cadAluno" method="POST">
                    <h3>Cadastro Aluno</h3>
                    <input name="RA" type="text" placeholder="RA" required>
                    <input name="nome" type="text" placeholder="Nome Completo" required>
                    <input name="CPF" type="text" placeholder="CPF" maxlength="14" id ="cpf" required>
                      <input name="data_nsc" id="data" type="text" placeholder="Data de Nascimento" required>
                    <div class="form-group">
                      <select name="sexo" class="form-control"  required>
                        <option >Selecione o sexo</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Feminino">Feminino</option>
                        <option value="Indefinido">Indefinido</option>
                      </select>
                    </div>
                    <div class="form-group">

                      <?php

                				//FAZ A PESQUISA CURSO NO BANCO DE DADOS
                				$sqlRead = "SELECT nome FROM cursos ORDER BY nome ASC";

                				try{
                					$read = $db->prepare($sqlRead);
                					$read->execute();
                				} catch (PDOException $e) {
                					echo $e->getMessage();
                				}

                			?>

                      <select name="curso" class="form-control" id="exampleFormControlSelect1" required>
                        <option>Selecione o Curso</option>
                        <?php
                          while ($rs = $read->fetch(PDO::FETCH_OBJ)){
                            echo "<option value=\"".$rs->nome."\">".$rs->nome."</option>";
                          }
                        ?>

                      </select>
                    </div>
                    <input name="email" type="email" placeholder="E-mail" required>
                    <input name="senha" type="password" placeholder="Senha" required>
                    <input name="senhaconfirm" type="password" placeholder="Repita a senha" required >
                    <div class="row">
                      <div class="col options">
                        <h3 class="forget-password">
                          <a href="index.php">Já possuo cadastro</a>
                        </h3>
                      </div>
                      <input type="hidden" value="cadastar" name="cadastrar">
                      <div class="col">
                        <button name="send" value="cadastar" class="btn-primary btn btn-info btn-block cadAluno" form="cadAluno" type="submit">Cadastrar</button>
                      </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
      <h6>Barra do Garças/MT &copy; <?php echo date("Y"); ?> - Todos os direitos não reservados</h6>
  </body>
</html>
