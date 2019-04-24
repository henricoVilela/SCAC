<!DOCTYPE html>
<?php
  if (!isset($_SESSION)) {
    session_start();
  }

  $idCoordenador = $_SESSION['UsuarioID'];
  $nomeCoordenador = $_SESSION['UsuarioNome'];
  // Verifica se não há a variável da sessão que identifica o usuário
  if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] != 2 )) {
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
    <script src="js/login.js"></script>

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
    <div class="container-fluid areaCoordenador">

      <div class="row justify-content-center">
        <div class="col col-xl-10">

          <!-- Header -->
          <div class="row profile">
            <!-- Titulo -->
            <div class="col-xl-3">
              <div class="logo">
                    <h1 style="color:#DB2727;">SCAC</h1>
                    <h2>Sistema de Controle de Atividades Complementares</h2>
              </div>
            </div>
          </div> <!-- End header -->

          <!-- Perfil -->
            <div class="row profile">
    		      <div class="col-xl-3">
    			          <div class="profile-sidebar" >
    				          <!-- Imagem usuário -->
    				          <div class="profile-userpic text-center">
    					          <img src="images/user_icon.png" class="img-responsive" alt="">
    				          </div>

                      <!-- Nome usuário -->
              				<div class="profile-usertitle">
              					<div class="profile-usertitle-name"><?php echo $nomeCoordenador;?></div>
              					<div class="profile-usertitle-job">Coordenador</div>
              				</div>

                      <!-- Botoes -->
              				<div class="profile-userbuttons">
                        <a href="areaCoordenador.php" title="Página Inicial"><button type="button" class="btn btn-dark btn-sm"><i class="fab fa-fort-awesome"></i></button></a>

              					<button type="button" onclick="window.location.href='logout.php'" class="btn btn-danger btn-sm">Sair</button>
              				</div>

                      <!-- Menu -->
              				<div class="profile-usermenu">
                        <nav class="col-md-18 sidebar">
                          <div class="sidebar-sticky">
                            <ul class="nav flex-column"><!-- Lista -->

                                <!-- Menu Atividades -->
                                <li class="nav-item">
                                    <a class="nav-link" href="#atividadesSubmenu" data-toggle="collapse" aria-expanded="false"><i class="fas fa-file-alt"></i> Atividades</a>
                                    <ul class="collapse list-unstyled submenu" id="atividadesSubmenu" >
                                        <li><a href="?pagina=registroAtividadesCoordenador">Ver atividades</a></li>
                                    </ul>
                                </li>

                                <!-- Menu Aluno-->
                                <li class="nav-item">
                                   <a class="nav-link" href="#horasSubmenu" data-toggle="collapse" aria-expanded="false"><i class="fas fa-child"></i> Aluno</a>
                                   <ul class="collapse list-unstyled submenu" id="horasSubmenu" >
                                       <li><a href="?pagina=buscaAluno">Busca Aluno</a></li>
                                   </ul>
                                </li>

                                <!-- Menu Professor  -->
                                <li class="nav-item">
                                    <a class="nav-link" href="#situacaoSubmenu" data-toggle="collapse" aria-expanded="false"><i class="fas fa-hand-peace"></i> Professor</a>
                                    <ul class="collapse list-unstyled submenu" id="situacaoSubmenu" >
                                        <li><a href="?pagina=cadastroProfessor">Cadastra Professor</a></li>
                                    </ul>
                                </li>

                                <!-- Menu PPC -->
                                <li class="nav-item">
                                    <a class="nav-link" href="#ppcSubmenu" data-toggle="collapse" aria-expanded="false"><i class="fas fa-clock"></i> PPC</a>
                                    <ul class="collapse list-unstyled submenu" id="ppcSubmenu" >
                                        <li><a href="?pagina=cadastrarPPC">Cadastrar PPC</a></li>
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
                    //Pega o endereço da pagina via url
                    if(isset($_GET['pagina'])){
                      $pagina = $_GET['pagina'];
                      if($pagina == ""){
                        include("mainCoordenador.php");
                      } else {
                        include($pagina.".php");
                      }
                    } else {
                      include("mainCoordenador.php");
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
