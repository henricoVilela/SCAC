                  <div class="row">
                      <div class="col-md cadastrarProfessor" >
                        <h3>Cadastro PPC</h3>
                        <?php
                          /* Chama a conexao */
                          include_once("functions/conn.php");
                          //Se o botão de nome enviar for clicado
                          if(isset($_POST['cadastrar'])){
                              //Insere os dados na tabela
                              $sql = "INSERT INTO ppc (tipo, hmax, hmin) VALUES (:tipo, :hmax, :hmin)";

                              try{

                                $create = $db->prepare($sql);
                                $create->bindValue(':tipo', $_POST['tipo'], PDO::PARAM_STR);
                                $create->bindValue(':hmax', $_POST['hmax'], PDO::PARAM_STR);
                                $create->bindValue(':hmin', $_POST['hmin'], PDO::PARAM_STR);

                                //Executa a query
                                if($create->execute()){
                                  echo "<div class=\"sucesso\">PPC cadastrado com Sucesso</div>";
                                } else {
                                  echo "<div class=\"Erro\">Erro</div>";
                                }

                              } catch (PDOException $e){
                                  echo "Erro: ".$e->getCode()." - Falha no cadastro do PPC!";
                              }
                          } ?>
                        <form method="post">
                          <div class="form-group">
                            <label for="exampleFormControlFile1">Tipo da Atividade</label>
                            <input name="tipo" type="text" >
                          </div>
                          <div class="form-group">
                            <label for="exampleFormControlFile1">Carga Horária min horas (Ex: 50)</label>
                            <input name="hmax" type="text" class="horas">
                          </div>
                          <div class="form-group">
                            <label for="exampleFormControlFile1">Carga Horária max horas (Ex: 100)</label>
                            <input name="hmin" type="text" class="horas">
                          </div>
                          <button name="cadastrar" value="cadastrar" type="submit" class="btn btn-primary">Cadastrar</button>
                        </form>
                      </div>
                  </div><!-- END DIV ROW -->
