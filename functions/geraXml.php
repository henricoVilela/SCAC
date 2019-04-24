

<?php
//CONECTA AO BANCO DE DADOS
$conn = @mysqli_connect("localhost", "root","admin") or die("ERRO NA CONEXÃO");

//SELECIONA A BASE DE DADOS A SER UTILIZADA
$db = @mysqli_select_db($conn, "scac") or die("ERRO NA SELEÇÃO DA BASE DE DADOS");

//SQL
$sql = mysqli_query($conn,"SELECT * FROM aluno") or die("Erro");
/*while($dados=mysqli_fetch_assoc($sql))
    {
        echo $dados['nome'].'<br>';
    }*/

//TOTAL DE LINHAS AFETADAS PELA CONSULTA
$row = mysqli_num_rows($sql);


//VERIFICA SE A PESQUISA RETORNOU ALGUMA LINHA
if($row > 0) {

	//ARQUIVO
	$arquivo = "alunos.xml";

	//ABRE O ARQUIVO(SE NÃO EXISTIR, CRIA)
	$ponteiro = fopen($arquivo, "w");

	//ESCREVE NO ARQUIVO XML
	fwrite($ponteiro, "<?xml version='1.0'?> ");
	fwrite($ponteiro, "<alunos>");

	while($dados=mysqli_fetch_assoc($sql)){

		 //PEGA OS DADOS DO SQL
		 //$id = $dados['id_aluno'].'<br>';
		 $nome = $dados['nome'];
		 $RA= $dados['RA'];

		 //MONTA AS TAGS DO XML
		 $conteudo = "<link>";
		 //$conteudo .= "<id>$id</id>";
		 $conteudo .= "<nome>$nome</nome>";
		 $conteudo .= "<ra>$RA</ra>";
		 $conteudo .= "</link>";

		 //ESCREVE NO ARQUIVO
		 fwrite($ponteiro, $conteudo);
	}//FECHA FOR

	//FECHA A TAG AGENDA
	fwrite($ponteiro, "</alunos>");

	//FECHA O ARQUIVO
	fclose($ponteiro);

	//MENSAGEM
	/*echo "<h2>iMasters – Coluna PHP – Artigo 83</h2><br>";
	echo "O arquivo <b>".$arquivo."</b>
	foi gerado com SUCESSO !";*/
}//FECHA IF($row)
?>
