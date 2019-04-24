<?php
	$conn = 'mysql:host=localhost;port=3306;dbname=scac';
	//PDO - PHP Data Objects
	try{
		$db = new PDO($conn, 'root', 'admin', array(PDO::ATTR_PERSISTENT => true)); //cria um objeto pdo, dados para o construtor
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 	}catch(PDOException $e){
 		if($e->getCode() == 1049){
 			echo "Erro ao Conectar Banco de Dados";
 		}else{
 		   echo $e->getMessage();
 		}
 	}
?>
