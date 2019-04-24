<?php

	include_once("functions/conn.php"); //inclui a conexao
	include_once("mpdf60/mpdf.php");
	header("Content-type: text/html; charset=utf-8");
	if(!empty($_GET['gerar']) AND !empty($_GET['id']) AND !empty($_GET['ano'])){
		$idAluno = $_GET['id'];
		$ano = $_GET['ano'];

		//FAZ A PESQUISA DAS ATIVIDADES E DO ALUNO NO BANCO DE DADOS
		$sqlRead = "SELECT a.curso, a.nome, t.ano, t.titulo, t.tipo, t.carga_horaria FROM aluno a, atividades_comp t WHERE a.id_aluno = :idAluno and t.ano = :ano and t.id_aluno = :idAluno and t.status = :status";

		try{
			$read = $db->prepare($sqlRead);
			$read->bindValue(':idAluno', $idAluno, PDO::PARAM_STR);
			$read->bindValue(':ano', $ano, PDO::PARAM_STR);
			$read->bindValue(':status', 1, PDO::PARAM_STR);
			$read->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

    //lista das atividades
    $td = "";
    $nome = "";
		$curso = "";
		$ano = "";
    $controle = 0;
    while($rs = $read->fetch(PDO::FETCH_OBJ)){
       $td =  $td."<tr>"."<td>".$rs->titulo."</td>"."<br>";
       $td =  $td."<td>".$rs->tipo."</td>"."<br>";
       $td =  $td."<td>".$rs->carga_horaria."</td>"."<tr>";
       if($controle == 0){
	       $nome = $rs->nome;
	       $curso = $rs->curso;
	       $ano = $rs->ano;
	       $controle = $controle + 1;
       }
 		}

		//Consulta o PP
		$sqlReadppc = "SELECT * FROM ppc ORDER BY tipo ASC";

		try{
			$readppc = $db->prepare($sqlReadppc);
			$readppc->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		$tdppc = "";
		while($dados = $readppc->fetch(PDO::FETCH_OBJ))	{

			//Calcula as horas maxima
			$sqlReadHoras = "SELECT SUM(carga_horaria) as total FROM atividades_comp WHERE id_aluno = :idAluno and tipo = :tipo and status = 1";

			try{
				$readHoras = $db->prepare($sqlReadHoras);
				$readHoras->bindValue(':idAluno', $idAluno);
				$readHoras->bindValue(':tipo', $dados->tipo);
				$readHoras->execute();
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
	
			while ($rsHoras = $readHoras->fetch(PDO::FETCH_OBJ)){
				$horasMax = $rsHoras->total;


			//Verifica as horas totais
			if($horasMax > $dados->hmax){ $horasMax = $dados->hmax; } else { $horasMax = $rsHoras->total; }
       $tdppc =  $tdppc."<tr>"."<td>".$dados->tipo."</td>"."<br>";
       $tdppc =  $tdppc."<td>".$dados->hmin."</td>"."<br>";
       $tdppc =  $tdppc."<td>".$horasMax."</td>"."<tr>";
		 }
 		}

		//Gera que irá aparecer no pdf
		$html = "
		<!DOCTYPE html>
		<html>
		  <head>
		    <meta charset=\"utf-8\">
				</head>
				<body>


		 <div class='div1'>
		 	<h1>Relatorio de Atividades</h1>
		 	<div> Aluno: ".$nome."</div>
		 	<div> Curso: ".$curso." </div>
		 	<div> Ano: ".$ano."</div>
		 	<br>
		 	<div class='texte-td'>
		 		<h2 align='center'>Atividades</h2>
			 	<table border='1' width='100%' align='center' style='text-align:center;'>
					<tr>
						<th> Titulo </th>
						<th> Tipo </th>
						<th> Carga Horaria </th>
					</tr>
						".$td."
			 	</table>
			 </div>
			 <br>
			 <br>
			 <div class='texte-td'>
			 	<h2 align='center'>PPC</h2>
			 	<table border='1' width='100%' align='center'>
					<tr>
						<th> Nome </th>
						<th> Horas Mininimas </th>
						<th> Horas Atingidas</th>
					</tr>
					".$tdppc."

			 	</table>
			 </div>


		 </div>
		 </body>
	 </html>";
		//Cria o pdf
		$mpdf=new mPDF();
		$mpdf->SetDisplayMode('fullpage');
		$css = file_get_contents("css/estilo.css");
		$mpdf->WriteHTML($css,1);
		$mpdf->WriteHTML($html);
		$mpdf->Output();

		exit;
	}

?>
