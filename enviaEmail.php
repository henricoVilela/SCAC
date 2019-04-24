<?php

  if(isset($_POST['enviarEmail'])){



    $email = $_POST['email'];
    $data = date("d/m/Y H:i:s");
    $titulo = $_POST['email_titulo'];
    $nome = $_POST['email_nome'];
    $idAtividadeEmail = $_POST['email_idAtividade'];
    $tipo = $_POST['email_tipo'];

    /*verifica se a pessoa digitou o email corretamente*/
    if (empty($email)){

      echo "<div class=\"no\">Por favor, informe seu E-mail!</div>";

    }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){

      echo "<div class=\"no\">Por Favor, informe um E-mail Válido!</div>";

    }else{

     $msn ="
     <html>
       <body>
           <strong>Titulo: </strong>$titulo<br>
           <strong>Nome Aluno: </strong>$nome<br>
           <strong>Link para avaliação: </strong><a href=\"http://localhost/scac/avaliaAtividade.php?atividade=$idAtividadeEmail\">Clique aqui</a><br>
           Enviado por SCAC - Sistema de Controle de Atividades complementares em $data
      </body>
     </html>";



     $assunto = "Tarefa para Avaliação - $titulo - $tipo\n";
     $headers = "From: coordenador@scac.net\n";
     $headers .= "Content-Type: text/html; charset=\"utf-8\"\n\n";

     mail($email, $assunto, $msn, $headers);

     // <-- FIM CORPO DO EMAIL

     $sqlCre = 'UPDATE atividades_comp SET status = :status, professor = :professor WHERE id_atividade = :idNegar';
     try{
       $create = $db->prepare($sqlCre);
       $create->bindValue(':idNegar', $idAtividadeEmail, PDO::PARAM_INT);
       $create->bindValue(':professor', $email, PDO::PARAM_STR);
       $create->bindValue(':status', 4, PDO::PARAM_INT);
       if($create->execute()){
         echo "<div class=\"sucesso\">Atividade enviada para o e-mail do professor!$email</div>";

       }
     } catch (PDOException $e){
       echo "<div class=\"erro\">Erro ao enviar o email!</div>";
     }


    }
  }


?>
