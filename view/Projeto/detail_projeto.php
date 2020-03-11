<?php

session_start(); 
if((substr_compare($_SESSION['permissao']['projeto'], '0', 0, 1)) == 0) {
    header("Location: ../Erro/permissao.php");
}

include_once '../../controller/ProjetoControle.php';
include_once '../../controller/ClienteControle.php';
include_once '../../controller/TarefaControle.php';
include_once '../../controller/IteracaoControle.php';
include_once '../../controller/UsuarioControle.php';

if(!empty($_GET['id']))
{
    $id = $_REQUEST['id'];
    
    $projetoControle = new ProjetoControle();
    $data = $projetoControle->readProjeto($id);
    $clienteControle = new ClienteControle();
    $cliente = $clienteControle->readCliente($data['cliente_id']);
}

?>

<html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../../util/links/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <title>PMA - Detalhar Projeto</title>
        <link rel="icon" href="../../util/icon.png" type="image/icon type">
        <link href="../../util/projectTable.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="../../util/styles.css">
        <link rel="stylesheet" href="../../util/kanban.css">

    </head>
    <body>
        <div class="container">
            <div class="jumbotron row">
                <div>
                    <h2>Detalhamento do Projeto</h2><h4><span class="badge badge-secondary">PMA - Project Management Aplication</span></h4>
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
                <div class="pbuttons" align="right" style="padding-bottom: 15px;">
                        <?php

                            echo ' ';
                            echo '<a class="btn btn-outline-warning" href="update_projeto.php?id='.$data['id'].'">Atualizar</a>';
                            echo ' ';
                            echo '<a class="btn btn-outline-danger" href="delete_projeto.php?id='.$data['id'].'">Excluir</a>';

                        ?>
                </div>
                
                <?php 

                $permissoes = $_SESSION['permissao'];
                if ($permissoes['adm']) {
                    echo '<input type="hidden" id="admin" value="s" />';
                } else {
                    echo '<input type="hidden" id="admin" value="n" />';
                }
                
                $tarefaControle = new TarefaControle();
                $tarefas = $tarefaControle->list_tarefasProjeto($data['id']);

                $peso_total = 0;
                $peso_total_todo = 0;
                $peso_total_doing = 0;

                if ($tarefas) foreach($tarefas as $row) {
                    $peso_total = $peso_total + $row['peso'];
                    if ($row['status'] == 'a') {
                        $peso_total_todo = $peso_total_todo + $row['peso'];
                    } else if ($row['status'] == 'b') {
                        $peso_total_doing = $peso_total_doing + $row['peso'];
                    }
                        
                }

                ?>
                
                <div class="row" style="width: 100%; height: 25px; margin: 0px 0px 8px 8px"> 
                    
                    <?php 
                    if ($tarefas) foreach($tarefas as $row) {
                        if ($row['status'] == 'a') { $cor = 'rgb(250,128,114)'; } elseif ($row['status'] == 'b') { $cor = 'rgb(255,247,190)'; } elseif ($row['status'] == 'c') { $cor = 'rgb(40,180,50)';}
                        echo '<div style="width: '.floor((($row['peso']/$peso_total)*100)-1) .'%; height: 25px; margin-right: 4px; background-color: '. $cor .'"></div>';
                    }
                    ?>
                    
                </div>
            
                <div class="card">
                    <div class="card-header">
                        <h3 class="well">Informações do Projeto</h3> 
                    </div>
                    <div class="container info-detail" style="padding: 15px;">
                        <div class="form-horizontal">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="control-group">
                                        <label class="control-label">Cliente: </label>
                                        <div class="controls">
                                            <label class="carousel-inner">
                                                <?php echo $cliente['nome']; ?>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Descrição: </label>
                                        <div class="controls">
                                            <label class="carousel-inner">
                                                <?php echo $data['descricao']; ?>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <label class="control-label">Tempo decorrido: </label>
                                        <div class="controls">
                                            <label class="carousel-inner">
                                                <?php //DIA QUE FOI CADASTRADO NÃO ENTRA
                                                $start = new DateTime($data['data_entrada']);
                                                $end = new DateTime();
                                                // otherwise the  end date is excluded (bug?)
                                                $end->modify('+0 day');

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
                                                    if ($curr == 'Sat' || $curr == 'Sun') {
                                                        $days--;
                                                    }

                                                    /* (optional) for the updated question
                                                    elseif (in_array($dt->format('Y-m-d'), $holidays)) {
                                                        $days--;
                                                    }*/
                                                }

                                                if ($days < 0)
                                                    $days = 0;
                                                echo $days . ' dia(s)';
                                                ?>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Tempo restante: </label>
                                        <div class="controls">
                                            <label class="carousel-inner">
                                                <?php //DIA ATUAL CONTA COMO DIA DE TRABALHO

                                                $start = new DateTime();
                                                $end = new DateTime($data['data_prevista']);
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
                                                echo $days . ' dia(s)';

                                                ?> <img name="info" id="info" class="info" src="https://cdn.pixabay.com/photo/2012/04/02/17/46/signs-25066_960_720.png" alt="A contagem considera o dia atual como dia de trabalho, exceto para fins de semana!" title="A contagem considera o dia atual como dia de trabalho, exceto para fins de semana!" width="13px" height="13px">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Entrega: </label>
                                        <div class="controls">
                                            <label class="carousel-inner">
                                                <?php 
                                                
                                                $entrega = new DateTime($data['data_prevista']);
                                                
                                                
                                                echo $entrega->format('d/m/Y'); ?>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <label class="control-label">Responsável: </label>
                                        <div class="controls">
                                            <label class="carousel-inner">
                                                <?php 
                                                
                                                $usuarioControle = new UsuarioControle();
                                                $user = $usuarioControle->readUsuario($data['usuario_id']);
                                                
                                                if (!empty($user['usuario']))
                                                    echo ($user['usuario']); 
                                                else 
                                                    echo 'Não designado';
                                                ?>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <label class="control-label">Valor: </label>
                                        <div class="controls">
                                            <label class="carousel-inner">
                                                <?php echo 'R$ '. $data['valor']; ?>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <label class="control-label">Coeficiente de urgência: </label>
                                        <div class="controls">
                                            <label class="carousel-inner">
                                                <?php 
                                                
                                                if ($days > 0) { 
                                                    $coef = number_format((($peso_total_todo + ($peso_total_doing/2)) / $days ), 2, ',', ''); 
                                                } elseif (($peso_total_todo + ($peso_total_doing/2)) > 0) {
                                                    $coef = 'Atrasado';
                                                } else {
                                                    $coef = '0';
                                                }
                                                
                                                echo $coef ?>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <label class="control-label">Percentual de conclusão: </label>
                                        <div class="controls">
                                            <label class="carousel-inner">
                                                <?php if($peso_total != 0) { echo number_format((($peso_total - ($peso_total_todo + ($peso_total_doing/2))) / $peso_total * 100), 1, ',', '')  .'%'; } 
                                                    else { echo '0%'; } ?>
                                            </label>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="card" style="margin-bottom: 1em">
                                        <div class="card-header">
                                            <h4 class="well" >Observações e comentários </h4> 
                                        </div>
                                        <div class="container" style="padding: 15px; min-height: 15em">
                                                        
                                            <?php 

                                            $iteracaoControle = new IteracaoControle();
                                            $iteracoes = $iteracaoControle->list_iteracoesProjeto($data['id']);

                                            if($iteracoes) foreach ($iteracoes as $row) {
                                                $usuario = $usuarioControle->readUsuario($row['usuario_id']);
                                                $datahora = new DateTime($row['datahora']);
                                                echo '<div class="iteration">';
                                                    echo '<input type="hidden" class="iteracao_id" value="'.$row['id'].'">';
                                                    echo '<div class="iteration-content">'.$row['descricao'].'</div>';
                                                    echo '<div class="" style="text-align: right; font-size: smaller">'.$usuario['usuario'].' às '.$datahora->format('H:i:s').' em '.$datahora->format('d/m/Y').'</div>';
                                                    
                                                    if (($usuario['usuario'] == $_SESSION['usuario']) || ($_SESSION["permissao"]['adm'])) {
                                                        echo '<div style="text-align: right;">';
                                                        echo '<a href="../Iteracao/update_iteracao.php?id='.$row['id'].'&projeto='.$data['id'].'" style="font-size: smaller">Atualizar</a> <a href="../Iteracao/delete_iteracao.php?id='.$row['id'].'&projeto='.$data['id'].'" style="font-size: smaller">Excluir</a>';
                                                        echo '</div>';
                                                    }
                                                echo '</div>';
                                            }

                                            ?>
                                            <div class="form-actions" align="right">
                                                <?php echo '<a class="btn btn-default" href="../Iteracao/create_iteracao.php?id='.$data['id'].'">Novo comentário</a>' ?>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                                <div class="card" style="width: 95%; margin-left: 2.5%; overflow: auto;">
                                <div class="card-header">
                                    <h3 class="well">Kanban de Tarefas</h3> 
                                </div>
                                
                                <div class="scrumboard">
                                    <div class="row">
                                                <div class="header">
                                                    <h5>A fazer</h5>
                                                </div>
                                                
                                                <div class="header">
                                                    <h5>Em andamento</h5>
                                                </div>
                                                
                                                <div class="header">
                                                    <h5>Concluído</h5>
                                                </div>
                                    </div>
                                    
                                    <div class="row">
                                                <div class="column flex" id="a">
                                                 <!-- todo -->


                                                        <?php 

                                                        if($tarefas) foreach ($tarefas as $row) {
                                                            if ($row['status'] == 'a') {
                                                                echo '<div class="portlet">';
                                                                    echo '<input type="hidden" class="tarefa_id" value="'.$row['id'].'">';
                                                                    echo '';
                                                                    echo '<div class="portlet-header">Peso: '.$row['peso'].'</div>';
                                                                    echo '<div class="portlet-content">'.$row['descricao'].'</div>';
                                                                    echo '<div class="portlet-footer"><a class="portlet-icon" href="../Tarefa/update_tarefa.php?id='.$row['id'].'&projeto_id='.$data['id'].'"><i class="fas fa-edit"></i></a> <a class="portlet-icon" href="../Tarefa/delete_tarefa.php?id='.$row['id'].'&projeto_id='.$data['id'].'"><i class="fas fa-trash"></i></a></div>';
                                                                echo '</div>';
                                                            }
                                                        }

                                                        ?>
                                                </div>
                                                
                                                <div class="column flex" id="b">
                                                  <!-- ongoing -->


                                                        <?php 

                                                        if($tarefas) foreach ($tarefas as $row) {
                                                            if ($row['status'] == 'b') {
                                                                $temp = $usuarioControle->readUsuario($row['usuario_id']);
                                                                echo '<div class="portlet">';
                                                                    echo '<input type="hidden" class="tarefa_id" value="'.$row['id'].'">';
                                                                    echo '';
                                                                    echo '<div class="portlet-header">Peso: '.$row['peso'].'</div>';
                                                                    echo '<div class="portlet-content">'.$row['descricao'].'</div>';
                                                                    echo '<div class="portlet-footer">'.$temp['usuario'].'</div>';
                                                                    echo '<div class="portlet-footer"><a class="portlet-icon" href="../Tarefa/update_tarefa.php?id='.$row['id'].'&projeto_id='.$data['id'].'"><i class="fas fa-edit"></i></a> <a class="portlet-icon" href="../Tarefa/delete_tarefa.php?id='.$row['id'].'&projeto_id='.$data['id'].'"><i class="fas fa-trash"></i></a></div>';
                                                                echo '</div>';
                                                            }
                                                        }

                                                        ?>

                                                </div>
                                                
                                                <div class="column flex" id="c">
                                                   <!-- done -->


                                                        <?php 

                                                        if($tarefas) foreach ($tarefas as $row) {
                                                            if ($row['status'] == 'c') {
                                                                $temp = $usuarioControle->readUsuario($row['usuario_id']);
                                                                echo '<div class="portlet">';
                                                                    echo '<input type="hidden" class="tarefa_id" value="'.$row['id'].'">';
                                                                    echo '';
                                                                    echo '<div class="portlet-header">Peso: '.$row['peso'].'</div>';
                                                                    echo '<div class="portlet-content">'.$row['descricao'].'</div>';
                                                                    echo '<div class="portlet-footer">'.$temp['usuario'].'</div>';
                                                                    echo '<div class="portlet-footer"><a class="portlet-icon" href="../Tarefa/update_tarefa.php?id='.$row['id'].'&projeto_id='.$data['id'].'"><i class="fas fa-edit"></i></a> <a class="portlet-icon" href="../Tarefa/delete_tarefa.php?id='.$row['id'].'&projeto_id='.$data['id'].'"><i class="fas fa-trash"></i></a></div>';
                                                                echo '</div>';
                                                            }
                                                        }

                                                        ?>

                                                </div>
                                    </div>
                                </div>
                                    
                                    <div class="form-actions" align="right">
                                        <?php echo '<a class="btn btn-default" href="../Tarefa/create_tarefa.php?projeto_id='.$data['id'].'">Adicionar Tarefa</a>' ?>
                                    </div>
                                    
                                </div>



                            
                        </div>
                    </div>
                    
                    
                    
                    <div class="form-actions">
                        <a href="../Home/home.php" type="btn" class="btn btn-default">Menu Principal</a>
                        <a href="list_projeto.php" type="btn" class="btn btn-default">Voltar</a>
                        <form action="contrato.php" method="post" target="_blank">
                            <input type="hidden" name="contrato_cliente" value="<?php echo $cliente['nome'] ?>" />
                            <input type="hidden" name="contrato_valor" value="<?php echo $data['valor'] ?>" />
                            
                            <button type="submit" class="btn btn-default">Gerar Contrato</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Designar tarefa: </h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group col-md-8">
                          <label for="responsavel">Usuário responsável: </label><br>
                          <select class="form-control" name="usuario" id="usuario">
                                <option></option>
                                <?php
                                    include_once '../../controller/UsuarioControle.php';

                                    $data_fk2 = $usuarioControle->listUsuario();
                                    foreach($data_fk2 as $row) 
                                    {
                                        echo '<option>'.$row['usuario'].'</option>';
                                    }
                                ?>
                          </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                      <button type="button" class="btn btn-primary" id="designar">Salvar</button>
                    </div>
                  </div>
                </div>
            </div>
        
        <script src="../../util/links/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="../../util/links/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="../../util/links/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script type="text/javascript" src="../../util/links/jquery-ui.js"></script>
        <script src="../../util/links/c0930358e4.js" crossorigin="anonymous"></script>
        <script src="../../util/kanban.js"></script>
        <p></p>
    </body>
</html>