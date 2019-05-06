<!DOCTYPE html>
<html lang="pt-br">

<!-- Inicialização do código -->
<?php

    include 'funcoes.php';
	include 'connect/connect.php';
	$pesquisa = isset($_POST['pesquisa']) ? $_POST['pesquisa'] : '';
	$filtro = isset($_POST['filtro']) ? $_POST['filtro'] : 'nenhum';
	$pagina = 'clientes.php';
    $nomeTabela = $tabelaCliente;

?>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Clientes - Sicherheit</title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="assets/img/favicon.png" />

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">

  <!-- CSS -->
  <link href="assets/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>

<body>

<header>

    <!-- Cabeçalho -->
    <div class="navbar-fixed">
        <nav>
            <div class="nav-wrapper container">
            <a href="index.php" class="brand-logo"><img src="assets/img/logo-sicherheit.png" alt="Logo Sicherheit"></a>
            <a href="#" data-target="mobile-sidenav" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <li><a href="index.php">Painel de controle</a></li>
                <li><a class="active" href="clientes.php">Clientes</a></li>
                <li><a href="carros.php">Carros</a></li>
                <li><a href="ocorrencias.php">Ocorrências</a></li>
            </ul>
            </div>
        </nav>
    </div>

    <!-- Sidenav mobile -->
    <ul class="sidenav" id="mobile-sidenav">
        <li><a href="index.php"><i class="material-icons">dashboard</i>Painel de controle</a></li>
        <li><a class="active" href="clientes.php"><i class="material-icons">assignment_ind</i>Clientes</a></li>
        <li><a href="carros.php"><i class="material-icons">directions_car</i>Carros</a></li>
        <li><a href="ocorrencias.php"><i class="material-icons">commute</i>Ocorrências</a></li>
    </ul>

  </header>
  <main style="margin-top: 2.5rem;">

    <!-- Pesquisa -->
    <div class="section">
        <div class="container">
            <div class="card-panel">
                <h5 class="center-align title">Filtrar registros</h5>

                <!-- Formulário -->
                <form action="clientes.php" method="POST">
                    <div class="row">
                        <div class="col s12 m8 offset-m2">
                            <div class="input-field">
                                <i class="material-icons prefix">search</i>
                                <input id="pesquisar" type="text" name="pesquisa" value="<?php echo $pesquisa; ?>" class="validate">
                                <label for="pesquisar">O que procura?</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Pesquisa avançada -->
                        <div class="row" id="pesquisaAvancada">
                            <div class="col s12 m8 offset-m2">
                                <div class="input-field">
                                    <select name="filtro">
                                        <option value="nenhum" disabled <?php echo $filtro == 'nenhum' ? 'selected' : '' ?>>Escolha uma opção</option>
                                        <option value="Nome">Nome</option>
                                        <option value="RG">RG</option>
                                        <option value="CPF">CPF</option>
                                    </select>
                                    <label>Filtro por coluna</label>
                                </div>
                            </div>
                        </div>
                        <div class="col s6 m4 offset-m2 left-align" style="margin-top: 0.4rem;">
                            <label>
                                <input type="checkbox" id="checkboxPesquisaAvancada" />
                                <span>Pesquisa avançada</span>
                            </label>
                        </div>
                        <div class="col s6 m4 right-align">
                            <button class="btn waves-effect waves-light" type="submit" name="action">Pesquisar<i class="material-icons right">send</i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Filtros e SQL -->
    <?php

        if ($pesquisa == '') {
            $sql = "SELECT * FROM ". $nomeTabela;
        } elseif ($filtro == 'Nome') {
            $sql = "SELECT * FROM ". $nomeTabela. " WHERE Nome LIKE '%". $pesquisa. "%' ORDER BY ". $filtro;
        } elseif ($filtro == 'RG') {
            $sql = "SELECT * FROM ". $nomeTabela. " WHERE RG LIKE '". $pesquisa. "%' ORDER BY ". $filtro;
        } elseif ($filtro == 'CPF') {
            $sql = "SELECT * FROM ". $nomeTabela. " WHERE CPF LIKE '". $pesquisa. "%' ORDER BY ". $filtro;
        } else {
            $sql = "SELECT * FROM ". $nomeTabela. " WHERE Nome LIKE '%". $pesquisa. "%'
                                                          OR CPF LIKE '". $pesquisa. "%'
                                                          OR RG LIKE'%". $pesquisa. "%'";
        }
        $resultado = mysqli_query ($conexao, $sql);

    ?>

    <!-- Tabela-->
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col s12">

                <table class="highlight centered responsive-table">
                    <thead>
                        <tr class="title">
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>RG</th>
                            <th>Endereço</th>
                            <th>Telefone</th>
                            <th>Valor total das multas</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($tupla = mysqli_fetch_array($resultado)){ ?>
                            <tr>
                                <td><?php echo $tupla['Nome']; ?></td>
                                <td><?php echo $tupla['CPF']; ?></td>
                                <td><?php echo $tupla['RG']; ?></td>
                                <td><?php echo $tupla['Endereco']; ?></td>
                                <td><?php echo $tupla['Telefone']; ?></td>
                                <td>R$ <?php echo number_format(sumAninhado('Valor_Multa', $tabelaOcorrencia, $tabelaCarro, 'Placa_Carro', 'RG_Cliente', 'Placa', $tupla['RG']), 2, ',', '.') ?></td>
                                <!-- Alterar -->
                                <td>
                                    <a class="modal-trigger alterar" href="#alterar<?php echo $tupla['RG']; ?>"><i class="material-icons">create</i></a>
                                    <div id="alterar<?php echo $tupla['RG']; ?>" class="modal modal-fixed-footer">
                                        <div class="modal-content">
                                            <!-- Formulário | Alterar -->
                                            <form action="acao.php" method="post">
                                            <h5 class="title">Alterar</h5>
                                                <div class="row">
                                                    <div class="col s12">
                                                        <div class="input-field">
                                                            <input required name="nome" id="nome<?php echo $tupla['RG']; ?>" type="text" value="<?php echo $tupla['Nome']; ?>" class="validate">
                                                            <label for="nome<?php echo $tupla['RG']; ?>">Nome</label>
                                                        </div>
                                                    </div>
                                                    <div class="col s12">
                                                        <div class="input-field">
                                                            <input required name="cpf" id="cpf<?php echo $tupla['RG']; ?>" type="text" value="<?php echo $tupla['CPF']; ?>" class="validate" data-mask="000.000.000-00">
                                                            <label for="cpf<?php echo $tupla['RG']; ?>">CPF</label>
                                                        </div>
                                                    </div>
                                                    <div class="col s12">
                                                        <div class="input-field">
                                                            <textarea required name="endereco" id="endereco<?php echo $tupla['RG']; ?>" class="materialize-textarea"><?php echo $tupla['Endereco']; ?></textarea>
                                                            <label for="endereco<?php echo $tupla['RG']; ?>">Endereço</label>
                                                        </div>
                                                    </div>
                                                    <div class="col s12">
                                                        <div class="input-field">
                                                            <input required name="telefone" id="telefone<?php echo $tupla['RG']; ?>" type="text" value="<?php echo $tupla['Telefone']; ?>" class="validate" data-mask="(00) 00000-0000">
                                                            <label for="telefone<?php echo $tupla['RG']; ?>">Telefone</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="rg" value="<?php echo $tupla['RG'] ?>" />
                                            <input type="hidden" name="tabela" value="<?php echo $nomeTabela; ?>" />
                                            <input type="hidden" name="pagina" value="<?php echo $pagina; ?>" />
                                            <input type="hidden" name="acao" value="alterar" />
                                            <div class="modal-footer">
                                                <a href="#!" class="modal-close waves-effect waves-red btn-flat left">Fechar</a>
                                                <button type="submit" class="modal-close waves-effect waves-green btn-flat">Confirmar</button>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                                <!-- Excluir -->
                                <td>
                                    <a class="modal-trigger excluir" href="#excluir<?php echo $tupla['RG']; ?>"><i class="material-icons">delete</i></a>
                                    <div id="excluir<?php echo $tupla['RG']; ?>" class="modal white-text">
                                        <div class="modal-content gradient-red">
                                            <h5 class="title">Atenção</h5>
                                            <p class="white-text">Deseja realmente excluir este registro?</p>
                                        </div>
                                        <div class="modal-footer gradient-red">
                                            <a href="#!" class="modal-close white-text waves-effect waves-light btn-flat left">Cancelar</a>
                                            <a href="acao.php?acao=excluir&tabela=<?php echo $nomeTabela;?>&pagina=<?php echo $pagina;?>&rg=<?php echo $tupla['RG'];?>" class="modal-close white-text waves-effect waves-light btn-flat">Confirmar</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                            <!-- Adicionar -->
                            <tr>
                                <td>
                                    <span class="title left-align">Adicionar</span>
                                </td>
                                <td></td><td></td><td></td><td></td><td></td><td></td>
                                <td>
                                    <a class="modal-trigger adicionar" href="#adicionar"><i class="material-icons">add_circle</i></a>
                                    <div id="adicionar" class="modal modal-fixed-footer">
                                        <div class="modal-content">
                                            <!-- Formulário | Adicionar -->
                                            <form action="acao.php" method="post">
                                                <h5 class="title">Adicionar cliente</h5>
                                                <div class="row">
                                                    <div class="col s12">
                                                        <div class="input-field">
                                                            <input required name="nome" id="nomeInserir" type="text" class="validate">
                                                            <label for="nomeInserir">Nome</label>
                                                        </div>
                                                    </div>
                                                    <div class="col s12">
                                                        <div class="input-field">
                                                            <input required name="cpf" id="cpfInserir" type="text" class="validate" data-mask="000.000.000-00">
                                                            <label for="cpfInserir">CPF</label>
                                                        </div>
                                                    </div>
                                                    <div class="col s12">
                                                        <div class="input-field">
                                                            <input required name="rg" id="rgInserir" type="text" class="validate" data-mask="000.000.000">
                                                            <label for="rgInserir">RG</label>
                                                        </div>
                                                    </div>
                                                    <div class="col s12">
                                                        <div class="input-field">
                                                            <textarea required name="endereco" id="enderecoInserir" class="materialize-textarea"></textarea>
                                                            <label for="enderecoInserir">Endereço</label>
                                                        </div>
                                                    </div>
                                                    <div class="col s12">
                                                        <div class="input-field">
                                                            <input required name="telefone" id="telefoneInserir" type="text"class="validate" data-mask="(00) 00000-0000">
                                                            <label for="telefoneInserir">Telefone</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="tabela" value="<?php echo $nomeTabela; ?>" />
                                            <input type="hidden" name="pagina" value="<?php echo $pagina; ?>" />
                                            <input type="hidden" name="acao" value="inserir" />
                                            <div class="modal-footer">
                                                <a href="#!" class="modal-close waves-effect waves-red btn-flat left">Fechar</a>
                                                <button type="submit" class="modal-close waves-effect waves-green btn-flat">Confirmar</button>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

</main>

<footer class="page-footer">
    <div class="footer-copyright">
        <div class="container">
            <span class="left" id="copyright-js"></span> &nbsp; <a target="_blank" href="https://github.com/MateuxLucax/Sicherheit">Sicherheit</a>
            <span class="right"><a target="_blank" href="https://opensource.org/licenses/MIT">MIT License</a></span>
        </div>
    </div>
</footer>

  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="assets/js/materialize.min.js"></script>
  <script src="assets/js/init.js"></script>
  <script src="assets/js/jquery.mask.min.js"></script>

  </body>

</html>
