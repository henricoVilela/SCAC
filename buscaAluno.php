
                  <div class="row">
                    <script src="js/scriptBusca.js"></script>
                    <div class="col-md mural" >
                      <h3>Busca Aluno</h3>
                      <div id="custom-search-input">
                        <div class="input-group col-md-12 search-rac">
                          <form id="buscaA" method="post">
                            <button id="p" name="buscaAluno" class="btn btn-info btn-lg" type="submit" value="buscar" onclick="buscar(document.getElementById('t').value)">
                              <i class="fas fa-search"></i>
                            </button>
                            <input id="t" name="buscaAlunoNome" type="text"  autocomplete="off" class="form-control input-lg" onkeyup="showResult(this.value)"/>
                          </form>
                        </div>
                      </div>
                      <div id="livesearch" class="buscaAluno"></div>
                      <?php
                        //Faz a conexão com o banco de dados
                        include_once("functions/conn.php");
                        //Exibe os alunos
                        if(isset($_POST['buscaAluno'])){
                          //Caso tenha um aluno especifico
                          $busca = explode("-",$_POST['buscaAlunoNome']);
                          $ra = $busca[1];

                          $sqlRead = "SELECT * FROM aluno WHERE RA = :ra";
                        } else {
                          //Exibe todos os alunos
                          $sqlRead = "SELECT * FROM aluno ORDER BY nome ASC";
                        }
                          try{
                            $read = $db->prepare($sqlRead);
                            if(isset($_POST['buscaAluno'])){
                              $read->bindValue(':ra', $ra, PDO::PARAM_STR);
                            }
                            $read->execute();
                            $countResult = $read->rowCount();
                          } catch (PDOException $e) {
                            echo $e->getMessage();
                          }

                          //Verifica se há alunos cadastrados
                          if($countResult == 0){
                            echo "Nenhum aluno cadastrado!";
                          }
                      ?>
                      <ul class="list-group">
                        <?php
                          //Lê todos os registros do banco de dados
                          while ($rs = $read->fetch(PDO::FETCH_OBJ)){
                        ?>
                          <li class="list-group-item" color="black"><i class="fab fa-jenkins"></i> <?php echo $rs->nome; ?> <a href="?pagina=verAtividadesAluno&aluno=<?php echo $rs->id_aluno?>&nome=<?php echo $rs->nome;?>">[Ver Atividades]</a></li>
                        <?php
                          }
                        ?>
                        </ul>
                    </div>
                  </div><!-- END DIV ROW -->
