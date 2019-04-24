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

    <!-- Import Javacript-->
    <script src="offline/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="offline/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="offline/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="js/login.js"></script>


  </head>
  <body class="bgAluno">
    <div class="container">
	     <div class="login-container center-block">
            <div id="output"></div>
            <div class="avatar">
              <h1 style="color:#218838;">SCAC</h1>
              <h2>Sistema de Controle de Atividades Complementares</h2>
            </div>
            <?php
              //Verifica se tem uma sessão ativa, se nao inicia uma sess
            	if (!isset($_SESSION)) session_start();

              //Verifica se foi clicado o botão de login
            	if(isset($_POST['login'])){


                  //Faz conexão com o banco de dados
                  include_once('functions/conn.php');

            			// Verifica se houve POST e se o usuário ou a senha é(são) vazio
            			if (!empty($_POST) AND (empty($_POST['userSCAC']) OR empty($_POST['passwordSCAC']))) {
              				 header("Location:index.php"); exit();
            	    }

            			// Validação do usuário/senha digitados

                  if(strpos($_POST['userSCAC'],  '@' ) === false){
                    $sqlReadUser = "SELECT a.*, u.* FROM aluno a, usuarios u WHERE u.idAssociado = a.id_aluno AND u.username = :user AND u.senha = :password LIMIT 1";
                  }else{
                    $sqlReadUser = "SELECT u.*, c.* FROM usuarios u, coordenador c WHERE u.id_coordenador = c.id_coordenador AND u.username = :user AND u.senha = :password LIMIT 1";
                  }


            			try{
            				$readUser = $db->prepare($sqlReadUser);
            				$readUser->bindValue(':user', $_POST['userSCAC'], PDO::PARAM_STR);
            				$readUser->bindValue(':password', $_POST['passwordSCAC'], PDO::PARAM_STR);
            				$readUser->execute();
            				$countResult = $readUser->rowCount();

            			} catch (PDOException $e) {
            				echo $e->getMessage();
            			}

            			if($countResult != 1){
                      //Nenhum usuario encontrado

            					echo "<div class=\"erro\">Erro, login ou senha errados!</div>";
            			} else {
                      //Acesslo liberado

                      //Buscar os dados do usuario
            			    while ($rsUser = $readUser->fetch(PDO::FETCH_OBJ)){

              				     // Salva os dados encontrados na sessão
                          if($rsUser->tipo == 1){
                            //é aluno
              					    $_SESSION['UsuarioID'] = $rsUser->id_aluno;
                            $_SESSION['UsuarioNome'] = $rsUser->nome;
                          }else{
                            //é coordenador
                            $_SESSION['UsuarioID'] = $rsUser->id_coordenador;
                            $_SESSION['UsuarioNome'] = $rsUser->nome_coordenador;
                          }

              					   $_SESSION['UsuarioNivel'] = $rsUser->tipo;


                        if($rsUser->tipo == 1){
                          //é aluno
                          header("Location:areaAluno.php"); exit();
                        } else{
                          // é Coordenador
                          header("Location:areaCoordenador.php"); exit();
                        }
                      }

            			}
            		}
            ?>


            <div class="form-box">
                <form method="post">
                    <input name="userSCAC"  type="text" placeholder="RA (Aluno) ou Email (Coordenador)">
                    <input name="passwordSCAC" type="password" placeholder="Senha">
                    <div class="row">
                      <div class="col options">
                        <h3 class="forget-password">
                        <a href="cadastroAluno.php">Não possuo cadastro</a>
                        </h3>
                      </div>
                      <div class="col">
                        <button value="login" class="btn-primary btn btn-info btn-block login" type="submit" name="login">Login</button>
                      </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
      <h6>Barra do Garças/MT &copy; <?php echo date("Y"); ?> - Todos os direitos não reservados</h6>
  </body>
</html>
