
                  <div class="row">
                     <!-- Coluna Mural -->
                    <div class="col-md-8 mural" >
                      <h3>Registro de Atividades</h3>
                      <script type="text/javascript">
                        $(document).ready(function(){
                          comeca();
                        })
                        var timerI = null;
                        var timerR = false;

                        function para(){
                            if(timerR)
                                clearTimeout(timerI)
                            timerR = false;
                        }
                        function comeca(){
                            para();
                            lista();
                        }
                        function lista(){
                          $.ajax({
                            url:"atualizaListaAjax.php",
                              success: function (textStatus){
                              $('#lista').html(textStatus); //mostrando resultado
                            }
                          })
                          timerI = setTimeout("lista()", 60000);//tempo de espera
                                    timerR = true;

                        }
                      </script>
                      <div id="lista">
                        <ul class="list-group">
                          <?php
                            include_once("functions/conn.php");
                            //Faz a pesquisa das atividades no banco de dados
                            $sqlRead = "SELECT * FROM atividades_comp WHERE id_aluno = :idAluno ORDER BY data_envio ASC LIMIT 3";

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
                          <?php
                            }
                          ?>
                        </ul>
                        <a href="?pagina=registroAtividades"><div class="text-right"><button type="button" class="btn btn-primary btn-sm">Visualizar Atividades</button></a></div>
                      </div>
                    </div>

                    <!-- Coluna Calendario -->
                    <div class="col-md-4" >
                      <!-- define the calendar element -->
                      <a href="?pagina=submeterAtividade"><button type="button" formaction="" class="btn btn-success submeter-atividade"><i class="fas fa-plus"></i> Submeter Atividade</button></a>

                      <div id="my-calendar"></div>
                    </div>
                  </div><!-- END DIV ROW -->
