<?php
	
	include 'conf/conf.inc.php';
	header('Content-Type: text/html; charset=UTF-8');
	
	$conexao = mysqli_connect ($hostBD, $usuarioBD, $senhaBD, $nomeBD);
	if (mysqli_connect_errno())
		echo mysqli_connect_error();
		
	mysqli_set_charset($conexao, 'utf8');

?>