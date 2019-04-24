
                  <div class="row">
                     <!-- Coluna Mural -->
                    <div class="col-md mural" >
                      <h3>Atividades para aprovação</h3>

                        <legend class="legend-atividades"><i class="fas fa-eye"></i>  <i class="fas fa-exclamation-circle"></i> - Observação Professor</legend>
                        <?php
                          include_once("functions/conn.php");
                          if(isset($_POST['negaAtividade'])){
                            //algumas validações
                              $sqlCre = 'UPDATE atividades_comp SET status = :statusNegar WHERE id_atividade = :idNegar';
                              try{
                                $create = $db->prepare($sqlCre);
                                $create->bindValue(':idNegar', $_POST['negaAtividade'], PDO::PARAM_INT);
                                $create->bindValue(':statusNegar', 3, PDO::PARAM_INT);
                                if($create->execute()){
                                  echo "<div class=\"sucesso\">Atividade Negada!</div>";

                                }
                              } catch (PDOException $e){
                                echo "<div class=\"erro\">Erro ao negar a atividade!</div>";
                              }
                          }
                        ?>


                      <ul class="list-group">
                        <?php

                          //FAZ A PESQUISA CURSO NO BANCO DE DADOS
                          $sqlRead = "SELECT a.*, ati.* FROM aluno a, atividades_comp ati WHERE a.id_aluno = ati.id_aluno and ati.status = 0 ORDER BY data_envio, status ASC";

                          try{
                              $read = $db->prepare($sqlRead);
                              $read->execute();

                              $countResult = $read->rowCount();
                          } catch (PDOException $e) {
                              echo $e->getMessage();
                          }

                          while ($rs = $read->fetch(PDO::FETCH_OBJ)){
                            $status = "";
                            $statusCor = "";
                            $statusIcon = "";
                            $statusCorSucesso ="";
                            if($rs->status == 0){
                              $statusIcon = "<i class=\"fas fa-hourglass-half\"></i>";
                              $status = "Atividade em processamento!";
                            }elseif($rs->status == 1){
                              $statusIcon = "<i class=\"fas fa-check\"></i>";
                              $statusCor = "-success";
                              $statusCorSucesso = "color=\"green\"";
                              $status = "Atividade aprovada!";
                            }elseif($rs->status == 2){
                              $statusIcon = "<i class=\"fas fa-ban\"></i></i>";
                              $statusCor = "-danger";
                              $status = "Atividade negada!";
                            }elseif($rs->status == 3){
                              $statusIcon = "<i class=\"fas fa-ban\"></i>";
                              $statusCor = "-danger";
                              $status = "Atividade negada coordenador!";
                            }elseif($rs->status == 4){
                              $statusIcon = "<i class=\"fas fa-hourglass-half\"></i>";
                              $status = "Atividade enviada para professor!";
                            }

                        ?>




                        <?php
                          include_once("enviaEmail.php");
                        ?>

                        <a data-toggle="modal" data-target="#modal<?php echo $rs->id_atividade;?>" title="<?php echo $status;?>" class="list-group-item list-group-item-action list-group-item<?php echo $statusCor;?>" <?php echo $statusCorSucesso;?>><?php echo $statusIcon;?> Atividade <?php echo  date("d/m/Y", strtotime($rs->data_envio))." - ". $status;?></i></a>

                          <!-- Target Modal -->
                          <div class="modal fade" id="modal<?php echo $rs->id_atividade;?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $rs->titulo;?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLongTitle">Atividade <?php echo  date("d/m/Y", strtotime($rs->data_envio))." - ". $rs->titulo;?></h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="dadosAtividade">
                                    <strong>Nome Aluno: </strong><?php echo $rs->nome;?><br>
                                    <strong>Status: </strong><?php echo $statusIcon;?> <?php echo $status;?><br>
                                    <strong>Titulo: </strong><?php echo $rs->titulo;?> <br>
                                    <strong>Tipo: </strong> <?php echo $rs->tipo;?><br>
                                    <strong>Carga Horaria: </strong><?php echo $rs->carga_horaria;?> <br>
                                    <strong>Carga Aprovada: </strong><?php echo $rs->carga_computada;?> <br>
                                    <strong>Data de submissão: </strong> <?php echo  date("d/m/Y H:i:s", strtotime($rs->data_envio));?><br>
                                    <?php if($rs->impresso == 0){ ?>
                                      <strong>Visualizar atividade: </strong><a href="atvd/<?php echo $rs->nome_arq;?>" target="_blank" title="Baixar arquivo"> <i class="fas fa-file-pdf"></i></a><br><br>
                                    <?php }else{
                                      echo "Atividade foi entregue impressa ao coordenador!<br>";
                                    }?>

                                    <strong>Professor: </strong> <?php echo $rs->professor;?><br>
                                    <strong>Comentário: </strong><br> <?php if($rs->avaliacao_salva == 1){ echo "Em avaliação"; } else { echo $rs->comentario; } ?><br><br>

                                    <!-- Lista os professores para envio de e-mail -->

                                    <form id="enviaEmail" method="post">
                                      <div class="form-group" required>
                                        <label>Selecione o professor:</label>
                                        <select class="form-control" name="email" required>
                                          <option value="">Selecione</option>
                                          <?php

                                            //FAZ A PESQUISA professores NO BANCO DE DADOS
                                            $sqlReadProf = "SELECT * FROM cadastro_prof ORDER BY nome DESC";

                                            try{
                                              $readProf = $db->prepare($sqlReadProf);
                                              $readProf->execute();
                                            } catch (PDOException $eProf) {
                                              echo $eProf->getMessage();
                                            }

                                            while ($rsReadProf = $readProf->fetch(PDO::FETCH_OBJ)){
                                              echo "<option value=\"$rsReadProf->email\">$rsReadProf->nome</option>";
                                            }
                                          ?>
                                        </select>
                                      </div>
                                    </form>

                                  </div> <!-- End dados atividades -->
                                </div><!-- End modal dados -->
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                  <form id="negarAtividade" method="post">
                                    <button form="negarAtividade" type="submit" name="negaAtividade" value="<?php echo $rs->id_atividade;?>" class="btn btn-danger">Negar Atividade</button>
                                  </form>
                                  <button form="enviaEmail" type="submit" name="enviarEmail" value="<?php echo $rs->id_atividade;?>" class="btn btn-primary"  data-toggle="modal" data-target="#modal<?php echo $rs->id_atividade;?>">Enviar</button>
                                </div>
                              </div>
                            </div>
                          </div> <!-- End modal -->
                          <?php
                          }
                        ?>
                      </ul>
                    </div><!-- End Coluna -->
                  </div><!-- END DIV ROW -->
