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

	// Realiza uma contagem de uma tabela
	function countSQL($tabela, $chavePrimaria) {
		$sql = "SELECT COUNT(`". $chavePrimaria. "`)
			    	FROM `". $tabela. "`";
		while ($tupla = mysqli_fetch_array(mysqli_query($GLOBALS['conexao'], $sql))) {
			return $tupla[0];
		}
	}

	// Realiza uma contagem de uma tabela, porém obedecendo uma condição
	function countSQLComCondicao($tabela, $valorCount, $condicao, $valorCondicao) {
		$sql = "SELECT COUNT(`". $valorCount . "`)
				FROM `". $tabela . "`
				WHERE `". $condicao. "` = '". $valorCondicao. "'";
		while ($tupla = mysqli_fetch_array(mysqli_query($GLOBALS['conexao'], $sql))) {
			return $tupla[0];
		}
	}

	// Realiza uma contagem em uma tabela, com uma condição sendo refêrenciada de outra tabela
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
	function avgSQLAnoCarro($tabela, $coluna, $tituloColunaNova) {
		$sql = "SELECT AVG(`". $coluna . "`) 
				AS `".$tituloColunaNova."`
				FROM `". $tabela ."`";
		while ($tupla = mysqli_fetch_array(mysqli_query($GLOBALS['conexao'], $sql))) {
			return $tupla[0];
		}
	}

	// Realiza a pesquisa de ocorrencia mais recente	
	function maxSQL($tabela, $colunaAvaliada) {
		$sql = "SELECT MAX(`". $colunaAvaliada . "`)
				FROM `". $tabela ."`";
		while ($tupla = mysqli_fetch_array(mysqli_query($GLOBALS['conexao'], $sql))) {
			return $tupla[0];
		}
	}

	// Realiza a pesquisa do menor campo
	function minSQL($tabela, $colunaAvaliada) {
		$sql = "SELECT MIN(`". $colunaAvaliada . "`)
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

	// Realiza a soma das ocorrências de cada cliente
	function sumAninhado($valorMultaColuna, $tabela1, $tabela2, $condicao1, $condicao2, $valorCondicao1, $valorCondicao2) {
		$sql = "SELECT SUM(`". $valorMultaColuna. "`)
				FROM `". $tabela1. "`
				WHERE `". $condicao1. "` = (SELECT `". $valorCondicao1. "`
											FROM `". $tabela2. "`
											WHERE `". $condicao2. "` = '". $valorCondicao2. "')";
		while ($tupla = mysqli_fetch_array(mysqli_query($GLOBALS['conexao'], $sql))) {
			return $tupla[0];
		}
	}

	//Realiza a pesquisa entre dois valores
	function betweenSQLSimples($tabela, $coluna, $menorValor, $maiorValor) {
		// SELECT * FROM `Carros` WHERE `Ano` >= 1975 AND `Ano` <= 2020;
		// SELECT * FROM `Carros` WHERE `Ano` BETWEEN 1975 AND 2020;
		return "SELECT * 
			    FROM `". $tabela. "` 
			    WHERE `". $coluna. "` BETWEEN ". $menorValor. " AND ". $maiorValor;
	}

	// Adquire o dólar no dia atual segundo o site infomoney 
	function dolarAtual() {

		/* 
		   Créditos para a aquisição do valor do dólar 
		   https://pt.stackoverflow.com/questions/210299/script-para-extrair-valores-do-site-infomoney-para-cota%C3%A7%C3%A3o-de-dolar
		*/
		
		if(!$fp=fopen("https://www.infomoney.com.br/mercados/cambio" , "r" )) {
			echo "Erro ao abrir a página de cotação" ;
			exit;
		}
		
		$conteudo = '';
		while(!feof($fp)) { 
			$conteudo .= fgets($fp,1024);
		}
		
		fclose($fp);
		
		$valorCompraHTML = explode('<td><span>', $conteudo); 
		$valorCompra = trim(strip_tags($valorCompraHTML[1]));
		$valorVendaHTML = explode('+', strip_tags($valorCompraHTML[2]));
		
		// Dolar comercial posicao 1 e 2
		// Euro posicao 7 e 8
		// Peso Argentino Posicao 13 e 14
		
		//Estes são os valores HTML para exibir no site.  
		$valorVendaHTML = explode('-', $valorVendaHTML[0]);
		$valorVenda  = trim($valorVendaHTML[0]) ;
		
		//Estes são os valores numéricos para cálculos.     
		$valorCompraCalculavel = str_replace(',','.', $valorCompra);
		$valorVendaCalculavel  = str_replace(',','.', $valorVenda);

		return $valorCompraCalculavel;

	}

	// Converte o valor em R$ para $ / USD
	function converterDolar($tabela, $coluna, $codigo, $valorCodigo) {
		$sql = "SELECT `". $coluna. "` / ". dolarAtual(). " 
				FROM `". $tabela. "` 
				WHERE `". $codigo.  "` = ". $valorCodigo;
		while ($tupla = mysqli_fetch_array(mysqli_query($GLOBALS['conexao'], $sql))) {
			return $tupla[0];
		}
	}

?>
