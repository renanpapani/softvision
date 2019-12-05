<?php
	$host = "localhost";
	$user = "root";
	$pwd = "renan123";
	$banco = "bdclientes";
	
	$msgerro ="Conexão OK!";
	$conexao = mysqli_connect($host,$user,$pwd,$banco);
	if(!$conexao) {
		$msgerro = "Problema na conexao com o banco de dados!";
	}
	else {
		
		mysqli_select_db($conexao,$banco);
	}
?>