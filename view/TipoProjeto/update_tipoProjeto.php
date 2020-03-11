<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
session_start(); 
if((substr_compare($_SESSION['permissao']['tipoprojeto'], '0', 2, 1)) == 0) {
    header("Location: ../Erro/permissao.php");
}
?>

<html>
    <head>
        <title>PMA - Atualizar Modelo</title>
        <link rel="icon" href="../../util/icon.png" type="image/icon type">
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../../util/links/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        
        <script src="../../util/SpryValidationTextField.js" type="text/javascript"></script> 
        <link href="../../util/SpryValid.css" rel="stylesheet" type="text/css" />
        <link href="../../util/sizes.css" rel="stylesheet" type="text/css" />
        <link href="../../util/styles.css" rel="stylesheet" type="text/css" />
        <script src="../../util/links/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="../../util/links/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="../../util/links/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php
        
            include '../../domain/TipoProjeto.php';
            include '../../domain/endereco.php';
            include '../../controller/TipoProjetoControle.php';
            include '../../controller/enderecocontrole.php';
            
            
	if ( !empty($_GET['id']))
            {
		$id = $_REQUEST['id'];
            }
	if (!empty($_POST)) {
            $tipoProjeto = new TipoProjeto();
            $id = ($_POST['id']);
            $tipoProjeto->setDescricao($_POST['descricao']);
            
            $tipoProjetoControle = new TipoProjetoControle();
            $try = $tipoProjetoControle->updateTipoProjeto($tipoProjeto, $id);
            
            
	} else {
            $tipoProjetoControle = new TipoProjetoControle();
            $data = $tipoProjetoControle->readTipoProjeto($id);
	}
	
    ?>
        <div class="container">
            <div class="jumbotron row">
                <div>
                    <h2>Atualização de Modelos</h2><h4><span class="badge badge-secondary">PMA - Project Management Aplication</span></h4>
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
            
            <div class="card">
            <div class="card-header">
                <h3 class="well"> Atualizar Modelo </h3>
            </div>
                <div class="card-body">
            
                    <form class="form-horizontal" action="update_tipoProjeto.php" method="post">
                    <fieldset>
                            <legend>Modelo</legend>

                            <input type="hidden" name="id" id="id" placeholder="id" value="<?php echo $id ?>" />

                            <div class="form-group col-md-8">
                                <label for="descricao">Descrição: </label><br>
                                    <span id="descricao1" class="textfieldHintState">
                                        <input type="text" class="form-control" name="descricao" id="descricao" placeholder="Descrição" value="<?php if(empty($_POST)) echo $data['descricao']; else echo $tipoProjeto->getDescricao(); ?>" />
                                        <span class="textfieldMaxCharsMsg">Esse campo tem limite de 85 caracteres.</span>
                                        <span class="textfieldRequiredMsg">Esse campo é obrigatório</span>
                                    </span>
                            </div>
                            <script>
                                var user = new Spry.Widget.ValidationTextField("descricao", "custom", {validateOn:["blur"], maxChars: 85});
                            </script>




                            </fieldset>



                            <div class="control-group">
                                    <label class="control-label">Tarefa(s):</label>
                                    <div class="controls">
                                        <label class="carousel-inner">
                                <?php

                                    echo '<table class="table table-striped">';
                                            echo '<thead>';
                                                echo '<tr>';
                                                    echo '<th scope="col"></th>';
                                                    echo '<th scope="col">Descrição</th>';
                                                    echo '<th scope="col">Peso</th>';
                                                    echo '<th scope="col">Opções</th>';
                                                echo '</tr>';
                                            echo '</thead>';

                                    include_once '../../controller/TarefaControle.php';
                                    $tarefaControle = new TarefaControle();
                                    $data_fk = $tarefaControle->list_tarefasTipoProjeto($id);
                                    if ($data_fk != NULL) {
                                        foreach($data_fk as $row) {

                                            echo '<tbody>';
                                                echo '<tr>';
                                                                  echo '<th scope="row">'. $row['id'] . '</th>';
                                                echo '<td>'. $row['descricao'] . '</td>';
                                                echo '<td>'. $row['peso'] . '</td>';
                                                echo '<td width=250>';
                                                echo '<a class="btn btn-outline-warning" href="../Tarefa/update_tarefa.php?id='.$row['id'].'&modelo_id='.$id.'">Atualizar</a>';
                                                echo ' ';
                                                echo '<a class="btn btn-outline-danger" href="../Tarefa/delete_tarefa.php?id='.$row['id'].'&modelo_id='.$id.'">Excluir</a>';
                                                echo '</td>';
                                                echo '</tr>';        
                                            echo '</tbody>';

                                        }
                                    }


                                        echo '</table>';

                                ?>
                                        </label>
                                <div class="form-actions" align="right">
                                    <?php echo '<a class="btn btn-default" href="../Tarefa/create_tarefa.php?tipoTarefa_id='.$id.'">Adicionar Tarefa</a>' ?>
                                </div>

                                <br/>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success">Atualizar</button>
                                    <a href="detail_tipoProjeto.php?id=<?php echo $id; ?>" type="btn" class="btn btn-default">Voltar</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        
        if(!empty($_POST))
            if(!empty ($try))
                echo '<script> 
                    $(document).ready(function() {
                        $("#errorModal").modal("toggle");
                    });
                </script>';
            else 
                echo '<script> 
                    $(document).ready(function() {
                        $("#confirmModal").modal().on("hidden.bs.modal", function (e) {
                            window.location.href = "list_tipoProjeto.php";
                        });
                        $("#confirmModal").modal("toggle");
                    });
                </script>';
        
        ?>
        
        <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Erro: </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="form-group col-md-12">
                      <label for="erro">Erro na inserção de dados: </label><br>
                            <?php 
                            
                            if (strpos($try, 'Duplicate')) {

                            if (strpos($try, "'descricao'"))
                                echo 'Já existe um modelo cadastrado com esse nome, e não pode ser cadastrado em duplicidade. Em caso de dúvidas, entre em contato com o suporte.';

                            } else { echo $try; }
                            
                            ?>
                    </div>
                    <div style="text-align: center;"><img src="../../util/suporte-tecnico.png" height="250px" width="250px" /></div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                  <!--<button type="button" class="btn btn-primary" id="designar">Salvar</button>-->
                </div>
              </div>
            </div>
        </div>
        
        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Dados atualizados: </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="form-group col-md-8">
                            O modelo de projeto foi atualizado com sucesso!
                    </div>
                    <div style="text-align: center;"><img src="../../util/update.png" height="175px" width="175px" /></div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                </div>
              </div>
            </div>
        </div>
        
        <p></p>
    </body>
</html>
