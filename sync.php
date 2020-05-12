<?php
include'DBFramework.php';
// use true se quiser remover caracteres que não sejam utf-8
    $checkUtf=false;
// conectando ao banco
	conect('','','','');
// aqui,listo todas as tabelas daquele banco selecionado acima
    $res=mysql_list_tables($dbname) or die(mysql_error());
	//$res=mysql_query("SHOW TABLES FROM $dbname") or die(mysql_error());

    // ultra importante para não dar erro nos primeiros inserts
    // principalmente de usar InnoDB e relacionar as tabelas
    fwrite($back,"set foreign_key_checks=0;\n\n");
    
    // regex para ver se o char é UTF-8
    $regex1=<<<'END'
/
  ( [\x00-\x7F]                 # single-byte sequences   0xxxxxxx
  | [\xC0-\xDF][\x80-\xBF]      # double-byte sequences   110xxxxx 10xxxxxx
  | [\xE0-\xEF][\x80-\xBF]{2}   # triple-byte sequences   1110xxxx 10xxxxxx * 2
  | [\xF0-\xF7][\x80-\xBF]{3}   # quadruple-byte sequence 11110xxx 10xxxxxx * 3 
  )
| .                             # anything else
/x
END;
    
// resgato cada uma das tabelas,num loop
    while($row=mysql_fetch_row($res)){
        $table=$row[0];
// usando a função SHOW CREATE TABLE do mysql,exibo as funções de criação da tabela,
// exportando também isso,para nosso arquivo de backup
        $res2=mysql_query("SHOW CREATE TABLE $table");
// digo que o comando acima deve ser feito em cada uma das tabelas
        while($lin=mysql_fetch_row($res2)){
// instruções que serão gravadas no arquivo de backup
            fwrite($back,"\n#\n# Criação da Tabela : $table\n#\n\n");
            fwrite($back,"$lin[1] ;\n\n#\n# Dados a serem incluídos na tabela\n#\n\n");

// seleciono todos os dados de cada tabela pega no while acima
// e depois gravo no arquivo .sql,usando comandos de insert
            $res3=mysql_query("SELECT * FROM $table");
            $first=true;
            while($r=mysql_fetch_row($res3)) 
            {
                if($first)
                {
                    $sql="INSERT INTO $table VALUES ";
                    $first=false;
                }
                else
                {
                    $sql .= ',';
                }
                
                
                $sql .= "('";
                
                $imploded='';
                
                $firstImplode=true;
                
                foreach($r as $reg) 
                {
                    if($firstImplode)
                    {
                        $firstImplode=false;
                    }
                    else
                    {
                        $imploded .= "','";
                    }
                    
                    if($checkUtf)
                    {
                        $escaped=str_replace('\'',"\\'",str_replace('\\',"\\\\",preg_replace($regex1,'$1',$reg)));
                    }
                    else 
                    {
                        $escaped=str_replace('\'',"\\'",str_replace('\\',"\\\\",$reg));
                    }
                    $imploded .= $escaped;
                }
                
                $sql .= $imploded;
                
                $sql .= "')\n";

            }
            if(!$first)
            {
                $sql .= ";\n";
                fwrite($back,$sql);
            }
        }
    }

?>