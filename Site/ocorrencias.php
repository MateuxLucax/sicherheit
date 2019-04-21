<!DOCTYPE html>
<html lang="pt-br">

<!-- Inicialização do código -->
<?php

    include 'funcoes.php';
	include 'connect/connect.php';
	$pesquisa = isset($_POST['pesquisa']) ? $_POST['pesquisa'] : '';
	$filtro = isset($_POST['filtro']) ? $_POST['filtro'] : 'nenhum';
	$pagina = 'ocorrencias.php';
    $nomeTabela = $tabelaOcorrencia;
    
?>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Ocorrências - Sicherheit</title>

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
                <li><a href="clientes.php">Clientes</a></li>
                <li><a href="carros.php">Carros</a></li>
                <li><a class="active" href="ocorrencias.php">Ocorrências</a></li>
            </ul>
            </div>
        </nav>
    </div>
    
    <!-- Sidenav mobile -->
    <ul class="sidenav" id="mobile-sidenav">
        <li><a href="index.php"><i class="material-icons">dashboard</i>Painel de controle</a></li>
        <li><a href="clientes.php"><i class="material-icons">assignment_ind</i>Clientes</a></li>
        <li><a class="active" href="carros.php"><i class="material-icons">directions_car</i>Carros</a></li>
        <li><a class="active" href="ocorrencias.php"><i class="material-icons">commute</i>Ocorrências</a></li>
    </ul>

  </header>
  <main style="margin-top: 2.5rem;">

    <!-- Pesquisa -->
    <div class="section">
        <div class="container">
            <div class="card-panel">
                <h5 class="center-align title">Filtrar registros</h5>

                <!-- Formulário -->
                <form action="" method="POST">
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
                                        <option value="0" disabled selected>Escolha uma opção</option>
                                        <option value="Codigo">Codigo</option>
                                        <option value="Data">Data</option>
                                        <option value="Local">Local</option>
                                    </select>
                                    <label>Filtros específicos</label>
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
        } elseif ($filtro == 'Codigo') {
            $sql = "SELECT * FROM ". $nomeTabela. " WHERE Codigo LIKE '%". $pesquisa. "%' ORDER BY ". $filtro;
        } elseif ($filtro == 'Data') {
            $sql = "SELECT * FROM ". $nomeTabela. " WHERE Data LIKE '". $pesquisa. "%' ORDER BY ". $filtro;
        } elseif ($filtro == 'Local') {
            $sql = "SELECT * FROM ". $nomeTabela. " WHERE Local LIKE '%". $pesquisa. "%' ORDER BY ". $filtro;
        } else {
            $sql = "SELECT * FROM ". $nomeTabela. " WHERE Codigo LIKE '%". $pesquisa. "%'
                                                        OR Data LIKE '". $pesquisa. "%' 
                                                        OR Local LIKE'%". $pesquisa. "%'"; 
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
                            <th>Código</th>
                            <th>Placa do carro</th>
                            <th>Data</th>
                            <th>Local</th>
                            <th>Descrição</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                
                        <tbody>
                        <?php while ($tupla = mysqli_fetch_array($resultado)){ ?>
                        <tr>
                            <td><?php echo $tupla['Codigo']; ?></td>
                            <td><?php echo $tupla['Placa_Carro']; ?></td>
                            <td><?php echo converterData($tupla['Data']); ?></td>
                            <td><?php echo $tupla['Local']; ?></td>
                            <td><?php echo $tupla['Descricao']; ?></a></td>
                            <!-- Alterar -->
                            <td>
                                <a class="modal-trigger alterar" href="#alterar<?php echo $tupla['Codigo']; ?>"><i class="material-icons">create</i></a>
                                <div id="alterar<?php echo $tupla['Codigo']; ?>" class="modal modal-fixed-footer">
                                    <div class="modal-content">
                                        <!-- Formulário | Alterar -->
                                        <form action="acao.php" method="post">
                                        <h5 class="title">Alterar</h5>
                                            <div class="row">
                                                <div class="col s12">
                                                    <div class="input-field">
                                                        <?php geradorSelect($tabelaCarro, 'PLaca_Carro', 'Placa', 'Placa', 'placaCarro'); ?>
                                                        <label>Placa do carro</label>
                                                    </div>
                                                </div>
                                                <div class="col s12">
                                                    <div class="input-field">
                                                        <input required id="data<?php echo $tupla['codigo']; ?>" type="text" name="data" value="<?php echo converterData($tupla['Data']); ?>" class="validate" data-mask="00/00/0000">
                                                        <label for="data<?php echo $tupla['codigo']; ?>">Data</label>
                                                    </div>
                                                </div>
                                                <div class="col s12">
                                                    <div class="input-field">
                                                        <input required id="local<?php echo $tupla['codigo']; ?>" type="text" name="local" value="<?php echo $tupla['Local']; ?>" class="validate">
                                                        <label for="local<?php echo $tupla['codigo']; ?>">Local</label>
                                                    </div>
                                                </div>
                                                <div class="col s12">
                                                    <div class="input-field">
                                                        <textarea required id="descriacao<?php echo $tupla['codigo']; ?>" name="descricao" class="materialize-textarea"><?php echo $tupla['Descricao']; ?></textarea>
                                                        <label for="descriacao<?php echo $tupla['codigo']; ?>">Descrição</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="codigo" value="<?php echo $tupla['Codigo']; ?>">
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
                                <a class="modal-trigger excluir" href="#excluir<?php echo $tupla['Codigo']; ?>"><i class="material-icons">delete</i></a>
                                <div id="excluir<?php echo $tupla['Codigo']; ?>" class="modal white-text">
                                    <div class="modal-content gradient-red">
                                    <h5 class="title">Atenção</h5>
                                    <p class="white-text">Deseja realmente excluir este registro?</p>
                                    </div>
                                    <div class="modal-footer gradient-red">
                                        <a href="#!" class="modal-close white-text waves-effect waves-light btn-flat left">Fechar</a>
                                        <a href="acao.php?acao=excluir&tabela=<?php echo $nomeTabela;?>&pagina=<?php echo $pagina;?>&codigo=<?php echo $tupla['Codigo'];?>" class="modal-close white-text waves-effect waves-light btn-flat">Confirmar</a>
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
                                <td></td><td></td><td></td><td></td><td></td>
                                <td>
                                    <a class="modal-trigger adicionar" href="#adicionar"><i class="material-icons">add_circle</i></a>
                                    <div id="adicionar" class="modal modal-fixed-footer">
                                        <div class="modal-content">
                                            <!-- Formulário | Adicionar -->
                                            <form action="acao.php" method="post">
                                            <h5 class="title">Adicionar carro</h5>
                                                <div class="row">
                                                    <div class="col s12">
                                                        <div class="input-field">
                                                            <?php geradorSelect($tabelaCarro, 'PLaca_Carro', 'Placa', 'Placa', 'placaCarro'); ?>
                                                            <label>Placa do carro</label>
                                                        </div>
                                                    </div>
                                                    <div class="col s12">
                                                        <div class="input-field">
                                                            <input required id="data" name="data" type="text" class="validate" data-mask="00/00/0000">
                                                            <label for="data">Data</label>
                                                        </div>
                                                    </div>
                                                    <div class="col s12">
                                                        <div class="input-field">
                                                            <input required id="local" name="local" type="text" class="validate">
                                                            <label for="local">Local</label>
                                                        </div>
                                                    </div>
                                                    <div class="col s12">
                                                        <div class="input-field">
                                                            <textarea required id="descriacao" name="descricao" class="materialize-textarea"></textarea>
                                                            <label for="descriacao">Descrição</label>
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