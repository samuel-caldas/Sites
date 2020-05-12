<?php
// Array com as configurações do banco de dados //
$_DB['usr']='floresde_sarom';
$_DB['pw']='sabedoria';
$_DB['db']='floresde_sarom';

// Array com as configurações do backup
$_bkp['$utf8']=true; // Remover caracteres que não sejam utf-8

// regex para verificar se o char é UTF-8
$regex1=<<<'END'
/
( [\x00-\x7F]                 # single-byte sequences   0xxxxxxx
| [\xC0-\xDF][\x80-\xBF]      # double-byte sequences   110xxxxx 10xxxxxx
| [\xE0-\xEF][\x80-\xBF]{2}   # triple-byte sequences   1110xxxx 10xxxxxx * 2
| [\xF0-\xF7][\x80-\xBF]{3}   # quadruple-byte sequence 11110xxx 10xxxxxx * 3 
)
|.                          	# anything else
/x
END;

///////////////////////////////////////////////////////////////////////////////////////////////////////////

// Conecta com o banco de dados
$dbh=mysql_connect("localhost", $_DB['usr'], $_DB['pw'])or die('I cannot connect to the database because: '.mysql_error());
mysql_select_db($_DB['db']) or die(mysql_error());

// Cria um arquivo $_DB['db'].sql
$back=fopen($_DB['db'].".sql", "w");
fwrite($back, "set foreign_key_checks=0;\n\n"); // Evita erros, nao remova.

// Lista todas as tabelas do banco selecionado
//$res=mysql_list_tables($_DB['db']) or die(mysql_error());
$res=mysql_query("SHOW TABLES FROM ".$_DB['db']) or die(mysql_error());

// Resgata cada uma das tabelas
while ($row=mysql_fetch_row($res)){
	$table=$row[0];
	$res2=mysql_query("SHOW CREATE TABLE $table");
	while ($lin=mysql_fetch_row($res2)){
		// Grava no arquivo as funções de criação da tabela
		fwrite($back, "$lin[1] ;\n\n");
		// Seleciona todos os dados da tabela
		$first=true;
		$res3=mysql_query("SELECT * FROM $table");
		while ($r=mysql_fetch_row($res3)){
			if ($first){
				$sql="INSERT INTO $table VALUES ";
				$first=false;
			}else{
				$sql.=',';
			}
			$sql.="('";
			$imploded='';
			$firstImplode=true;
			foreach ($r as $reg){
				if ($firstImplode){
					$firstImplode=false;
				}else{
					$imploded.="', '";
				}
				if ($_bkp['$utf8']){
					$escaped=str_replace('\'', "\\'", str_replace('\\', "\\\\", preg_replace($regex1, '$1', $reg)));
				}else{
					$escaped=str_replace('\'', "\\'", str_replace('\\', "\\\\", $reg));
				}
				$imploded.=$escaped;
			}
			$sql.=$imploded;
			$sql.="')\n";
		}
		if (!$first){
			$sql.=";\n";
			fwrite($back, $sql);
		}
	}
}
// Fecha o arquivo que foi gravado
fclose($back);
// Gera o download, com o nome do banco e extensão sql.
$arquivo=$_DB['db'].".sql";
Header("Content-type: application/sql");
Header("Content-Disposition: attachment; filename=$arquivo");
// lê e exibe o conteúdo do arquivo gerado
readfile($arquivo);
?>