<?php
	include 'connect/connect.php';

	function checarData($x) {
	    return (date('d/m/Y', strtotime(str_replace("/", "-",  $x))) == $x);
	}

	function converterData($x) {
		return date('d/m/Y', strtotime(str_replace("/", "-",  $x)));
	}

	function converterDataYmd($x) {
		return date('Y-m-d', strtotime(str_replace("/", "-",  $x)));
	}

	function geradorSelect($tabela, $contexto, $valor, $descricao, $nomeSelect) {
		$sql = 'SELECT * FROM '. $tabela. ' ORDER BY '.$descricao;
		$resultado = mysqli_query($GLOBALS['conexao'], $sql);
		echo '<select name="', $nomeSelect,'" required>';
		while ($tupla = mysqli_fetch_array($resultado)) {
			$aux = '';
			if ($contexto == $tupla[0]) {
				$aux = ' selected';
			}
			echo '<option value="', $tupla[$valor],'" ', $aux,'>', $tupla[$descricao], '</option>';
		}
		echo '</select>';
	}

	function Query1paraN($tabela, $codigo, $tupla, $coluna) {
		$query = 'SELECT * FROM '. $tabela.' WHERE '. $tupla.' = '. $codigo;
		$resultadoB = mysqli_query($GLOBALS['conexao'], $query);
		while ($tupla = mysqli_fetch_array($resultadoB)) {
			return $tupla[$coluna];
		}
	}

	function countSQL($tabela, $chavePrimaria) {
		$sql = "SELECT COUNT(`". $chavePrimaria. "`) 
			    FROM `". $tabela. "`";
		while ($tupla = mysqli_fetch_array(mysqli_query($GLOBALS['conexao'], $sql))) {
			return $tupla[0];
		}
	}
	
	function countSQLEspecifico($tabela, $chavePrimaria, $condicao, $valorCondicao) {
		$sql = "SELECT COUNT(`". $chavePrimaria . "`)
				FROM `". $tabela . "`
				WHERE `". $condicao. "` = '". $valorCondicao. "'";
		while ($tupla = mysqli_fetch_array(mysqli_query($GLOBALS['conexao'], $sql))) {
			return $tupla[0];
		}
	}

function countSQLComplexo($RG) {
	$sql = "SELECT COUNT(`Codigo`)
			FROM `Ocorrencias` A
			WHERE A.`Placa_Carro` = (SELECT `Placa` FROM `Carros` B WHERE B.`RG_Cliente` = '". $RG. "')";
	while ($tupla = mysqli_fetch_array(mysqli_query($GLOBALS['conexao'], $sql))) {
		return $tupla[0];
	}
}
?>
