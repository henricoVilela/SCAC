<!DOCTYPE html>
<?php
  //Verifica se tem uma sessão ativa, se nao inicia uma sess

  //Faz conexão com o banco de dados
  include_once('functions/conn.php');

  //Verifica se foi clicado o botão de login
  if(isset($_POST['send']) AND !empty($_POST['send'])){
    echo $_POST['send'];

      // Verifica se houve POST e se o usuário ou a senha é(são) vazio
      if (!empty($_POST) AND (empty($_POST['user']) OR empty($_POST['password']))) {
            header("Location:index.php");
            exit();
      }

      // Validação do usuário/senha digitados

      if(strpos($_POST['user'],  '@' ) === false){
        echo "aluno";
        $sqlReadUser = "SELECT a.*, u.* FROM aluno a, usuarios u WHERE u.username = :user AND u.senha = :password LIMIT 1";
      }else{
        $sqlReadUser = "SELECT u.*, c.* FROM usuarios u, coordenador c WHERE u.username = :user AND u.senha = :password LIMIT 1";
      }


      try{
        $readUser = $db->prepare($sqlReadUser);
        $readUser->bindValue(':user', $_POST['user'], PDO::PARAM_STR);
        $readUser->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
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


            if($rsUser->tipo != 1){
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


  </head>
  <body class="bgAluno">
    <div class="container">
	     <div class="login-container center-block">
            <div id="output"></div>
            <div class="avatar">
              <h1>SCAC</h1>
              <h2>Sistema de Controle de Atividades Complementares</h2>
            </div>

            <div class="form-box">
                <form action="" id="formLogin" method="post">
                    <input name="user" type="text" placeholder="RA (Aluno) ou Email (Coordenador)">
                    <input name="password" type="password" placeholder="Senha">
                    <div class="row">
                      <div class="col options">
                        <h3 class="forget-password">
                          <a href="#">Esqueci minha senha</a><br><a href="cadastroAluno.php">Não possuo cadastro</a>
                        </h3>
                      </div>

                      <div class="col">
                        <button form="formLogin" name="send" value="acesso" class="btn-primary btn btn-info btn-block login" type="submit" >Login</button>
                      </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
      <h6>Barra do Garças/MT &copy; <?php echo date("Y"); ?> - Todos os direitos não reservados</h6>
  </body>
</html>
