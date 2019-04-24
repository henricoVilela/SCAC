                  <div class="row">
                    <div class="col-md mural" >
                      <h3>Registro de Atividades</h3>
                        <a href="?pagina=submeterAtividade" title="Clique para submeter uma atividade!"><button type="button" class="btn btn-success submeter-atividade"><i class="fas fa-plus"></i> Submeter Atividade</button></a>
                        <!-- Gerar PDF-->
                        <div class="gerarPdfAluno">
                          <a href="?pagina=gerarPdfAluno" title="Clique para gerar um pdf de suas atividads!"><button type="button" class="btn btn-info"><i class="fas fa-file-pdf"></i> Gerar PFD</button></a>
                        </div>
                        <legend class="legend-atividades"><i class="fas fa-eye"></i>  <i class="fas fa-exclamation-circle"></i> - Observação Professor</legend>
                      <ul class="list-group">
                        <?php
                          include_once("functions/conn.php");
                          //Faz a pesquisa das atividades no banco de dados
                          $sqlRead = "SELECT * FROM atividades_comp WHERE id_aluno = :idAluno ORDER BY data_envio ASC";

                          try{
                            $read = $db->prepare($sqlRead);
                            $read->bindValue(':idAluno', $idAluno, PDO::PARAM_STR);
                            $read->execute();

                          } catch (PDOException $e) {
                            echo $e->getMessage();
                          }

                          //Exibe os dados
                          while ($rs = $read->fetch(PDO::FETCH_OBJ)){

                            $status = "";
                            $statusCor = "";
                            $statusIcon = "";
                            $statusCorSucesso = "";
                            if($rs->status == 0){
                              $statusIcon = "<i class=\"fas fa-hourglass-half\"></i>";
                              $status = "Atividade em processamento!";
                            }elseif($rs->status == 1){
                              $statusIcon = "<i class=\"fas fa-check\"></i>";
                              $statusCor = "-success";
                              $status = "Atividade aprovada!";
                              $statusCorSucesso = "green";
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

                          <a data-toggle="modal" data-target="#modal<?php echo $rs->id_atividade;?>" title="<?php echo $status;?>" class="list-group-item list-group-item-action list-group-item<?php echo $statusCor;?>" <?php echo $statusCorSucesso;?>><?php echo $statusIcon;?> <?php echo $rs->titulo;?> - <?php echo  date("d/m/Y", strtotime($rs->data_envio))." - ". $status;?></a>
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
                                    <strong>Status: </strong><?php echo $statusIcon;?> <?php echo $status;?><br>
                                    <strong>Titulo: </strong><?php echo $rs->titulo;?> <br>
                                    <strong>Tipo: </strong> <?php echo $rs->tipo;?><br>
                                    <strong>Ano: </strong> <?php echo $rs->ano;?><br>
                                    <strong>Carga Horaria: </strong><?php echo $rs->carga_horaria;?> <br>
                                    <strong>Carga Aprovada: </strong><?php echo $rs->carga_computada;?> <br>
                                    <strong>Data de submissão: </strong> <?php echo  date("d/m/Y H:i:s", strtotime($rs->data_envio));?><br>
                                    <?php if($rs->impresso == 0){ ?>
                                      <strong>Visualizar atividade: </strong><a href="atvd/<?php echo $rs->nome_arq;?>" target="_blank" title="Baixar arquivo"> <i class="fas fa-file-pdf"></i></a><br><br>
                                    <?php }else{
                                      echo "Atividade foi entregue impressa ao coordenador!<br>";
                                    }?>
                                    <strong>Professor: </strong> <?php echo $rs->professor;?><br>
                                    <strong>Comentário: </strong> <?php if($rs->avaliacao_salva == 1){ echo "Em avaliação"; } else { echo $rs->comentario; }?>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <?php if($rs->status == 1 OR $rs->status == 2 OR $rs->status == 3 ){?>
                                    <a href="pdfProfessor.php?idAtividade=<?php echo $rs->id_atividade;?>" target="_blank"><button type="button" class="btn btn-info">Imprimir</button></a>
                                  <?php }?>
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                </div>
                              </div>
                            </div>
                          </div> <!-- End modal -->
                        <?php
                          }
                        ?>
                      </ul>
                    </div>
                  </div><!-- END DIV ROW -->
