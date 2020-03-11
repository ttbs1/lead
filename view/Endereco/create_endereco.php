<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>PMA - Cadastrar Endereço</title>
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
    </head>
    <body>
        <div class="container">
            
            <div class="jumbotron row">
                <div>
                    <h2>Cadastro de Endereços</h2><h4><span class="badge badge-secondary">PMA - Project Management Aplication</span></h4>
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
            
            if(!empty($_GET['cliente']))
            {
                $cliente_id = $_REQUEST['cliente'];
            }
            if(!empty($_GET['empresa']))
            {
                $empresa_id = $_REQUEST['empresa'];
            }
            if(!empty($_GET['projeto']))
            {
                $projeto_id = $_REQUEST['projeto'];
            }
            if(!empty($_POST))
            {
                include_once '../../domain/Endereco.php';
                include_once '../../controller/EnderecoControle.php';
                $endereco = new Endereco();
                
                $endereco->setCEP($_POST['cep']);
                $endereco->setRua($_POST['rua']);
                $endereco->setNumero($_POST['numero']);
                $endereco->setBairro($_POST['bairro']);
                $endereco->setCidade($_POST['cidade']);
                $endereco->setEstado($_POST['uf']);
                
                $enderecoControle = new EnderecoControle();
                if (!empty($_POST['cliente_id']))
                    $try = $enderecoControle->inserirEnderecoCliente($_POST['cliente_id'], $endereco);
                elseif (!empty($_POST['empresa_id'])) 
                    $try = $enderecoControle->inserirEnderecoEmpresa($_POST['empresa_id'], $endereco);
            }

            ?>
            
            <div class="card">
                <div class="card-header">
                    <h3 class="well"> Cadastrar Endereço </h3>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="create_endereco.php" method="post">



                        <!-- Adicionando JQuery -->
                        <script src="https://code.jquery.com/jquery-3.4.1.min.js"
                                integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
                                crossorigin="anonymous"></script>

                        <!-- Adicionando Javascript -->
                        <script type="text/javascript" >

                            $(document).ready(function() {

                                function limpa_formulário_cep() {
                                    // Limpa valores do formulário de cep.
                                    $("#rua").val("");
                                    $("#bairro").val("");
                                    $("#cidade").val("");
                                    $("#uf").val("");
                                    $("#rua").removeAttr("readonly");
                                    $("#bairro").removeAttr("readonly");
                                    $("#cidade").removeAttr("readonly");
                                    $("#uf").removeAttr("readonly");
                                    $("#rua").focus();
                                    $("#rua").blur();
                                    $("#cidade").focus();
                                    $("#cidade").blur();
                                    $("#uf").focus();
                                    $("#uf").blur();
                                }

                                //Quando o campo cep perde o foco.

                                $("#cep").blur(function() {

                                    //Nova variável "cep" somente com dígitos.
                                    var cep = $(this).val().replace(/\D/g, '');

                                    //Verifica se campo cep possui valor informado.
                                    if (cep != "") {

                                        //Expressão regular para validar o CEP.
                                        var validacep = /^[0-9]{8}$/;

                                        //Valida o formato do CEP.
                                        if(validacep.test(cep)) {

                                            //Preenche os campos com "..." enquanto consulta webservice.
                                            $("#rua").val("...");
                                            $("#bairro").val("...");
                                            $("#cidade").val("...");
                                            $("#uf").val("...");

                                            //Consulta o webservice viacep.com.br/
                                            $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                                                if (!("erro" in dados)) {
                                                    //Atualiza os campos com os valores da consulta.
                                                    $("#rua").val(dados.logradouro);
                                                    $("#bairro").val(dados.bairro);
                                                    $("#cidade").val(dados.localidade);
                                                    $("#uf").val(dados.uf);

                                                    //Campos encontrados deixam de ser editáveis
                                                    if(dados.logradouro.toString()=="")
                                                         $("#rua").removeAttr("readonly");
                                                    else {
                                                        $("#rua").focus();
                                                        $("#rua").blur();
                                                        $("#rua").attr("readonly", "true");
                                                    }
                                                    if(dados.bairro.toString()=="")
                                                         $("#bairro").removeAttr("readonly");
                                                    else {
                                                        $("#bairro").focus();
                                                        $("#bairro").blur();
                                                        $("#bairro").attr("readonly", "true");
                                                    }
                                                    if(dados.localidade.toString()=="")
                                                         $("#cidade").removeAttr("readonly");
                                                    else {
                                                        $("#cidade").focus();
                                                        $("#cidade").blur();
                                                        $("#cidade").attr("readonly", "true");
                                                    }
                                                    if(dados.uf.toString()=="")
                                                         $("#uf").removeAttr("readonly");
                                                    else {
                                                        $("#uf").focus();
                                                        $("#uf").blur();
                                                        $("#uf").attr("readonly", "true");
                                                    }
                                                } //end if.
                                                else {
                                                    //CEP pesquisado não foi encontrado.
                                                    limpa_formulário_cep();
                                                    alert("CEP não encontrado.");
                                                }
                                            });
                                        } //end if.
                                        else {
                                            //cep é inválido.
                                            limpa_formulário_cep();
                                            alert("Formato de CEP inválido.");
                                        }
                                    } //end if.
                                    else {
                                        //cep sem valor, limpa formulário.
                                        limpa_formulário_cep();
                                    }
                                });
                            });

                        </script>
                        <fieldset>
                        <legend>Endereço</legend>
                        <div id="endereco">

                            <input type="hidden" name="cliente_id" id="cliente_id" value="<?php echo $cliente_id ?>" />
                            <input type="hidden" name="empresa_id" id="empresa_id" value="<?php echo $empresa_id ?>" />
                            <input type="hidden" name="projeto_id" id="projeto_id" value="<?php echo $projeto_id ?>" />

                            <div class="form-group row" style="margin-left: 3px">
                                <div class="form-group col-md-2">
                                    <label for="cep">CEP: </label>
                                        <span id="cep1" class="textfieldHintState">
                                            <input type="text" class="form-control" name="cep" id="cep" placeholder="CEP" value="<?php if(!empty($_POST)) echo $_POST['cep'] ?>" />
                                            <span class="textfieldMaxCharsMsg">Esse campo tem limite de 9 caracteres.</span>
                                        </span>
                                </div>
                                <div class="form-group col-md-6">
                                <label for="rua">Rua: </label>
                                    <span id="rua1" class="textfieldHintState">
                                        <input type="text" class="form-control" name="rua" id="rua" placeholder="Rua" value="<?php if(!empty($_POST)) echo $_POST['rua'] ?>" />
                                        <span class="textfieldMaxCharsMsg">Esse campo tem limite de 85 caracteres.</span>
                                        <span class="textfieldRequiredMsg">Esse campo é obrigatório</span>
                                    </span>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="numero">Numero: </label>
                                        <span id="numero1" class="textfieldHintState">
                                            <input type="text" class="form-control" name="numero" id="numero" placeholder="Numero" value="<?php if(!empty($_POST)) if(!empty($_POST['numero'])) echo $_POST['numero'] ?>" />
                                            <span class="textfieldMaxCharsMsg">Esse campo tem limite de 7 caracteres.</span>
                                        </span>
                                </div>

                                <div class="form-group col-md-5"> 
                                    <label for="bairro">Bairro: </label>
                                        <span id="bairro1" class="textfieldHintState">
                                            <input type="text" class="form-control" name="bairro" id="bairro" placeholder="Bairro" value="<?php if(!empty($_POST)) if(!empty($_POST['bairro'])) echo $_POST['bairro'] ?>" />
                                            <span class="textfieldMaxCharsMsg">Esse campo tem limite de 40 caracteres.</span>
                                        </span>
                                </div>

                                <div class="form-group col-md-5">
                                    <label for="cidade">Cidade: </label>
                                        <span id="cidade1" class="textfieldHintState">
                                            <input type="text" class="form-control" name="cidade" id="cidade" placeholder="Cidade" value="<?php if(!empty($_POST)) echo $_POST['cidade'] ?>" />
                                            <span class="textfieldMaxCharsMsg">Esse campo tem limite de 40 caracteres.</span>
                                            <span class="textfieldRequiredMsg">Esse campo é obrigatório</span>
                                        </span>
                                </div>

                                <div class="form-group col-md-1">
                                    <label for="uf">Estado: </label>
                                        <span id="uf1" class="textfieldHintState">
                                            <input type="text" class="form-control" name="uf" id="uf" placeholder="UF" value="<?php if(!empty($_POST)) echo $_POST['uf'] ?>" />
                                            <span class="textfieldMaxCharsMsg">Esse campo tem limite de 2 caracteres.</span>
                                            <span class="textfieldRequiredMsg">Esse campo é obrigatório</span>
                                        </span>
                                </div>
                            </div>

                        <script>
                            var cep1 = new Spry.Widget.ValidationTextField("cep1", "custom", {format:"custom", pattern: "00000-000", validateOn:["blur"], useCharacterMasking: true, isRequired: false});
                            var rua1 = new Spry.Widget.ValidationTextField("rua1", "custom", {validateOn:["blur"], maxChars: 85});
                            var numero1 = new Spry.Widget.ValidationTextField("numero1", "custom", {validateOn:["blur"], maxChars: 7, isRequired: false});
                            var bairro1 = new Spry.Widget.ValidationTextField("bairro1", "custom", {validateOn:["blur"], maxChars: 40, isRequired: false});
                            var cidade1 = new Spry.Widget.ValidationTextField("cidade1", "custom", {validateOn:["blur"], maxChars: 40});
                            var uf1 = new Spry.Widget.ValidationTextField("uf1", "custom", {format:"custom", pattern: "AA", validateOn:["blur"], useCharacterMasking: true});
                        </script>
                        </div>
                        </fieldset>




                        <div class="form-actions">
                            <br/>

                            <button type="submit" class="btn btn-success">Adicionar</button>
                            <a href="../Home/home.php" type="btn" class="btn btn-default">Menu Principal</a>
                            <a href="#" type="btn" class="btn btn-default" onclick="goBack();">Voltar</a>
                            <script>
                                function goBack () {
                                    window.history.back();
                                }
                            </script>

                        </div>
                    </form>
                </div>
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
                  <h5 class="modal-title" id="exampleModalLongTitle">Dados adicionados: </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="form-group col-md-8">
                            O endereço foi cadastrado com sucesso!
                    </div>
                    <div style="text-align: center;"><img src="../../util/confirma.png" height="175px" width="175px" /></div>
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
