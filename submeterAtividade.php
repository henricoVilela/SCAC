                  <div class="row">
                     <!-- Coluna Mural -->
                    <div class="col-md mural cadastrarProfessor" >
                      <h3>Submeter Atividade</h3>
                      <?php
                        /* Chama a conexao */
                        include_once("functions/conn.php");

                        //Verifica se há atividades para aprovação
                        $sqlRead = "SELECT * FROM atividades_comp WHERE id_aluno = :idAluno AND status = 0 ORDER BY data_envio, status DESC";

                        try{
                          $read = $db->prepare($sqlRead);
                          $read->bindValue(':idAluno', $idAluno, PDO::PARAM_STR);
                          $read->execute();
                          $countResult = $read->rowCount();
                        } catch (PDOException $e) {
                          echo $e->getMessage();
                        }

                        if($countResult != 0){
                          echo "<strong>Você submeteu uma atividade recentemente e a mesma não foi avaliada, aguarde a avaliação para envio da nova atividade!</strong>";
                        }


                        //Se o botão de nome enviar for clicado
                        if(isset($_POST['cadastrar'])){

                            //Insere os dados do aluno na tabela aluno
                            $sql = "INSERT INTO atividades_comp (id_aluno, titulo, tipo, carga_horaria, carga_computada, data_envio, status, nome_arq, ano, comentario, impresso) VALUES (:aluno_ra, :titulo, :tipo, :carga_horaria, :carga_computada, :data_envio, :status, :nome_arq, :ano, :comentario, :impresso)";
                            try{

                              $create = $db->prepare($sql);
                              $create->bindValue(':aluno_ra', $idAluno, PDO::PARAM_INT);
                              $create->bindValue(':titulo', $_POST['titulo'], PDO::PARAM_STR);
                              $create->bindValue(':tipo', $_POST['tipo'], PDO::PARAM_STR);
                              $create->bindValue(':carga_horaria', $_POST['carga_horaria'], PDO::PARAM_STR);
                              $create->bindValue(':carga_computada', 0, PDO::PARAM_STR);
                              $create->bindValue(':data_envio', date('Y-m-d H:i:s'), PDO::PARAM_STR);
                              $create->bindValue(':status', 0, PDO::PARAM_STR); //Em avaliação
                              $create->bindValue(':nome_arq',  basename(date('Y-m-d H:i:s').'-'.$file['name']), PDO::PARAM_STR);
                              $create->bindValue(':ano', $_POST['ano'], PDO::PARAM_STR);
                              $create->bindValue(':comentario', "Em avaliação", PDO::PARAM_STR);
                              $create->bindValue(':impresso', $_POST['impresso'], PDO::PARAM_STR);

                              //Executa a query
                              if($create->execute()){
                                echo "<div class=\"sucesso\">Atividade enviada com sucesso!</div>";
                              } else {
                                echo "<div class=\"Erro\">Falha no envio da atividade!</div>";
                              }

                            } catch (PDOException $e){
                                echo "<div class=\"Erro\">Falha no envio da atividade!</div>";
                            }

                            if($_POST['impresso'] == 0){
                                //Caminho da minha pasta local onde serão salvo os arquivos
                                $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/scac/atvd';

                                //Verifica se o usuario selecionou um arquivo
                                if (isset($_FILES['file'])) {

                                    //Cria uma referencia para o arquivo
                                    $file = $_FILES['file'];

                                    //Verifica se houve erro na seleção do arquivo
                                    if ($file['error'] !== UPLOAD_ERR_OK) {
                                        echo '<div class=\"Erro\">Falha no envio do arquivo!', $file['error'], PHP_EOL,"</div>";
                                        exit;
                                    }

                                    //Verifica a extensão do arquivo
                                    $allowed = array('pdf');
                                    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                                    if (!in_array($extension, $allowed)) {
                                        echo '<div class=\"Erro\">Extensão do arquivo inválida!', PHP_EOL, '</div>';
                                        exit;
                                    }

                                    //Seta o endereço no servidor e concatena com o nome do arquivo
                                    $target = $upload_dir . '/' . basename(date('Y-m-d H:i:s').'-'.$file['name']);

                                    //Move o arquivo da pasta temporario do servidor para a pasta atvd
                                    if (!move_uploaded_file($file['tmp_name'], $target)) {
                                        echo '<div class=\"Erro\">Falha na cópia do aquivo!', PHP_EOL, '</div>';
                                        print_r(error_get_last());
                                        exit;
                                    }

                                    echo '<div class=\"sucesso\">Arquivo enviado com sucesso!</div>', PHP_EOL;
                                    //echo $target, PHP_EOL;
                                }
                              }
                      }
                      ?>

                      <?php if($countResult == 0){ ?>
                      <form method="post" enctype="multipart/form-data">
                        <div class="form-group ">
                          <label>Titulo</label>
                          <input name="titulo" type="text" required="required">
                        </div>
                        <div class="form-group">

                          <?php

                            //FAZ A PESQUISA NO BANCO DE DADOS
                            $sqlRead = "SELECT tipo FROM ppc ORDER BY tipo ASC";

                            try{
                              $read = $db->prepare($sqlRead);
                              $read->execute();
                            } catch (PDOException $e) {
                              echo $e->getMessage();
                            }

                          ?>
                          <label>Tipo</label>
                          <select name="tipo" class="form-control" required="required">
                            <option value="" selected>Selecione o Tipo</option>
                            <?php
                              while ($rs = $read->fetch(PDO::FETCH_OBJ)){
                                echo "<option value=\"".$rs->tipo."\">".$rs->tipo."</option>";
                              }
                            ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>Carga Horaria</label>
                          <input name="carga_horaria" type="text" required="required" class="customize">
                        </div>

                        <div class="form-group">
                          <label>Ano</label>
                          <input name="ano" type="text" required="required" class="customize">
                        </div>
                        <div class="form-group">
                          <label>Forma de entrega</label>
                          <select name="impresso" class="form-control customize" required="required" >
                            <option value="" selected>Selecione</option>
                            <option value="0">Online</option>
                            <option value="1">Impresso</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>Arquivo para envio</label>
                          <input type="file" name="file" class="form-control-file customize" id="exampleFormControlFile1">
                        </div>
                        <button name="cadastrar" value="cadastrar" type="submit" class="btn btn-primary">Enviar</button>
                      </form>
                    <?php } ?>
                    </div>
                    <!-- Coluna Calendario -->
                  </div><!-- END DIV ROW -->
