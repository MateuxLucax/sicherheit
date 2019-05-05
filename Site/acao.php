<?php

include 'connect/connect.php';
include 'funcoes.php';

$tabela = isset($_POST['tabela']) ? $_POST['tabela'] : $_GET['tabela'];
$pagina = isset($_POST['pagina']) ? $_POST['pagina'] : $_GET['pagina'];
$acao = isset($_POST['acao']) ? $_POST['acao'] : $_GET['acao'];

// Clientes
if ($tabela == $tabelaCliente) {

    // Excluir cliente
    if ($acao == 'excluir') {
        $RG = $_GET['rg'];
        $sql = "DELETE FROM ". $tabela. 
               " WHERE RG = '". $RG. "'";
    }

    // Adicionar cliente
    elseif ($acao == 'inserir') {
        $RG = $_POST['rg'];
        $CPF = $_POST['cpf'];
        $nome = $_POST['nome'];
        $endereco = $_POST['endereco'];
        $telefone = $_POST['telefone'];
        $sql = "INSERT INTO ". $tabela.
               " VALUE ('". $RG. "', 
                        '". $CPF. "', 
                        '". $nome. "', 
                        '". $endereco."', 
                        '". $telefone."')";
    }

    // Alterar cliente
    elseif ($acao == 'alterar') {
        $RG = $_POST['rg'];
        $CPF = $_POST['cpf'];
        $nome = $_POST['nome'];
        $endereco = $_POST['endereco'];
        $telefone = $_POST['telefone'];
        $sql = "UPDATE  ". $tabela.
               " SET  RG = '". $RG. "', 
                      CPF = '". $CPF. "', 
                      Nome =  '". $nome. "', 
                      Endereco =  '". $endereco."', 
                      Telefone =  '". $telefone."' 
                WHERE RG = '". $RG. "'";
    }

}

// Carros
elseif ($tabela == $tabelaCarro) {

    // Excluir carro
    if ($acao == 'excluir') {
        $placa = $_GET['placa'];
        $sql = "DELETE FROM ". $tabela. 
               " WHERE Placa = '". $placa. "'"; 
    }

    // Adicionar carro
    elseif ($acao == 'inserir') {
        $placa = $_POST['placa'];
        $fabricante = $_POST['fabricante'];
        $modelo = $_POST['modelo'];
        $ano = $_POST['ano'];
        $rgCliente = $_POST['rgCliente']; // Chave estrangeira
        $sql = "INSERT INTO ". $tabela.
               " VALUE ('". $placa. "', 
                        '". $fabricante. "', 
                        '". $modelo. "', 
                        ". $ano.", 
                        '". $rgCliente."')";
    }

    // Alterar carro
    elseif ($acao == 'alterar') {
        $placa = $_POST['placa'];
        $fabricante = $_POST['fabricante'];
        $modelo = $_POST['modelo'];
        $ano = $_POST['ano'];
        $rgCliente = $_POST['rgCliente']; // Chave estrangeira
        $sql = "UPDATE  ". $tabela.
               " SET  Placa = '". $placa. "', 
                      Fabricante = '". $fabricante. "', 
                      Modelo =  '". $modelo. "', 
                      Ano =  ". $ano.", 
                      RG_Cliente =  '". $rgCliente."' 
                WHERE Placa = '". $placa. "'";
    }

}

// Ocorrencias
elseif ($tabela == $tabelaOcorrencia) {

    // Excluir carro
    if ($acao == 'excluir') {
        $codigo = $_GET['codigo'];
        $sql = "DELETE FROM ". $tabela. 
               " WHERE Codigo = ". $codigo; 
    }

    // Adicionar carro
    elseif ($acao == 'inserir') {
        $placaCarro = $_POST['placaCarro']; // Chave estrangeira
        $data = converterDataYmd($_POST['data']);
        $local = $_POST['local'];
        $valorMulta = $_POST['valorMulta'];
        $descricao = $_POST['descricao'];
        $sql = "INSERT INTO ". $tabela.
               " VALUE ( null, 
                        '". $placaCarro. "', 
                        '". $data. "', 
                        '". $local."', 
                        ". $valorMulta. ", 
                        '". $descricao."')";
    }

    // Alterar carro
    elseif ($acao == 'alterar') {
        $codigo = $_POST['codigo'];
        $placaCarro = $_POST['placaCarro']; // Chave estrangeira
        $data = converterDataYmd($_POST['data']);
        $local = $_POST['local'];
        $valorMulta = $_POST['valorMulta'];
        $descricao = $_POST['descricao'];
        $sql = "UPDATE  ". $tabela.
               " SET  Placa_Carro = '". $placaCarro. "', 
                      Data =  '". $data. "', 
                      Local =  '". $local."', 
                      Valor_Multa = ". $valorMulta.", 
                      Descricao =  '". $descricao."' 
                WHERE Codigo = '". $codigo. "'";
    }

}

mysqli_query($conexao, $sql);
header ("location:". $pagina);

?>