<?php

	include 'connect/connect.php';

	// Checa se uma data é válida
	function checarData($x) {
	    return (date('d/m/Y', strtotime(str_replace("/", "-",  $x))) == $x);
	}

	// Converte uma data no formato AAAA-MM-DD para DD/MM/AAAA
	function converterData($x) {
		return date('d/m/Y', strtotime(str_replace("/", "-",  $x)));
	}

	// Converte uma data no formato DD/MM/AAAA para AAAA-MM-DD 
	function converterDataYmd($x) {
		return date('Y-m-d', strtotime(str_replace("/", "-",  $x)));
	}

	// Gera um select baseado em uma tabela 1:N
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

	// Busca de informações de N:N
	function Query1paraN($tabela, $codigo, $tupla, $coluna) {
		$query = 'SELECT * FROM '. $tabela.' WHERE '. $tupla.' = '. $codigo;
		$resultadoB = mysqli_query($GLOBALS['conexao'], $query);
		while ($tupla = mysqli_fetch_array($resultadoB)) {
			return $tupla[$coluna];
		}
	}

	// Realiza um count()
	function countSQL($tabela, $chavePrimaria) {
		$sql = "SELECT COUNT(`". $chavePrimaria. "`) 
			    FROM `". $tabela. "`";
		while ($tupla = mysqli_fetch_array(mysqli_query($GLOBALS['conexao'], $sql))) {
			return $tupla[0];
		}
	}

	// Realiza um cont() e retorna a quantidade de valores distintos
	function countDistinctSQL($tabela, $chavePrimaria) {
		$sql = "SELECT COUNT(DISTINCT`". $chavePrimaria. "`) 
			    FROM `". $tabela. "`";
		while ($tupla = mysqli_fetch_array(mysqli_query($GLOBALS['conexao'], $sql))) {
			return $tupla[0];
		}
	}
	
	// Realiza um count() com condição
	function countSQLComCondicao($tabela, $valorCount, $condicao, $valorCondicao) {
		$sql = "SELECT COUNT(`". $valorCount . "`)
				FROM `". $tabela . "`
				WHERE `". $condicao. "` = '". $valorCondicao. "'";
		while ($tupla = mysqli_fetch_array(mysqli_query($GLOBALS['conexao'], $sql))) {
			return $tupla[0];
		}
	}

	// Realiza um count() utilizando a tabela acima 
	function countSQLAninhado($count, $tabela1, $tabela2, $condicao1, $condicao2, $valorCondicao1, $valorCondicao2) {
		$sql = "SELECT COUNT(`". $count. "`)
				FROM `". $tabela1. "`
				WHERE `". $condicao1. "` = (SELECT `". $valorCondicao1. "` 
											FROM `". $tabela2. "` 
											WHERE `". $condicao2. "` = '". $valorCondicao2. "')";
		while ($tupla = mysqli_fetch_array(mysqli_query($GLOBALS['conexao'], $sql))) {
			return $tupla[0];
		}
	}

	// Realiza um média na tabela
	function avgSQL($tabela, $coluna) {
		$sql = "SELECT AVG(`". $coluna . "`) 
				FROM `". $tabela . "`";
		while ($tupla = mysqli_fetch_array(mysqli_query($GLOBALS['conexao'], $sql))) {
			return $tupla[0];
		}
	}
	
	// Realiza uma média na tabela obedecendo uma condição
	function avgSQLComCondicao($tabela, $coluna, $condicao, $valorCondicao) {
		$sql = "SELECT AVG(`". $coluna . "`) 
				FROM `". $tabela . "` 
				WHERE `". $condicao. "` = `". $valorCondicao. "`";
		while ($tupla = mysqli_fetch_array(mysqli_query($GLOBALS['conexao'], $sql))) {
			return $tupla[0];
		}
	}

	// Realiza a média de ano de todos os carros
	// SELECT AVG(Ano) AS media_Ano FROM Carros;
	function avgSQLAnoCarro($tabela, $coluna,$TituloColunaNova) {
		$sql = "SELECT AVG(`". $coluna . "`) 
				AS `".$TituloColunaNova."`
				FROM `". $tabela ."`";
		while ($tupla = mysqli_fetch_array(mysqli_query($GLOBALS['conexao'], $sql))) {
			return $tupla[0];
		}
	}

	// Realiza a pesquisa de ocorrencia mais recente
	// SELECT `Codigo`, `Placa_Carro`, MAX(`Data`), `Local`, `Descricao` FROM Ocorrencias;
	function maxSQL($tabela, $colunaAvaliada) {
		$sql = "SELECT MAX(`". $colunaAvaliada . "`)
				FROM `". $tabela ."`";
		while ($tupla = mysqli_fetch_array(mysqli_query($GLOBALS['conexao'], $sql))) {
			return $tupla[0];
		}
	}

	// Realiza a pesquisa do menor campo
	function minSQL($tabela, $colunaAvaliada) {
		$sql = "SELECT MAX(`". $colunaAvaliada . "`)
				FROM `". $tabela ."`";
		while ($tupla = mysqli_fetch_array(mysqli_query($GLOBALS['conexao'], $sql))) {
			return $tupla[0];
		}
	}

	// Realiza a soma de um campo
	function sumSQL($tabela, $colunaAvaliada) {
		$sql = "SELECT SUM(`". $colunaAvaliada . "`)
				FROM `". $tabela ."`";
		while ($tupla = mysqli_fetch_array(mysqli_query($GLOBALS['conexao'], $sql))) {
			return $tupla[0];
		}
	}
?>
