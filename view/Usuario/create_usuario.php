<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php

session_start(); 
if((substr_compare($_SESSION['permissao']['usuario'], '0', 1, 1)) == 0) {
    header("Location: ../Erro/permissao.php");
}

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>PMA - Cadastrar Usuário</title>
        <link rel="icon" href="../../util/icon.png" type="image/icon type">
        
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../../util/links/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="../../util/SpryValidationTextField.js" type="text/javascript"></script> 
        <link href="../../util/SpryValid.css" rel="stylesheet" type="text/css" />
        <link href="../../util/styles.css" rel="stylesheet" type="text/css" />
        
    </head>
    <body>
        <div class="container">
            <div class="jumbotron row">
                <div>
                    <h2>Cadastro de Usuários</h2><h4><span class="badge badge-secondary">PMA - Project Management Aplication</span></h4>
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
                        <h3 class="well"> Adicionar Usuário </h3>
                    </div>
                    <div class="card-body">
                    <form class="form-horizontal" action="create_usuario_1.php" method="post">

                        <div class="row">
                            <fieldset style="padding-left: 1.5em;">
                                <legend>Novo usuário</legend>

                                <div class="form-group col-md-12">
                                <label for="usuario">Nome de usuário: </label>
                                            <span id="usuario1" class="textfieldHintState">
                                                <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Usuario" value="" />
                                                <span class="textfieldMaxCharsMsg">Esse campo tem limite de 85 caracteres.</span>
                                                <span class="textfieldRequiredMsg">Esse campo é obrigatório</span>
                                            </span>
                                </div>
                                <script>
                                    var usuario1 = new Spry.Widget.ValidationTextField("usuario1", "custom", {validateOn:["blur"], maxChars: 85});
                                </script>

                                <div class="form-group col-md-12">
                                <label for="senha">Senha: </label>
                                            <span id="senha" class="textfieldHintState">
                                                <input type="password" class="form-control" name="senha" id="senha" placeholder="Senha" value="" />
                                                <span class="textfieldMaxCharsMsg">Esse campo tem limite de 12 caracteres.</span>
                                                <span class="textfieldRequiredMsg">Esse campo é obrigatório</span>
                                            </span>
                                </div>
                                <script>
                                    var senha = new Spry.Widget.ValidationTextField("senha", "custom", {validateOn:["blur"], maxChars: 12});
                                </script>

                                <label for="adm">Administrador: </label> <input type="checkbox" name="adm" id="adm">

                            </fieldset>


                            <fieldset style="padding-left: 1.5em;">
                                <legend>Permissões do usuário</legend>
                                <table class="table-striped">
                                    <tr>
                                        <th style="width: 150px;"></th>
                                        <th style="width: 100px;">Leitura</th>
                                        <th style="width: 100px;">Cadastro</th>
                                        <th style="width: 100px;">Alteração</th>
                                        <th style="width: 100px;">Exclusão</th>
                                        <td style="width: 100px;">Marcar todos</td>
                                    </tr>
                                    <tr>
                                        <td><label>Usuarios</label></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="ler_usuario" id="ler_usuario" ></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="cadastrar_usuario" id="cadastrar_usuario" ></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="alterar_usuario" id="alterar_usuario" ></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="excluir_usuario" id="excluir_usuario"></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="marcar_usuario" id="marcar_usuario" onclick="marcarUsuarios();"></td>
                                    </tr>
                                    <tr>
                                        <td><label>Leads</label></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="ler_lead" id="ler_lead" checked=""></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="cadastrar_lead" id="cadastrar_lead" checked=""></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="alterar_lead" id="alterar_lead" checked=""></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="excluir_lead" id="excluir_lead"></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="marcar_lead" id="marcar_lead" onclick="marcarLeads();"></td>
                                    </tr>
                                    <tr>
                                        <td><label>Campanhas</label></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="ler_campanha" id="ler_campanha" checked=""></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="cadastrar_campanha" id="cadastrar_campanha" checked=""></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="alterar_campanha" id="alterar_campanha" checked=""></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="excluir_campanha" id="excluir_campanha"></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="marcar_campanha" id="marcar_campanha" onclick="marcarCampanhas();"></td>
                                    </tr>

                                    <script>
                                        function marcarUsuarios() {
                                            if(document.getElementById("marcar_usuario").checked == true) {
                                                document.getElementById("ler_usuario").checked = true;
                                                document.getElementById("cadastrar_usuario").checked = true;
                                                document.getElementById("alterar_usuario").checked = true;
                                                document.getElementById("excluir_usuario").checked = true;
                                            } else {
                                                document.getElementById("ler_usuario").checked = false;
                                                document.getElementById("cadastrar_usuario").checked = false;
                                                document.getElementById("alterar_usuario").checked = false;
                                                document.getElementById("excluir_usuario").checked = false;
                                            }
                                        }

                                        function marcarLeads() {
                                            if(document.getElementById("marcar_lead").checked == true) {
                                                document.getElementById("ler_lead").checked = true;
                                                document.getElementById("cadastrar_lead").checked = true;
                                                document.getElementById("alterar_lead").checked = true;
                                                document.getElementById("excluir_lead").checked = true;
                                            } else {
                                                document.getElementById("ler_lead").checked = false;
                                                document.getElementById("cadastrar_lead").checked = false;
                                                document.getElementById("alterar_lead").checked = false;
                                                document.getElementById("excluir_lead").checked = false;
                                            }
                                        }

                                        function marcarCampanhas() {
                                            if(document.getElementById("marcar_campanha").checked == true) {
                                                document.getElementById("ler_campanha").checked = true;
                                                document.getElementById("cadastrar_campanha").checked = true;
                                                document.getElementById("alterar_campanha").checked = true;
                                                document.getElementById("excluir_campanha").checked = true;
                                            } else {
                                                document.getElementById("ler_campanha").checked = false;
                                                document.getElementById("cadastrar_campanha").checked = false;
                                                document.getElementById("alterar_campanha").checked = false;
                                                document.getElementById("excluir_campanha").checked = false;
                                            }
                                        }
                                    </script>
                                </table>
                            </fieldset>
                        </div>
                        
                        <div class="form-actions">
                            <br/>

                            <button type="submit" class="btn btn-success">Adicionar</button>
                            <a href="../Home/home.php" type="btn" class="btn btn-default">Menu Principal</a>
                            <a href="list_usuario.php" type="btn" class="btn btn-default">Voltar</a>
                        </div>
                        
                    </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="../../util/links/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="../../util/links/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="../../util/links/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <p></p>
    </body>
</html>
