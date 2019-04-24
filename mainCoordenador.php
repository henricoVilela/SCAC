
                  <div class="row">
                     <!-- Coluna Mural -->
                    <div class="col-md-8 mural" >
                      <h3>Atividades para aprovação</h3>
                      <ul class="list-group">
                        <?php

                            include_once("functions/conn.php");
                          //FAZ A PESQUISA CURSO NO BANCO DE DADOS
                          $sqlRead = "SELECT * FROM atividades_comp WHERE status = 0";

                          try{
                            $read = $db->prepare($sqlRead);
                
                            $read->execute();
                            $countResult = $read->rowCount();
                          } catch (PDOException $e) {
                            echo $e->getMessage();
                          }

                        ?>
                        <li class="list-group-item list-group-item-warning" color="green"><i class="fas fa-exclamation-triangle"></i> <?php echo $countResult;?> atividades para aprovação</li>
                      </ul>
                      <a href="?pagina=registroAtividadesCoordenador"><div class="text-right"><button type="button" class="btn btn-primary btn-sm">Visualizar</button></a></div>
                    </div>

                    <!-- Coluna Calendario -->
                    <div class="col-md-4" >
                      <div id="my-calendar"></div>
                    </div>
                  </div><!-- END DIV ROW -->
