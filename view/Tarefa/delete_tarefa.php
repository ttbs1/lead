
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../util/links/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>PMA - Excluir Tarefa</title>
    <link rel="icon" href="../../util/icon.png" type="image/icon type">
    <link href="../../util/aligns.css" rel="stylesheet" type="text/css" />
    <link href="../../util/styles.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="container">
        <div class="jumbotron row">
            <div>
                <h2>Exclusão de Tarefas</h2><h4><span class="badge badge-secondary">PMA - Project Management Aplication</span></h4>
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
                        <a class="dropdown-item" href="../Registro/list_registro.php">Log de registros</a>
                        <a class="dropdown-item" href="../Home/logout.php">Sair</a>
                    </div>
                </div>
            </div>
        </div>
        
        
        <?php

        include_once '../../controller/TarefaControle.php';

        if(!empty($_GET['id']))
        {
            $id = $_REQUEST['id'];
        }
        if(!empty($_POST))
        {
            $id = $_POST['id'];

            //Delete do banco:
            $tarefaControle = new TarefaControle();
            $try = $tarefaControle->deleteTarefa($id);
            
        }
        ?>
        
        
        <div class="span10 offset1">
            <div class="row">
                <h3 class="well" id="plabel">Excluir Tarefa</h3>
            </div>
            <form class="form-horizontal" action="delete_tarefa.php" method="post">
                <input type="hidden" name="id" value="<?php echo $id;?>" />
                <div class="alert alert-danger"> Deseja confirmar a exclusão da tarefa?
                </div>
                <div class="form actions">
                    <button type="submit" class="btn btn-danger">Sim</button>
                    <a href="#" type="btn" class="btn btn-default" onclick="goBack();">Não</a>
                    <script>
                        function goBack () {
                            window.history.back();
                        }
                    </script>
                </div>
            </form>
        </div>
    </div>
    <script src="../../util/links/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="../../util/links/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="../../util/links/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

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
                        window.history.go(-2);
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

                        { echo $try; }

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
              <h5 class="modal-title" id="exampleModalLongTitle">Dados apagados: </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group col-md-8">
                        A tarefa foi excluída com sucesso!
                </div>
                <div style="text-align: center;"><img src="../../util/delete.png" height="175px" width="175px" /></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
            </div>
          </div>
        </div>
    </div>

</body>

</html>