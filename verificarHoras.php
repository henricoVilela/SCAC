
                  <div class="row tbHorasAluno">
                     <!-- Coluna Mural -->

                      <h3>Horas</h3>

                      <table>
                        <caption>Tabela de Atividades</caption>
                        <tr>
                          <th>Tipo Atividade</th>
                          <th>Horas Min</th>
                          <th>Horas Max</th>
                          <th>Horas Total</th>
                        </tr>


                          <?php
                            include_once("functions/conn.php");
                            //FAZ A PESQUISA NO BANCO DE DADOS
                            $sqlRead = "SELECT * FROM ppc ORDER BY tipo ASC";

                            try{
                              $read = $db->prepare($sqlRead);
                              $read->execute();
                            } catch (PDOException $e) {
                              echo $e->getMessage();
                            }

                            while ($rs = $read->fetch(PDO::FETCH_OBJ)){ ?>
                            <tr>
                              <td><?php echo $rs->tipo;?></td>
                              <td><?php echo $rs->hmin;?></td>
                              <td><?php echo $rs->hmax;?></td>
                              <td>
                                <?php
                                  //FAZ A PESQUISA NO BANCO DE DADOS
                                  $sqlReadHoras = "SELECT SUM(carga_horaria) as total FROM atividades_comp WHERE id_aluno = :idAluno and tipo = :tipo and status = 1";

                                  try{
                                    $readHoras = $db->prepare($sqlReadHoras);
                                    $readHoras->bindValue(':idAluno', $idAluno);
                                    $readHoras->bindValue(':tipo', $rs->tipo);

                                    $readHoras->execute();
                                  } catch (PDOException $e) {
                                    echo $e->getMessage();
                                  }

                                  $rsHoras = $readHoras->fetch(PDO::FETCH_OBJ);

                                  if($rs->hmax > $rsHoras->total){
                                     echo $rsHoras->total;
                                   } else {
                                     echo $rs->hmax;
                                   }


                                 ?>
                              </td>
                              </tr>
                            <?php  }
                            ?>

                      </table>

                    </div>
                  </div><!-- END DIV ROW -->
