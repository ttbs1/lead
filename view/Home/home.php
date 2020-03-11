
<?php
session_start();

if (isset($_SESSION['usuario_id'])) {
    include_once '../../controller/UsuarioControle.php';
    include_once '../../controller/PermissaoControle.php';
    $usuarioControle = new UsuarioControle();
    $user = $usuarioControle->readUsuario($_SESSION['usuario_id']);
    $permissaoControle = new PermissaoControle();
    $permissoes = $permissaoControle->readPermissao($user['permissao_id']);

    $_SESSION['usuario'] = $user['usuario'];
    $_SESSION['permissao'] = $permissoes;
} else {
    header("Location: ../login/login.php");
}

if((substr_compare($_SESSION['permissao']['campanha'], '0', 0, 1)) == 0) {
    header("Location: ../Erro/permissao.php");
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../util/links/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>PMA - Campanhas</title>
    <link rel="icon" href="../../util/icon.png" type="image/icon type">
    <link href="../../util/styles.css" rel="stylesheet" type="text/css" />
    
    <link rel="stylesheet" href="../../util/links/bootstrap-table.min.css">
</head>

<body>
        <div class="container">
          <div class="jumbotron row">
                <div>
                    <h2>Listagem de Campanhas</h2><h4><span class="badge badge-secondary">PMA - Project Management Aplication</span></h4>
                </div>
                
                <div class="header-user">
                    <div class="dropdown show">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="../../util/user.png" width="30px" height="30px">
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="#"><?php
                                                                    if(isset($_SESSION['usuario'])) {
                                                                        echo 'Usuário: '. $_SESSION['usuario'];
                                                                    } else {
                                                                        header("Location: ../login/login.php");
                                                                    } ?></a>
                            <!--<a class="dropdown-item" href="../Registro/list_registro.php">Log de registros</a>-->
                            <a class="dropdown-item" href="../Home/logout.php">Sair</a>
                        </div>
                    </div>
                </div>
                
          </div>
            <div style="text-align: right">
                <p>
                    <a href="create_campanha.php" class="btn btn-outline-success">Adicionar</a>
                </p>
            </div>
                <table id="table" class="table table-striped" data-toggle="table" data-search="true" data-pagination="true"
                        data-locale="pt-BR" data-sort-name="urgencia" data-sort-order="desc">
                    <thead>
                        <tr>
                            <th scope="col" data-field="descricao" data-sortable="true">Descrição</th>
                            <th scope="col" data-field="cidade" data-sortable="true">cidade</th>
                            <th scope="col">Detalhar</th>
                            <?php
                            if ((substr_compare($_SESSION['permissao']['campanha'], '1', 2, 1)) == 0) {
                                echo '<th scope="col">Atualizar</th>';
                            }
                            if ((substr_compare($_SESSION['permissao']['campanha'], '1', 3, 1)) == 0) {
                                echo '<th scope="col">Excluir</th>';
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        include_once '../../controller/CampanhaControle.php';
                        include_once '../../controller/UsuarioControle.php';

                        $campanhaControle = new CampanhaControle();
                        $usuarioControle = new UsuarioControle();
                        $data = $campanhaControle->listCampanha();
                        
                        if ($data) foreach($data as $row) 
                        {
                            
                            echo '<tr>';
                            echo '<td>'. $row['descricao'] . '</td>';
                            echo '<td>'. $row['cidade'] . '</td>';
                            echo '<td width="80"><a class="btn btn-outline-secondary btn-sm" href="update_projeto.php?id='.$row['id'].'">Inscritos</a></td>';
                            if ((substr_compare($_SESSION['permissao']['campanha'], '1', 2, 1)) == 0) {
                                echo '<td width="80"><a class="btn btn-outline-warning btn-sm" href="update_projeto.php?id='.$row['id'].'">Atualizar</a></td>';
                            }
                            echo ' ';
                            if ((substr_compare($_SESSION['permissao']['campanha'], '1', 3, 1)) == 0) {
                                echo '<td width="80"><a class="btn btn-outline-danger btn-sm" href="delete_projeto.php?id='.$row['id'].'">Excluir</a></td>';
                            }
                            echo ' ';
                            echo '</tr>';
                        }
                        
                            echo '</tbody>';
                        echo '</table>';
                        
                        
                        ?>
                    
                    
                        
                    <!--<a href="../Home/home.php" type="btn" class="btn btn-default">Menu Principal</a>-->
        </div>
    
    <script src="../../util/links/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="../../util/links/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="../../util/links/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="../../util/links/bootstrap-table.min.js"></script>
    <script src="../../util/links/bootstrap-table-locale-all.min.js"></script>
    
</body>

</html>