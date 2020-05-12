<!doctype html>
<html>
<style type="text/css">
body,td,th {
	color: rgba(0,119,170,1.00);
	font-family: Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, sans-serif;
	line-height: 25px;
}
a:link {
	color: rgba(102,147,166,1);
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: rgba(72,174,218,1);
}
a:hover {
	text-decoration: underline;
	color: rgba(0,142,203,1);
}
a:active {
	text-decoration: none;
	color: rgba(0,92,132,1);
}
body {
	background-color: rgba(245,245,245,1);
}
.dialogo{
	background-color: rgba(255,255,255,1.00);
	display: block;
	margin-top: 10px;
	margin-right: 10px;
	margin-bottom: 10px;
	margin-left: 10px;
	padding-top: 10px;
	padding-right: 10px;
	padding-bottom: 10px;
	padding-left: 10px;
	border: 1px solid rgba(190,190,190,1.00);
	border-radius: 5px;
	-webkit-box-shadow: inset 2px 2px 2px rgba(88,88,88,0.48);
	box-shadow: inset 2px 2px 2px rgba(88,88,88,0.48);
}
</style>
<head>
<title>CRIADOR DE TABELAS em um arquivo .SQL</title>
<meta charset="utf-8">
</head>

<body>
<div id="dialogo">
<form action="restore.php" method="POST" enctype="multipart/form-data">
Enviar o arquivo: <input type="file" name="arquivo" size="20"><br>
<input type="submit" value="Enviar">
</form>
<ol>
<?php ////////////////////////////////////////////////////////////////////////////////
// Nome do upload //
$_UP['name']='arquivo';

// Array com as extensões permitidas //
$_UP['extensoes']=array('txt', 'sql');

// Excessões
$_UP['exc']='--';

// Array com os tipos de erros de upload do PHP //
$_UP['erros'][0]='Não houve erro';
$_UP['erros'][1]='O arquivo no upload é maior do que o limite do PHP';
$_UP['erros'][2]='O arquivo ultrapassa o limite de tamanho especifiado no HTML';
$_UP['erros'][3]='O upload do arquivo foi feito parcialmente';
$_UP['erros'][4]='Não foi feito o upload do arquivo';

// Array com as configurações do banco de dados //
$_DB['usr']='floresde_sarom';
$_DB['pw']='sabedoria';
$_DB['db']='floresde_sarom';

/////////////////////////////////////////////////////////////////////////////////////

// Verifica se o upload existe //
if(is_uploaded_file($_FILES[$_UP['name']]['tmp_name'])){ 
 
// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro //
if($_FILES[$_UP['name']]['error']!=0){
	die("Não foi possível fazer o upload, erro:<br />" . $_UP['erros'][$_FILES[$_UP['name']]['error']]);
	exit; // Para a execução do script //
}

// Faz a verificação da extensão do arquivo //
$extensao=explode('.', $_FILES[$_UP['name']]['name']);
if(array_search(strtolower(end($extensao)), $_UP['extensoes'])===false){
	die("Por favor, envie arquivos com as seguintes extensões: ".implode(', ', $_UP['extensoes']));
	exit; // Para a execução do script //
}

// Conecta com o banco de dados
$dbh=mysql_connect("localhost", $_DB['usr'], $_DB['pw'])or die('I cannot connect to the database because: ' . mysql_error());
mysql_select_db($_DB['db']);

// Remove todas as linhas de comentários
foreach(file($_FILES[$_UP['name']]['tmp_name']) as $line){
	if(strstr($line, $_UP['exc'])===false){
		$file[]=$line;
	}
}

// Executa todas as linhas
foreach(explode(";",implode('',$file)) as $key => $sql) {
	if(mysql_query($sql)){
		echo('<li>'.$sql.';</li>');
	}else{mysql_error();}
}

}
?>
</ol>
</div>
</html>
</body>
