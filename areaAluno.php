<!DOCTYPE html>
<?php
    if (!isset($_SESSION)) {
      session_start();
    }
    $idAluno = $_SESSION['UsuarioID'];
    $nomeAluno = $_SESSION['UsuarioNome'];
    // Verifica se não há a variável da sessão que identifica o usuário
    if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] != 1 )) {
      // Destrói a sessão por segurança
      session_destroy();
      // Redireciona o visitante de volta pro login
      header("Location: index.php"); exit();
    }
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>SCAC - Sistema de Controle de Atividades Complementares</title>

    <!-- MetasTag -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Import CSS -->
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" >
    <link rel="stylesheet" href="css/style.css">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

    <!-- Import Javacript-->
    <script src="offline/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="offline/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="offline/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    <!-- Calendar -->
    <script src="js/zabuto_calendar.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/zabuto_calendar.min.css">

    <!-- initialize the calendar on ready -->
    <script type="application/javascript">
      $(document).ready(function () {
          $("#my-calendar").zabuto_calendar({
            language: "pt"
          });

      });
    </script>


  </head>
  <body>
    <div class="container-fluid areaAluno">

      <div class="row justify-content-center">
        <div class="col col-xl-10">

          <!-- Header -->
          <div class="row profile">
            <!-- Titulo -->
            <div class="col-xl-3">
              <div class="logo">
                <h1 style="color:#0069D9;">SCAC</h1>
                <h2>Sistema de Controle de Atividades Complementares</h2>
              </div>
            </div>
          </div>

          <!-- Perfil do aluno -->
            <div class="row profile">
    		      <div class="col-xl-3">
    			          <div class="profile-sidebar" >
    				          <!-- Imagem usuário -->
    				          <div class="profile-userpic text-center">
    					          <img src="images/user_icon.png" class="img-responsive" alt="">
    				          </div>

                      <!-- Nome usuário -->
              				<div class="profile-usertitle">
              					<div class="profile-usertitle-name"><?php echo $nomeAluno;?></div>
              					<div class="profile-usertitle-job">Aluno</div>
              				</div>

                      <!-- Botoes -->
              				<div class="profile-userbuttons">
                        <a href="areaAluno.php" title="Página Inicial"><button type="button" class="btn btn-dark btn-sm"><i class="fab fa-fort-awesome"></i></button></a>
              					<button type="button" onclick="window.location.href='logout.php'" class="btn btn-danger btn-sm">Sair</button>
              				</div>

                      <!-- Menu -->
              				<div class="profile-usermenu">
                        <nav class="col-md-18 sidebar">
                          <div class="sidebar-sticky">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                   <a class="nav-link" href="#horasSubmenu" data-toggle="collapse" aria-expanded="false"><i class="fas fa-clock"></i>Horas</a>
                                   <ul class="collapse list-unstyled submenu" id="horasSubmenu" >
                                       <li><a href="?pagina=verificarHoras">Verificar Horas</a></li>
                                   </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#situacaoSubmenu" data-toggle="collapse" aria-expanded="false"><i class="fas fa-hand-peace"></i>Situação</a>
                                    <ul class="collapse list-unstyled submenu" id="situacaoSubmenu" >
                                        <li><a href="?pagina=registroAtividades">Verificar Situação</a></li>
                                    </ul>
                                </li>
                            </ul>
                          </div>
                        </nav>
              				</div> <!-- end Menu -->
    			          </div><!-- end div perfil -->
    		      </div><!-- end coluna perfil -->

              <!-- Conteudo -->
              <div class="col-md-9 border-top">
                <div class="profile-content">
                  <?php
                    if(isset($_GET['pagina'])){
                      $pagina = $_GET['pagina'];
                      if($pagina == ""){
                        include("mainAluno.php");
                      } else {

                        include($pagina.".php");

                      }
                    }else{
                      include("mainAluno.php");
                    }
                  ?>
                </div><!-- END DIV ROW -->
    		      </div> <!-- end coluna conteudo -->
    	      </div> <!-- end conteudo -->
          </div> <!-- end coluna 1 -->
      </div> <!-- end div linha -->
    </div> <!-- end div container -->
  </body>
</html>
