<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>sync</title>
<style type="text/css">
body,td,th {
	font-family: Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, sans-serif;
	font-weight: lighter;
	color: rgba(88,88,88,1);
}
body {
	background-color: rgba(248,248,248,1);
	margin: 30px;
}
a:link {
	text-decoration: none;
	color: rgba(88,88,88,1);
}
a:visited {
	text-decoration: none;
	color: rgba(88,88,88,1);
}
a:hover {
	text-decoration: underline;
	color: rgba(88,88,88,1);
}
a:active {
	text-decoration: none;
	color: rgba(88,88,88,1);
}
a {
	font-weight: lighter;
}
.t{
}
.l, .r{
	border: 1px solid rgba(0,0,0,0.20);
	margin-top: 20px;
	margin-right: 20px;
	margin-left: 20px;
	margin-bottom: 20px;
	padding-top: 20px;
	padding-right: 20px;
	padding-left: 20px;
	padding-bottom: 20px;
	-webkit-box-shadow: inset 2px 2px 2px rgba(0,0,0,0.05);
	box-shadow: inset 2px 2px 2px rgba(0,0,0,0.05);
	background-color: rgba(255,255,255,1.00);
}
</style>
</head>

<body>
<form action="file.php" method="post">
<table border="0" align="center" cellpadding="0" cellspacing="0" class="t">
  <tr>
    <td colspan="2" valign="middle"><strong>Atualizar DB</strong></td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="l">
    	Local<br>
        <input name="urla" type="url" required="required" id="urla" placeholder="URL do servidor" autocomplete="on" value="http://localhost/"><br>
        <input name="hosta" type="url" required="required" id="urla" placeholder="Host" autocomplete="on" value="localhost"><br>
        <input name="nomea" type="text" required="required" id="nomea" placeholder="Usuário" autocomplete="on"><br>
		<input name="senhaa" type="password" required="required" id="senhaa" placeholder="Senha" autocomplete="on"><br>
        <input name="dba" type="text" required="required" id="dba" placeholder="Banco de Dados" autocomplete="on"><br></td>
    <td align="center" valign="middle" class="r">
    	Remoto<br>
        <input name="urlb" type="url" required="required" id="urla" placeholder="URL do servidor" autocomplete="on"><br>
        <input name="hostb" type="url" required="required" id="urla" placeholder="Host" autocomplete="on" value="localhost"><br>
        <input name="nomeb" type="text" required="required" id="nomea" placeholder="Usuário" autocomplete="on"><br>
		<input name="senhab" type="password" required="required" id="senhaa" placeholder="Senha" autocomplete="on"><br>
        <input name="dbb" type="text" required="required" id="dba" placeholder="Banco de Dados" autocomplete="on"><br></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><label><input type="radio" name="dir" value="1" id="dir_0">Atualizar Remoto</label></td>
    <td align="center" valign="middle"><label><input type="radio" name="dir" value="2" id="dir_1">Atualizar Local</label></td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="middle"><input type="submit"></td>
  </tr>
</table>
</form>
</body>
</html>