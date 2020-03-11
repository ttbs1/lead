<?php

session_start(); 
if((substr_compare($_SESSION['permissao']['tarefa'], '0', 0, 1)) == 0) {
    header("Location: ../Erro/permissao.php");
}

    
include_once '../../controller/ProjetoControle.php';
include_once '../../controller/ClienteControle.php';
include_once '../../controller/TarefaControle.php';
include_once '../../controller/IteracaoControle.php';
include_once '../../controller/UsuarioControle.php';


?>

<html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>PMA - <?php echo $_SESSION['usuario'] ?></title>
        <link rel="icon" href="../../util/icon.png" type="image/icon type">
        
        
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../../util/links/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        
        <link href="../../util/projectTable.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="../../util/styles.css">
        <link rel="stylesheet" href="../../util/kanban.css">

    </head>
    <body>
        <div class="container">
            <div class="jumbotron row">
                <div>
                    <h2>Minhas Tarefas</h2><h4><span class="badge badge-secondary">PMA - Project Management Aplication</span></h4>
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
            <div class="span10 offset1">
                
                
                <?php 
                
                echo '<input type="hidden" id="admin" value="n" />';

                $tarefaControle = new TarefaControle();
                $tarefas = $tarefaControle->list_tarefasUsuario($_SESSION['usuario_id']);

                ?>
                
                
            
                
                <div class="card" style="overflow: auto;">
                    <div class="card-header">
                        <h3 class="well">Kanban de Tarefas</h3> 
                    </div>

                    <div class="scrumboard">
                        <div class="row">
                                    <div class="header">
                                        <h5>Em andamento</h5>
                                    </div>
                                    <div class="header">
                                        <h5>Concluído</h5>
                                    </div>
                        </div>
                        <div class="row">
                                    <div class="column flex" id="b">
                                      <!-- ongoing -->


                                            <?php 

                                            $projetoControle = new ProjetoControle();
                                            $clienteControle = new ClienteControle();

                                            if($tarefas) foreach ($tarefas as $row) {
                                                if ($row['status'] == 'b') {
                                                    $projeto = $projetoControle->readProjeto($row['projeto_id']);
                                                    if($projeto['ativo']) {
                                                        $cli = $clienteControle->readCliente($projeto['cliente_id']);
                                                        echo '<div class="portlet">';
                                                            echo '<input type="hidden" class="tarefa_id" value="'.$row['id'].'">';
                                                            echo '';
                                                            echo '<div class="portlet-header">Peso: '.$row['peso'].'</div>';
                                                            echo '<div class="portlet-content">'.$row['descricao'].'</div>';
                                                            echo '<div class="portlet-footer">'. $cli['nome'].'<br>'.$projeto['descricao'].'</div>';
                                                            echo '<div class="portlet-footer"><a class="portlet-icon" href="../Tarefa/update_tarefa.php?id='.$row['id'].'&projeto_id='.$projeto['id'].'"><i class="fas fa-edit"></i></a> <a class="portlet-icon" href="../Tarefa/delete_tarefa.php?id='.$row['id'].'&projeto_id='.$projeto['id'].'"><i class="fas fa-trash"></i></a></div>';
                                                        echo '</div>';
                                                    }
                                                }
                                            }

                                            ?>

                                    </div>
                                    <div class="column flex" id="c">
                                       <!-- done -->


                                            

                                    </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <a href="../Home/home.php" type="btn" class="btn btn-default">Menu Principal</a>
                        <a href="../Projeto/list_projeto.php" type="btn" class="btn btn-default">Listar Projetos</a>
                    </div>
                </div>
            </div>
        </div>
        
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Atualizar tarefa: </h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        Tem certeza que deseja atualizar o status da tarefa?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                      <button type="button" class="btn btn-primary" id="confirmar">Confirmar</button>
                    </div>
                  </div>
                </div>
            </div>
        
        <script src="../../util/links/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="../../util/links/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="../../util/links/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script type="text/javascript" src="../../util/links/jquery-ui.js"></script>
        <script src="../../util/links/c0930358e4.js" crossorigin="anonymous"></script>
        <script src="../../util/kanban2.js"></script>
        <p></p>
    </body>
</html>