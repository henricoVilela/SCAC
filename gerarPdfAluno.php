<div class="row">
   <!-- Coluna Mural -->
  <div class="col-md" >
    <h3>Gerar PDF Atividades</h3>

    <form action="pdfAluno.php" target="_blank" method="get">
      <div class="form-group">
        <label>Selecione o Ano</label>
        <select name="ano" class="form-control">
          <option value="2018">2018</option>
          <option value="2017">2017</option>
          <option value="2016">2016</option>
          <option value="2015" >2015</option>
          <option value="2014">2014</option>
        </select>
      </div>
      <input type="hidden" name="id" value="<?php echo $idAluno;?>">
      <button name="gerar" value="gerar" type="submit" class="btn btn-info"><i class="fas fa-file-pdf"></i> Gerar PFD</button>
    </form>

</div><!-- END DIV ROW -->
