<?php

session_start(); 
if((substr_compare($_SESSION['permissao']['projeto'], '0', 1, 1)) == 0) {
    header("Location: ../Erro/permissao.php");
}

if(!empty($_POST)) {
    include_once '../../domain/Projeto.php';
    include_once '../../controller/clientecontrole.php';
    include_once '../../controller/enderecocontrole.php';
    include_once '../../controller/ProjetoControle.php';
    include_once '../../controller/TipoProjetoControle.php';
    include_once '../../controller/TarefaControle.php';
    include_once '../../controller/UsuarioControle.php';
    
    $projeto = new Projeto();
    
    $clienteControle = new ClienteControle();
    $cliente = $clienteControle->pesquisarCliente($_POST['nome']);
    $projeto->setCliente_id($cliente['id']);
    $tipoProjetoControle = new TipoProjetoControle();
    $tipoProjeto = $tipoProjetoControle->pesquisarTipoProjeto($_POST['tipoprojeto']);
    $projeto->setTipoprojeto_id($tipoProjeto['id']);
    $projeto->setData_entrada($_POST['data_entrada']);
    $projeto->setData_prevista($_POST['data_prevista']);
    $projeto->setDescricao($_POST['descricao']);
    $projeto->setValor($_POST['valor']);
    
    $usuarioControle = new UsuarioControle();
    $usuario = $usuarioControle->readUsuarioByUserName($_POST['usuario']);
    $projeto->setUsuario_id($usuario['id']);
    
    $projetoControle = new ProjetoControle();
    $try = $projetoControle->inserirProjeto($projeto);
    
    if (empty($try)) {
        $tarefaControle = new TarefaControle();
        $tarefas = $tarefaControle->list_tarefasTipoProjeto($tipoProjeto['id']);
        foreach ($tarefas as $row) {
            $tarefaControle->novaTarefa_Projeto($row);
        }
    }
}
?>

<html>
    <head>
        <title>PMA - Cadastrar Projeto</title>
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
        <link href="../../util/currencyStyle.css" rel="stylesheet" type="text/css" />
        
        <script src="../../util/links/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="../../util/links/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="../../util/links/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <link type="text/css" href="../../util/links/jquery-ui-themes-1.12.1/jquery-ui.css" rel="stylesheet"/>
        <script type="text/javascript" src="../../util/links/jquery-ui-1.12.1/jquery-ui.js"></script>
        
        <script type="text/javascript" src="../../util/jquery.mask.js"></script>
    </head>
    <body>
    <div class="container">
        <div class="jumbotron row">
            <div>
                <h2>Cadastro de Projetos</h2><h4><span class="badge badge-secondary">PMA - Project Management Aplication</span></h4>
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
                <h3 class="well"> Adicionar Projeto </h3>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="create_projeto.php" method="post">

                <fieldset>
                <legend>Novo Projeto</legend>
                
                    <script type="text/javascript">
                        $(document).ready(function() {

                            // Captura o retorno do retornaCliente.php
                            $.getJSON('retornaCliente.php', function(data){
                                var dados = [];

                                // Armazena na array capturando somente o nome do cliente
                                $(data).each(function(key, value) {
                                    dados.push(value.nome);
                                });

                                // Chamo o Auto complete do JQuery ui setando o id do input, array com os dados e o mínimo de caracteres para disparar o AutoComplete
                                $('#nome').autocomplete({ source: dados, minLength: 1});
                            });
                        });
                    </script>
        
                    <div class="form-group col-md-6">
                        <label for="nome">Selecionar Cliente: </label><br>
                            <span id="nome1" class="textfieldHintState">
                                <input class="form-control" type="text" name="nome" id="nome" placeholder="Nome" value="<?php if(!empty($_POST)) echo $_POST['nome'] ?>" />
                                <span class="textfieldMaxCharsMsg">Esse campo tem limite de 150 caracteres.</span>
                                   <span class="textfieldRequiredMsg">Esse campo é obrigatório</span>
                            </span>
                    </div>
                    <script>
                        var nome1 = new Spry.Widget.ValidationTextField("nome1", "custom", {validateOn:["blur"], maxChars: 150});
                    </script>
                    
                    <div class="form-group col-md-4">
                        <label for="tipoprojeto">Modelos de projeto: </label><br>
                        <select class="form-control" name="tipoprojeto" id="tipoprojeto">
                            <option></option>
                            <?php
                                include_once '../../controller/TipoProjetoControle.php';

                                $tipoProjetoControle = new TipoProjetoControle();
                                $data = $tipoProjetoControle->listTipoProjeto();
                                foreach($data as $row) 
                                {
                                    echo '<option>'.$row['descricao'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group col-md-3">
                        <label for="data_entrada">Data de entrada: </label>
                        <input class="form-control" type="date" name="data_entrada" id="data_entrada" value="<?php echo date('Y-m-d') ?>">
                    </div>
                    
                    <div class="form-group col-md-3">
                        <label for="data_prevista">Estimativa de Conclusão: </label>
                        <input class="form-control" type="date" name="data_prevista" id="data_prevista" value="<?php echo date('Y-m-d') ?>">
                    </div>
                    
                    <div class="form-group col-md-8">
                        <label for="descricao">Descrição: </label>
                        <textarea maxlength="450" class="form-control" rows="3" name="descricao" id="descricao"></textarea>
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label for="responsavel">Usuário responsável: </label>
                        <select class="form-control" name="usuario" id="usuario">
                            <option></option>
                            <?php
                                include_once '../../controller/UsuarioControle.php';

                                $usuarioControle = new UsuarioControle();
                                $data_fk = $usuarioControle->listUsuario();
                                foreach($data_fk as $row) 
                                {
                                    echo '<option>'.$row['usuario'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group col-md-3">
                        <label for="valor">Valor Estipulado: </label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text">R$</span>
                            </div>
                            <input name="valor" id="valor" class="valor currency" type="text">
                        </div>
                    </div>
                    
                
                </fieldset>
                
                <div class="form-actions">
                    <br/>

                    <button type="submit" class="btn btn-success">Adicionar</button>
                    <a href="../Home/home.php" type="btn" class="btn btn-default">Menu Principal</a>
                    <a href="list_projeto.php" type="btn" class="btn btn-default">Voltar</a>

                </div>
            </form>
          </div>
        </div>
        </div>
    </div>
        
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('.valor').mask('000.000.000.000.000,00', {reverse: true});
                        });
                    </script>
                    
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
                            window.location.href = "list_projeto.php";
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
                            <?php if (strpos($try, 'cannot be null')) { 
                                
                                if (strpos($try, "'cliente_id'"))
                                    echo 'O nome inserido não pertence a nenhum cliente! Insira um nome válido utilizando a função de preenchimento automático! Em caso de dúvidas, entre em contato com o suporte.';
                                elseif (strpos($try, "'tipoprojeto_id'"))
                                    echo 'Selecione um modelo de projeto válido! Em caso de dúvidas, entre em contato com o suporte.';
                                
                            } else { echo $try; } ?>
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
                            O projeto foi cadastrado com sucesso!
                    </div>
                    <div style="text-align: center;"><img src="../../util/confirma.png" height="175px" width="175px" /></div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                  <a href="create_projeto.php" type="button" class="btn btn-primary" id="designar">Cadastrar Outro</a>
                </div>
              </div>
            </div>
        </div>
        

    <p></p>
    </body>
</html>
