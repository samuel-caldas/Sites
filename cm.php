<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CM_SG5</title>
<style type="text/css">
body,td,th {
	color: rgba(52,52,52,1);
}
body {
	background-color: rgba(240,240,240,1);
}
</style>
</head>

<body>
<?php
$url = file_get_contents('http://www.bcb.gov.br/');
preg_match_all('/'.''.'(.+)'.''.'/s', $url, $conteudo);
print_r($conteudo);
?>
</body>
</html>