
<?php
session_start(); 
if((substr_compare($_SESSION['permissao']['projeto'], '0', 0, 1)) == 0) {
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
    <title>PMA - Projetos</title>
    <link rel="icon" href="../../util/icon.png" type="image/icon type">
    <link href="../../util/styles.css" rel="stylesheet" type="text/css" />
    
    <link rel="stylesheet" href="../../util/links/bootstrap-table.min.css">
</head>

<body>
        <div class="container">
          <div class="jumbotron row">
                <div>
                    <h2>Listagem de Projetos</h2><h4><span class="badge badge-secondary">PMA - Project Management Aplication</span></h4>
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
                            <a class="dropdown-item" href="../Registro/list_registro.php">Log de registros</a>
                            <a class="dropdown-item" href="../Home/logout.php">Sair</a>
                        </div>
                    </div>
                </div>
                
          </div>
            <div style="text-align: right">
                <p>
                    <a href="create_projeto.php" class="btn btn-outline-success">Adicionar</a>
                </p>
            </div>
                <table id="table" class="table table-striped" data-toggle="table" data-search="true" data-pagination="true"
                        data-locale="pt-BR" data-sort-name="urgencia" data-sort-order="desc">
                    <thead>
                        <tr>
                            <th scope="col" data-field="id" data-sortable="true">Id</th>
                            <th scope="col" data-field="cliente" data-sortable="true">Cliente</th>
                            <th scope="col" data-field="descricao" data-sortable="true" width="135">Descrição</th>
                            <th scope="col" data-field="responsavel" data-sortable="true" width="135">Responsável</th>
                            <th scope="col" data-field="estimativa" data-sortable="true" width="135">Estimativa</th>
                            <th scope="col" data-field="urgencia" data-sortable="true" width="135">Urgência</th>
                            <th scope="col" data-field="percentual" data-sortable="true">Percentual</th>
                            <th scope="col">Detalhar</th>
                            <?php
                            if ((substr_compare($_SESSION['permissao']['projeto'], '1', 2, 1)) == 0) {
                                echo '<th scope="col">Atualizar</th>';
                            }
                            if ((substr_compare($_SESSION['permissao']['projeto'], '1', 3, 1)) == 0) {
                                echo '<th scope="col">Excluir</th>';
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        include_once '../../controller/ProjetoControle.php';
                        include_once '../../controller/ClienteControle.php';
                        include_once '../../controller/TarefaControle.php';
                        include_once '../../controller/UsuarioControle.php';

                        $projetoControle = new ProjetoControle();
                        $clienteControle = new ClienteControle();
                        $usuarioControle = new UsuarioControle();
                        $data = $projetoControle->listProjeto();
                        
                        foreach($data as $row) 
                        {
                            $cli = $clienteControle->readCliente($row['cliente_id']);
                            $user = $usuarioControle->readUsuario($row['usuario_id']);
                            
                            echo '<tr>';
			                      echo '<th scope="row">'. $row['id'] . '</th>';
                            echo '<td>'. $cli['nome'] . '</td>';
                            echo '<td>'. $row['descricao'] . '</td>';
                            echo '<td>'; if (!empty($user['usuario'])) echo $user['usuario']; echo '</td>';
                            
                            $start = new DateTime();
                            $end = new DateTime($row['data_prevista']);
                            // otherwise the  end date is excluded (bug?)
                            $end->modify('+2 day');

                            $interval = $end->diff($start);

                            // total days
                            $days = $interval->days;

                            // create an iterateable period of date (P1D equates to 1 day)
                            $period = new DatePeriod($start, new DateInterval('P1D'), $end);

                            // best stored as array, so you can add more than one
                            //$holidays = array('2012-09-07');

                            foreach($period as $dt) {
                                $curr = $dt->format('D');

                                // substract if Saturday or Sunday
                                if ($curr == 'Sun' || $curr == 'Mon') {
                                    $days--;
                                }

                                /* (optional) for the updated question
                                elseif (in_array($dt->format('Y-m-d'), $holidays)) {
                                    $days--;
                                }*/
                            }

                            if ($days < 0)
                                $days = 0;
                            else if ($start > $end)
                                $days = 0;
                            if ($days == 1) {
                                $palavra = 'dia';
                            } else {
                                $palavra = 'dias';
                            }
                            
                            echo '<td>'. $days . ' '. $palavra .'</td>';
                            
                            $tarefaControle = new TarefaControle();
                            $tarefas = $tarefaControle->list_tarefasProjeto($row['id']);

                            $peso_total = 0;
                            $peso_total_todo = 0;
                            $peso_total_doing = 0;

                            if ($tarefas) foreach($tarefas as $aux) {
                                $peso_total = $peso_total + $aux['peso'];
                                if ($aux['status'] == 'a') {
                                    $peso_total_todo = $peso_total_todo + $aux['peso'];
                                } else if ($aux['status'] == 'b') {
                                    $peso_total_doing = $peso_total_doing + $aux['peso'];
                                }

                            }
                            
                            if ($days > 0) { 
                                $palavra = number_format((($peso_total_todo + ($peso_total_doing/2)) / $days ), 2, ',', ''); 
                            } elseif (($peso_total_todo + ($peso_total_doing/2)) > 0) {
                                $palavra = 'Atrasado';
                            } else {
                                $palavra = '0';
                            }
                            
                            echo '<td>'. $palavra .'</td>';
                            echo '<td><label>'; if($peso_total != 0) { echo number_format((($peso_total - ($peso_total_todo + ($peso_total_doing/2))) / $peso_total * 100), 1, ',', ''); } else { echo 0; } echo '</label>%</td>';
                            echo ' ';
                            echo '<td width="80"><a class="btn btn-outline-secondary btn-sm" href="detail_projeto.php?id='.$row['id'].'">Detalhar</a></td>';
                            echo ' ';
                            if ((substr_compare($_SESSION['permissao']['projeto'], '1', 2, 1)) == 0) {
                                echo '<td width="80"><a class="btn btn-outline-warning btn-sm" href="update_projeto.php?id='.$row['id'].'">Atualizar</a></td>';
                            }
                            echo ' ';
                            if ((substr_compare($_SESSION['permissao']['projeto'], '1', 3, 1)) == 0) {
                                echo '<td width="80"><a class="btn btn-outline-danger btn-sm" href="delete_projeto.php?id='.$row['id'].'">Excluir</a></td>';
                            }
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