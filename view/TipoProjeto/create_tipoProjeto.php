<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start(); 
if((substr_compare($_SESSION['permissao']['tipoprojeto'], '0', 1, 1)) == 0) {
    header("Location: ../Erro/permissao.php");
}

if(!empty($_POST)) {
    include_once '../../domain/tipoProjeto.php';
    include_once '../../controller/TipoProjetoControle.php';
    $tipoProjeto = new TipoProjeto();
    $tipoProjeto->setDescricao($_POST['descricao']);
    
    
    $tipoProjetoControle = new TipoProjetoControle();
    $try = $tipoProjetoControle->inserirTipoProjeto($tipoProjeto);
    
    //header("Location: list_tipoProjeto.php");
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>PMA - Cadastrar Modelo</title>
        <link rel="icon" href="../../util/icon.png" type="image/icon type">
        
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../../util/links/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="../../util/SpryValidationTextField.js" type="text/javascript"></script> 
        <link href="../../util/SpryValid.css" rel="stylesheet" type="text/css" />
        <link href="../../util/sizes.css" rel="stylesheet" type="text/css" />
        <link href="../../util/styles.css" rel="stylesheet" type="text/css" />
        <script src="../../util/links/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container">
            <div class="jumbotron row">
                <div>
                    <h2>Cadastro de Modelos</h2><h4><span class="badge badge-secondary">PMA - Project Management Aplication</span></h4>
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
            
            <div clas="span10 offset1">
                <div class="card">
                    <div class="card-header">
                        <h3 class="well"> Adicionar Modelo de Projeto </h3>
                    </div>
                    <div class="card-body">
                    <form class="form-horizontal" action="create_tipoProjeto.php" method="post">
                        
                        <fieldset>
                            <legend>Novo Modelo de Projeto</legend>

                            <div class="form-group col-md-6">
                                <label for="descricao">Descrição: </label><br>
                                    <span id="descricao1" class="textfieldHintState">
                                        <input type="text" class="form-control" name="descricao" id="descricao" placeholder="Descrição" value="" />
                                        <span class="textfieldMaxCharsMsg">Esse campo tem limite de 85 caracteres.</span>
                                        <span class="textfieldRequiredMsg">Esse campo é obrigatório</span>
                                    </span>
                            </div>

                            <script>
                                var user = new Spry.Widget.ValidationTextField("descricao1", "custom", {validateOn:["blur"], maxChars: 85});
                            </script>
                        </fieldset>
                        
                        <div class="form-actions">
                            <br/>

                            <button type="submit" class="btn btn-success">Adicionar</button>
                            <a href="../Home/home.php" type="btn" class="btn btn-default">Menu Principal</a>
                            <a href="list_tipoProjeto.php" type="btn" class="btn btn-default">Voltar</a>
                        </div>
                    </form>
                    </div>
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
                  <h5 class="modal-title" id="exampleModalLongTitle">Dados adicionados: </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="form-group col-md-8">
                            O modelo foi cadastrado com sucesso!
                    </div>
                    <div style="text-align: center;"><img src="../../util/confirma.png" height="175px" width="175px" /></div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                  <a href="create_tipoProjeto.php" type="button" class="btn btn-primary" id="designar">Cadastrar Outro</a>
                </div>
              </div>
            </div>
        </div>
        
        <script src="../../util/links/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="../../util/links/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <p></p>
    </body>
</html>