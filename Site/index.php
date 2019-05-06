<!DOCTYPE html>
<html lang="pt-br">

<!-- Inicialização do código -->
<?php

  include 'funcoes.php';
	include 'connect/connect.php';
  $nomeTabela = $tabelaCliente;

?>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Painel de controle - Sicherheit</title>

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
              <li><a class="active" href="index.php">Painel de controle</a></li>
              <li><a href="clientes.php">Clientes</a></li>
              <li><a href="carros.php">Carros</a></li>
              <li><a href="ocorrencias.php">Ocorrências</a></li>
            </ul>
          </div>
        </nav>
      </div>

      <!-- Sidenav mobile -->
      <ul class="sidenav" id="mobile-sidenav">
        <li><a class="active" href="index.php"><i class="material-icons">dashboard</i>Painel de controle</a></li>
        <li><a href="clientes.php"><i class="material-icons">assignment_ind</i>Clientes</a></li>
        <li><a href="carros.php"><i class="material-icons">directions_car</i>Carros</a></li>
        <li><a href="ocorrencias.php"><i class="material-icons">commute</i>Ocorrências</a></li>
      </ul>

  </header>
  <main style="margin-top: 2.5rem;">

    <!-- Cartões de informação geral -->
    <div class="section">

        <div class="row">
          <!-- Cartão clientes -->
          <div class="col s12 m6 l4">
            <a href="clientes.php">
              <div class="card-panel gradient-green hoverable white-text">
                <h5 class="left-align title">Clientes</h5>
                <h6 class="left title"><?php echo countSQL($tabelaCliente, 'RG'); ?></h6>
                <h5 class="right-align"><i class="material-icons card-icon">assignment_ind</i></h5>
              </div>
            </a>
          </div>

          <!-- Cartão carros -->
          <div class="col s12 m6 l4">
            <a href="carros.php">
              <div class="card-panel gradient-red hoverable white-text">
                <h5 class="left-align title">Carros</h5>
                <h6 class="left title"><?php echo countSQL($tabelaCarro, 'Placa'); ?></h6>
                <h5 class="right-align"><i class="material-icons card-icon">directions_car</i></h5>
              </div>
            </a>
          </div>

          <!-- Cartão ocorrências -->
          <div class="col s12 m6 offset-m3 l4">
            <a href="ocorrencias.php">
              <div class="card-panel gradient-blue hoverable white-text">
                <h5 class="left-align title">Ocorrências</h5>
                <h6 class="left title"><?php echo countSQL($tabelaOcorrencia, 'Codigo'); ?></h6>
                <h5 class="right-align"><i class="material-icons card-icon">commute</i></h5>
              </div>
            </a>
          </div>
        </div>

    </div>

    <!-- Filtros e SQL -->
    <?php

        $sql = "SELECT * FROM ". $nomeTabela;
        $resultado = mysqli_query ($conexao, $sql);

    ?>

    <div class="section">

      <div class="row">
        <div class="col s12">
          <table class="highlight centered responsive-table">
            <thead>
              <tr class="title">
                <th>Clientes</th>
                <th>RG</th>
                <th>Telefone</th>
                <th>Número de carros</th>
                <th>Número de ocorrências</th>
              </tr>
            </thead>

            <tbody>

              <?php
                while ($tupla = mysqli_fetch_array($resultado)) {
                $numeroOcorrencias = countSQLAninhado('Codigo', $tabelaOcorrencia, $tabelaCarro, 'Placa_Carro', 'RG_Cliente', 'Placa', $tupla['RG']);
                $numeroCarros = countSQLComCondicao($tabelaCarro, 'Placa', 'RG_Cliente', $tupla['RG']);
              ?>
              <tr>
                <td><?php echo $tupla['Nome']; ?></td>
                <td><?php echo $tupla['RG']; ?></td>
                <td><?php echo $tupla['Telefone']; ?></td>
                <td><?php echo $numeroCarros > 0 ? $numeroCarros : 0; ?></td>
                <td><?php echo $numeroOcorrencias > 0 ? $numeroOcorrencias : 0 ; ?></td>
              </tr>
              <?php } ?>
              
            </tbody>
          </table>
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

  </body>

</html>
