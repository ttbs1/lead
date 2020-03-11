<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../util/links/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>PMA - Registros</title>
    <link rel="icon" href="../../util/icon.png" type="image/icon type">
    <link href="../../util/styles.css" rel="stylesheet" type="text/css" />
    
    <link rel="stylesheet" href="../../util/links/bootstrap-table.min.css">
</head>

<body>
        <div class="container">
          <div class="jumbotron row">
                <div>
                    <h2>Listagem de Registros</h2><h4><span class="badge badge-secondary">PMA - Project Management Aplication</span></h4>
                </div>
                
                <div class="header-user">
                    <div class="dropdown show">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="../../util/user.png" width="30px" height="30px">
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="#"><?php session_start(); 
                                                                    if(isset($_SESSION['usuario'])) {
                                                                        echo 'Usuário: '. $_SESSION['usuario'];
                                                                    } else {
                                                                        header("Location: ../login/login.php");
                                                                    } ?></a>
                            <a class="dropdown-item" href="#">Log de registros</a>
                            <a class="dropdown-item" href="../Home/logout.php">Sair</a>
                        </div>
                    </div>
                </div>
                
          </div>
                <table id="table" class="table table-striped" data-toggle="table" data-search="true" data-pagination="true"
                        data-locale="pt-BR" data-sort-name="id" data-sort-order="desc">
                    <thead>
                        <tr>
                            <th scope="col" data-field="id" data-sortable="true">Id</th>
                            <th scope="col" data-field="usuario" data-sortable="true">Usuário</th>
                            <th scope="col" data-field="acao" data-sortable="true" width="135">Ação</th>
                            <th scope="col" data-field="tabela" data-sortable="true" width="135">Tabela</th>
                            <th scope="col" data-field="identificacao" data-sortable="true" width="135">Identificação</th>
                            <th scope="col" data-field="datahora" data-sortable="true" width="135">Data/Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        include_once '../../controller/RegistroControle.php';
                        include_once '../../controller/UsuarioControle.php';

                        $registroControle = new RegistroControle();
                        $usuarioControle = new UsuarioControle();
                        
                        $permissoes = $_SESSION['permissao'];
                        if ($permissoes['adm']) {
                            $data = $registroControle->list_Registros();
                        } else {
                            $data = $registroControle->list_RegistrosUsuario();
                        }
                        
                        foreach($data as $row) 
                        {
                            $user = $usuarioControle->readUsuario($row['usuario_id']);
                            
                            echo '<tr>';
			                      echo '<th scope="row">'. $row['id'] . '</th>';
                            echo '<td>'. $user['usuario'] . '</td>';
                            echo '<td>'. $row['acao'] . '</td>';
                            echo '<td>'. $row['tabela'] . '</td>';
                            echo '<td>'. $row['identificacao'] . '</td>';
                            
                            $date = new DateTime($row['datahora']);
                            
                            echo '<td>'. $date->format('d/m/Y H:i:s') . '</td>';
                            
                            echo ' ';
                            echo '</tr>';
                        }
                        
                            echo '</tbody>';
                        echo '</table>';
                        
                        
                        ?>
                    
                    
                        
                    <a href="../Home/home.php" type="btn" class="btn btn-default">Menu Principal</a>
        </div>
    <script src="../../util/links/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="../../util/links/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="../../util/links/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="../../util/links/bootstrap-table.min.js"></script>
    <script src="../../util/links/bootstrap-table-locale-all.min.js"></script>
</body>

</html>