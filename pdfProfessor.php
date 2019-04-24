<?php
	include("mpdf60/mpdf.php");
	include_once("functions/conn.php");

	$sqlRead = "SELECT a.curso, a.nome, t.status, t.ano, t.titulo, t.tipo, t.carga_horaria, t.data_envio, t.comentario, t.professor FROM aluno a, atividades_comp t WHERE t.id_aluno = a.id_aluno AND t.id_atividade = :idAtividade";

	try{
		$read = $db->prepare($sqlRead);
		$read->bindValue(':idAtividade', $_GET['idAtividade'], PDO::PARAM_STR);
		$read->execute();
	} catch (PDOException $e) {
		echo $e->getMessage();
	}

	while($dados = $read->fetch(PDO::FETCH_OBJ)){

	    $nome = $dados->nome;
			$curso = $dados->curso;
			$ano = $dados->ano;
			$atividade = $dados->titulo;
	    $tipo = $dados->tipo;
	    $data = $dados->data_envio;
	    $horas = $dados->carga_horaria;
	    $comentario = $dados->comentario;
	    $professor = $dados->professor;
	    $status = $dados->status;
	}
	    if($status == 1 ) {
	    	$status = "<strong><font color='green'>Aprovado</font></strong>";
	    }elseif($status == 2 ) {
	    	$status = "<strong><font color='red'>Negada</font></strong>";;
			}elseif($status == 3 ) {
			$status = "<strong><font color='red'>Negada pelo coordenador</font></strong>";;
			}
$html = "
<!DOCTYPE html>
<html>
	<head>
		<meta charset=\"utf-8\">
		</head>
		<body>

	 <div class='div1'>
	 	<div> <spam >Aluno:</spam> ".$nome."</div>
	 	<div> <spam >Curso:</spam> ".$curso."</div>
	 	<div> <spam >Atividade:</spam> ".$atividade."</div>
	 	<div> <spam >Ano de conclusao da atividade:</spam> ".$ano." </div>
	 	<div> <spam >Tipo:</spam> ".$tipo."</div>
	 	<div> <spam >Carga horaria:</spam> ".$horas."</div>
	 	<div> <spam >Data do envio:</spam> ".$data."</div>
	 	<br><br>

	 	<div>Esta atividade foi avaliada em: ".$status."</div><br>
	 	<h3>Comentario do Professor</h3>
	 	<div id='comentario'>".$comentario."</div>
	 	<div>Atividade avaliada pelo professor ".$professor." .</div>


	 </div>
	 </body>
 </html>";

	$mpdf=new mPDF();
	$mpdf->SetDisplayMode('fullpage');
	$css = file_get_contents("css/estilo.css");
	$mpdf->WriteHTML($css,1);
	$mpdf->WriteHTML($html);
	$mpdf->Output();

	exit;
?>
