<?php
	//Conexao com o banco de dados
	require_once("./conexao/dbconexao.php");
	
	$codigo = "";
	$nome = "";
	$clisobrenome = "";
	$data_nas = "";
	$sexo = "";
	$cpf = "";
	$rg = "";
	if($_POST) {
		$acao = "";
		if(isset($_REQUEST["acao"])) {
			$acao = $_REQUEST["acao"];
		}
		
		//Recuperar todos os dados dos campos do formulário
		$nome = $_REQUEST["nome"];
		$clisobrenome = $_REQUEST["clisobrenome"];
		$data_nas = $_REQUEST["data_nas"];
		$sexo = $_REQUEST["sexo"];
		$cpf = $_REQUEST["cpf"];
		$rg = $_REQUEST["rg"];
		
		if($acao == "incluir") {
			$sqlstring = "insert into tblclientes (cliid,clinome,clisobrenome,clidata,clisexo,clicpf,clirg) values (NULL,";
			$sqlstring .= "'".$nome."',";
			$sqlstring .= "'".$clisobrenome."',";
			$sqlstring .= "'".$data_nas."',";
			$sqlstring .= "'".$sexo."',";
			$sqlstring .= "'".$cpf."',";
			$sqlstring .= "'".$rg."')";
			
			//Executar a instrução SQL no banco de dados
			$result = mysqli_query($conexao, $sqlstring);
			if(mysqli_affected_rows($conexao) == 0) {
				$msgerro = "Problema na inclusão do registro no banco de dados!";
			}
			else {
				$msgerro = "Registro cadastrado com sucesso!";
			}
			//Carregar o site novamente
			echo "<script>window.location.href='./index.php';</script>";
		}
		else if($acao == "consultar") {
			$codigo = $_REQUEST["codigo"];
			$sqlstring = "select * from tblclientes where cliid = ".$codigo;
			$result = mysqli_query($conexao, $sqlstring);
			if(mysqli_affected_rows($conexao) > 0) {
				//Recuperar os dados do registro da tabela e armazenar nos campos do formulário
				$registro = mysqli_fetch_array($result);
				
				//Carregar os campos do formulário
				$nome = $registro["clinome"];
				$clisobrenome = $registro["clisobrenome"];
				$data_nas = $registro["clidata"];
				$sexo = $registro["clisexo"];
				$cpf = $registro["clicpf"];
				$rg = $registro["clirg"];
			}
			else {
				$msgerro = "Código não existe!";
			}
		}
		else if($acao == "alterar") {
			$codigo = $_REQUEST["codigo"];
			$sqlstring = "select * from tblclientes where cliid = ".$codigo;
			$result = mysqli_query($conexao, $sqlstring);
			if(mysqli_affected_rows($conexao) > 0) {
				//Criar a instrução SQL para  alterar os dados da pessoa
				$sqlstring = "update tblclientes set clinome ='".$nome."',clisobrenome='".$clisobrenome."',clidata='".$data_nas."',clisexo='".$sexo."',clisexo='".$sexo."',clicpf='".$cpf."' where cliid=".$codigo;
				//Executar a instrução SQL dentro do banco de dados
				$result = mysqli_query($conexao,$sqlstring);
				//Verificar se a instrução SQL foi executada com sucesso
				if(mysqli_affected_rows($conexao) > 0) {
					$msgerro = "Resgistro alterado com sucesso!";
				}
				else {
					$msgerro = "Problema na alteração dos dados da pessoa!";
				}
			}
			else {
				$msgerro = "Código não existe!";
			}
		}
		else if($acao == "excluir") {
			$codigo = $_REQUEST["codigo"];
			$sqlstring = "select * from tblclientes where cliid = ".$codigo;
			$result = mysqli_query($conexao, $sqlstring);
			if(mysqli_affected_rows($conexao) > 0) {
				//Criar a instrução SQL para  alterar os dados da pessoa
				$sqlstring = "delete from tblclientes where cliid=".$codigo;
				//Executar a instrução SQL dentro do banco de dados
				$result = mysqli_query($conexao,$sqlstring);
				//Verificar se a instrução SQL foi executada com sucesso
				if(mysqli_affected_rows($conexao) > 0) {
					$msgerro = "Resgistro excluído com sucesso!";
				}
				else {
					$msgerro = "Problema na exclusão dos dados da pessoa!";
				}
			}
			else {
				$msgerro = "Código não existe!";
			}
		}
		else if($acao == "limpar") {
			$codigo = "";
			$nome = "";
			$clisobrenome = "";
			$data_nas = "";
			$sexo = "";
			$cpf = "";
			$rg = "";
		}
	}
?>
<html>
	<head>
		<title>Teste Renan</title>
		<link rel="stylesheet" type="text/css" href="./css/bootstrap.css">
		<script language="jscript" type="text/jscript">
			function fnValidarMenu(opcao) {
				var blnsubmeter = true;
				
				if(opcao == "consultar" || opcao == "alterar" || opcao == "excluir") {
					if(document.frmPrincipal.codigo.value == '') {
						blnsubmeter = false;
						alert('Campo Codigo obrigatorio!');
						document.frmPrincipal.codigo.focus();
					}
				}
				
				if(opcao == "incluir" || opcao == "alterar") {
					if(document.frmPrincipal.nome.value == '') {
						blnsubmeter = false;
						alert('Campo Nome obrigatorio!');
						document.frmPrincipal.nome.focus();
					}
					else if(document.frmPrincipal.clisobrenome.value == '') {
						blnsubmeter = false;
						alert('Campo E-Mail obrigatorio!');
						document.frmPrincipal.clisobrenome.focus();
					}
					else if(document.frmPrincipal.data_nas.value == '') {
						blnsubmeter = false;
						alert('Campo Telefone obrigatorio!');
						document.frmPrincipal.data_nas.focus();
					}
					else if(document.frmPrincipal.sexo.value == '') {
						blnsubmeter = false;
						alert('Campo Telefone obrigatorio!');
						document.frmPrincipal.sexo.focus();
					}
					else if(document.frmPrincipal.cpf.value == '') {
						blnsubmeter = false;
						alert('Campo Telefone obrigatorio!');
						document.frmPrincipal.cpf.focus();
					}
				}
				
				if(blnsubmeter) {
					document.frmPrincipal.action = './index.php?acao='+opcao;
					document.frmPrincipal.submit();
				}
				return false;
			}
		</script>
	</head>
	<body>
		<form name="frmPrincipal" method="post" action="">
			<div class="container-fluid">
			<?php
				require_once("./pages/frmmenuprincipal.php");
				require_once("./pages/frmconteudo.php");
			?>
			</div>
		</form>
		<div class="jumbotron bg-dark text-center" style="margin-bottom:0">
  			<p style="color:#fff;">Rodapé</p>
				</div>
	</body>
</html>