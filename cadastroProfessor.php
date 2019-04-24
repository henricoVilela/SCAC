<div class="row">
   <!-- Coluna Mural -->
  <div class="col-md mural cadastrarProfessor" >
    <h3>Cadastrar Professor</h3>
    <?php
      /* Chama a conexao */
      include_once("functions/conn.php");
      //Se o botão de nome enviar for clicado
      if(isset($_POST['cadastrar'])){

          $ultimoId = Null;
          //Insere os dados do aluno na tabela aluno
          $sql = "INSERT INTO cadastro_prof (nome, email, curso) VALUES (:nome, :email, :curso)";

          try{

            $create = $db->prepare($sql);

            $create->bindValue(':nome', $_POST['nome'], PDO::PARAM_STR);
            $create->bindValue(':curso', $_POST['curso'], PDO::PARAM_STR);
            $create->bindValue(':email', $_POST['email'], PDO::PARAM_STR);

            //Executa a query
            if($create->execute()){
              echo "Professor cadastradi com sucesso!";
            } else {
              echo "Falha no cadastro do professor";
            }
            $ultimoId =  $db->lastInsertId();

          } catch (PDOException $e){
              echo "Erro: ".$e->getCode()." - Falha no cadastro do professor!";
          }
      } ?>
    <form method="post">
      <div class="form-group">
        <label>Nome Professor</label>
        <input name="nome" type="text">
      </div>
      <div class="form-group">
        <label>Email</label>
        <input name="email" type="text">
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
        <label for="exampleFormControlFile1">Curso</label>
        <select name="curso" class="form-control" id="exampleFormControlSelect1" required>
          <option>Selecione o Curso</option>
          <?php
            while ($rs = $read->fetch(PDO::FETCH_OBJ)){
              echo "<option value=\"".$rs->nome."\">".$rs->nome."</option>";
            }
          ?>
        </select>
      <button name="cadastrar" value="cadastar" type="submit" class="btn btn-primary">Enviar</button>
    </form>
  </div>
  <!-- Coluna Calendario -->
</div><!-- END DIV ROW -->
