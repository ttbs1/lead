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

if(!empty($_POST)) {
    include_once '../../domain/usuario.php';
    include_once '../../domain/permissao.php';
    include_once '../../controller/usuariocontrole.php';
    $usuario = new Usuario();
    $usuario->setPermissao_id(new permissao());
    
    $usuario->setUsuario($_POST['usuario']);
    $usuario->setSenha($_POST['senha']);
    
    if (isset($_POST['adm'])) {
        $permissao = "1";
    } else {
        $permissao = "0";
    }
    
    $usuario->getPermissao_id()->setAdm($permissao);
    
    if (isset($_POST['ler_usuario'])) {
        $permissao = "1";
    } else {
        $permissao = "0";
    }
    if (isset($_POST['cadastrar_usuario'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    if (isset($_POST['alterar_usuario'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    if (isset($_POST['excluir_usuario'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    
    $usuario->getPermissao_id()->setUsuario($permissao);
    
    if (isset($_POST['ler_empresa'])) {
        $permissao = "1";
    } else {
        $permissao = "0";
    }
    if (isset($_POST['cadastrar_empresa'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    if (isset($_POST['alterar_empresa'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    if (isset($_POST['excluir_empresa'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    
    $usuario->getPermissao_id()->setEmpresa($permissao);
    
    if (isset($_POST['ler_cliente'])) {
        $permissao = "1";
    } else {
        $permissao = "0";
    }
    if (isset($_POST['cadastrar_cliente'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    if (isset($_POST['alterar_cliente'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    if (isset($_POST['excluir_cliente'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    
    $usuario->getPermissao_id()->setCliente($permissao);
    
    if (isset($_POST['ler_endereco'])) {
        $permissao = "1";
    } else {
        $permissao = "0";
    }
    if (isset($_POST['cadastrar_endereco'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    if (isset($_POST['alterar_endereco'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    if (isset($_POST['excluir_endereco'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    
    $usuario->getPermissao_id()->setEndereco($permissao);
    
    if (isset($_POST['ler_projeto'])) {
        $permissao = "1";
    } else {
        $permissao = "0";
    }
    if (isset($_POST['cadastrar_projeto'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    if (isset($_POST['alterar_projeto'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    if (isset($_POST['excluir_projeto'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    
    $usuario->getPermissao_id()->setProjeto($permissao);
    
    if (isset($_POST['ler_iteracao'])) {
        $permissao = "1";
    } else {
        $permissao = "0";
    }
    if (isset($_POST['cadastrar_iteracao'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    if (isset($_POST['alterar_iteracao'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    if (isset($_POST['excluir_iteracao'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    
    $usuario->getPermissao_id()->setIteracao($permissao);
    
    if (isset($_POST['ler_tipo'])) {
        $permissao = "1";
    } else {
        $permissao = "0";
    }
    if (isset($_POST['cadastrar_tipo'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    if (isset($_POST['alterar_tipo'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    if (isset($_POST['excluir_tipo'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    
    $usuario->getPermissao_id()->setTipoprojeto($permissao);
    
    if (isset($_POST['ler_tarefa'])) {
        $permissao = "1";
    } else {
        $permissao = "0";
    }
    if (isset($_POST['cadastrar_tarefa'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    if (isset($_POST['alterar_tarefa'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    if (isset($_POST['excluir_tarefa'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    
    $usuario->getPermissao_id()->setTarefa($permissao);
    
    $usuarioControle = new UsuarioControle();
    $try = $usuarioControle->inserirUsuario($usuario);
    
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
        <link href="../../util/sizes.css" rel="stylesheet" type="text/css" />
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
                                                <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Usuario" value="<?php echo $_POST['usuario'] ?>" />
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
                                                <input type="password" class="form-control" name="senha" id="senha" placeholder="Senha" value="<?php echo $_POST['senha'] ?>" />
                                                <span class="textfieldMaxCharsMsg">Esse campo tem limite de 12 caracteres.</span>
                                                <span class="textfieldRequiredMsg">Esse campo é obrigatório</span>
                                            </span>
                                </div>
                                <script>
                                    var senha = new Spry.Widget.ValidationTextField("senha", "custom", {validateOn:["blur"], maxChars: 12});
                                </script>

                                <label for="adm">Administrador: </label> <input type="checkbox" name="adm" id="adm" <?php if(isset($_POST['adm'])) echo 'checked'; ?>>

                            </fieldset>
                            
                            <fieldset  style="padding-left: 1.5em;">
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
                                        <td style="padding-left: 5%;"><input type="checkbox" name="ler_usuario" id="ler_usuario" <?php if(isset($_POST['ler_usuario'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="cadastrar_usuario" id="cadastrar_usuario" <?php if(isset($_POST['cadastrar_usuario'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="alterar_usuario" id="alterar_usuario" <?php if(isset($_POST['alterar_usuario'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="excluir_usuario" id="excluir_usuario" <?php if(isset($_POST['excluir_usuario'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="marcar_usuario" id="marcar_usuario" onclick="marcarUsuarios();"></td>
                                    </tr>
                                    <tr>
                                        <td><label>Empresas</label></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="ler_empresa" id="ler_empresa" <?php if(isset($_POST['ler_empresa'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="cadastrar_empresa" id="cadastrar_empresa" <?php if(isset($_POST['cadastrar_empresa'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="alterar_empresa" id="alterar_empresa" <?php if(isset($_POST['alterar_empresa'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="excluir_empresa" id="excluir_empresa" <?php if(isset($_POST['excluir_empresa'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="marcar_empresa" id="marcar_empresa" onclick="marcarEmpresas();"></td>
                                    </tr>
                                    <tr>
                                        <td><label>Clientes</label></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="ler_cliente" id="ler_cliente" <?php if(isset($_POST['ler_cliente'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="cadastrar_cliente" id="cadastrar_cliente" <?php if(isset($_POST['cadastrar_cliente'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="alterar_cliente" id="alterar_cliente" <?php if(isset($_POST['alterar_cliente'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="excluir_cliente" id="excluir_cliente" <?php if(isset($_POST['excluir_cliente'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="marcar_cliente" id="marcar_cliente" onclick="marcarClientes();"></td>
                                    </tr>
                                    <tr>
                                        <td><label>Endereços</label></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="ler_endereco" id="ler_endereco" <?php if(isset($_POST['ler_endereco'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="cadastrar_endereco" id="cadastrar_endereco" <?php if(isset($_POST['cadastrar_endereco'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="alterar_endereco" id="alterar_endereco" <?php if(isset($_POST['alterar_endereco'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="excluir_endereco" id="excluir_endereco" <?php if(isset($_POST['excluir_endereco'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="marcar_endereco" id="marcar_endereco" onclick="marcarEnderecos();"></td>
                                    </tr>
                                    <tr>
                                        <td><label>Projetos</label></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="ler_projeto" id="ler_projeto" <?php if(isset($_POST['ler_projeto'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="cadastrar_projeto" id="cadastrar_projeto" <?php if(isset($_POST['cadastrar_projeto'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="alterar_projeto" id="alterar_projeto" <?php if(isset($_POST['alterar_projeto'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="excluir_projeto" id="excluir_projeto" <?php if(isset($_POST['excluir_projeto'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="marcar_projeto" id="marcar_projeto" onclick="marcarProjetos();"></td>
                                    </tr>
                                    <tr>
                                        <td><label>Iterações</label></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="ler_iteracao" id="ler_iteracao" <?php if(isset($_POST['ler_iteracao'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="cadastrar_iteracao" id="cadastrar_iteracao" <?php if(isset($_POST['cadastrar_iteracao'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="alterar_iteracao" id="alterar_iteracao" <?php if(isset($_POST['alterar_iteracao'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="excluir_iteracao" id="excluir_iteracao" <?php if(isset($_POST['excluir_iteracao'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="marcar_iteracao" id="marcar_iteracao" onclick="marcarIteracoes();"></td>
                                    </tr>
                                    <tr>
                                        <td><label>Tipos de Projeto</label></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="ler_tipo" id="ler_tipo" <?php if(isset($_POST['ler_tipo'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="cadastrar_tipo" id="cadastrar_tipo" <?php if(isset($_POST['cadastrar_tipo'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="alterar_tipo" id="alterar_tipo" <?php if(isset($_POST['alterar_tipo'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="excluir_tipo" id="excluir_tipo" <?php if(isset($_POST['excluir_tipo'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="marcar_tipo" id="marcar_tipo" onclick="marcarTipos();"></td>
                                    </tr>
                                    <tr>
                                        <td><label>Tarefas</label></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="ler_tarefa" id="ler_tarefa" <?php if(isset($_POST['ler_tarefa'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="cadastrar_tarefa" id="cadastrar_tarefa" <?php if(isset($_POST['cadastrar_tarefa'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="alterar_tarefa" id="alterar_tarefa" <?php if(isset($_POST['alterar_tarefa'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="excluir_tarefa" id="excluir_tarefa" <?php if(isset($_POST['excluir_tarefa'])) echo 'checked'; ?>></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="marcar_tarefa" id="marcar_tarefa" onclick="marcarTarefas();"></td>
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

                                        function marcarEmpresas() {
                                            if(document.getElementById("marcar_empresa").checked == true) {
                                                document.getElementById("ler_empresa").checked = true;
                                                document.getElementById("cadastrar_empresa").checked = true;
                                                document.getElementById("alterar_empresa").checked = true;
                                                document.getElementById("excluir_empresa").checked = true;
                                            } else {
                                                document.getElementById("ler_empresa").checked = false;
                                                document.getElementById("cadastrar_empresa").checked = false;
                                                document.getElementById("alterar_empresa").checked = false;
                                                document.getElementById("excluir_empresa").checked = false;
                                            }
                                        }

                                        function marcarClientes() {
                                            if(document.getElementById("marcar_cliente").checked == true) {
                                                document.getElementById("ler_cliente").checked = true;
                                                document.getElementById("cadastrar_cliente").checked = true;
                                                document.getElementById("alterar_cliente").checked = true;
                                                document.getElementById("excluir_cliente").checked = true;
                                            } else {
                                                document.getElementById("ler_cliente").checked = false;
                                                document.getElementById("cadastrar_cliente").checked = false;
                                                document.getElementById("alterar_cliente").checked = false;
                                                document.getElementById("excluir_cliente").checked = false;
                                            }
                                        }

                                        function marcarEnderecos() {
                                            if(document.getElementById("marcar_endereco").checked == true) {
                                                document.getElementById("ler_endereco").checked = true;
                                                document.getElementById("cadastrar_endereco").checked = true;
                                                document.getElementById("alterar_endereco").checked = true;
                                                document.getElementById("excluir_endereco").checked = true;
                                            } else {
                                                document.getElementById("ler_endereco").checked = false;
                                                document.getElementById("cadastrar_endereco").checked = false;
                                                document.getElementById("alterar_endereco").checked = false;
                                                document.getElementById("excluir_endereco").checked = false;
                                            }
                                        }

                                        function marcarProjetos() {
                                            if(document.getElementById("marcar_projeto").checked == true) {
                                                document.getElementById("ler_projeto").checked = true;
                                                document.getElementById("cadastrar_projeto").checked = true;
                                                document.getElementById("alterar_projeto").checked = true;
                                                document.getElementById("excluir_projeto").checked = true;
                                            } else {
                                                document.getElementById("ler_projeto").checked = false;
                                                document.getElementById("cadastrar_projeto").checked = false;
                                                document.getElementById("alterar_projeto").checked = false;
                                                document.getElementById("excluir_projeto").checked = false;
                                            }
                                        }

                                        function marcarIteracoes() {
                                            if(document.getElementById("marcar_iteracao").checked == true) {
                                                document.getElementById("ler_iteracao").checked = true;
                                                document.getElementById("cadastrar_iteracao").checked = true;
                                                document.getElementById("alterar_iteracao").checked = true;
                                                document.getElementById("excluir_iteracao").checked = true;
                                            } else {
                                                document.getElementById("ler_iteracao").checked = false;
                                                document.getElementById("cadastrar_iteracao").checked = false;
                                                document.getElementById("alterar_iteracao").checked = false;
                                                document.getElementById("excluir_iteracao").checked = false;
                                            }
                                        }

                                        function marcarTipos() {
                                            if(document.getElementById("marcar_tipo").checked == true) {
                                                document.getElementById("ler_tipo").checked = true;
                                                document.getElementById("cadastrar_tipo").checked = true;
                                                document.getElementById("alterar_tipo").checked = true;
                                                document.getElementById("excluir_tipo").checked = true;
                                            } else {
                                                document.getElementById("ler_tipo").checked = false;
                                                document.getElementById("cadastrar_tipo").checked = false;
                                                document.getElementById("alterar_tipo").checked = false;
                                                document.getElementById("excluir_tipo").checked = false;
                                            }
                                        }

                                        function marcarTarefas() {
                                            if(document.getElementById("marcar_tarefa").checked == true) {
                                                document.getElementById("ler_tarefa").checked = true;
                                                document.getElementById("cadastrar_tarefa").checked = true;
                                                document.getElementById("alterar_tarefa").checked = true;
                                                document.getElementById("excluir_tarefa").checked = true;
                                            } else {
                                                document.getElementById("ler_tarefa").checked = false;
                                                document.getElementById("cadastrar_tarefa").checked = false;
                                                document.getElementById("alterar_tarefa").checked = false;
                                                document.getElementById("excluir_tarefa").checked = false;
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
                            window.location.href = "list_usuario.php";
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

                            if (strpos($try, "'usuario'"))
                                echo 'Já existe um usuário cadastrado com esse nome, e não pode ser cadastrado em duplicidade. Em caso de dúvidas, entre em contato com o suporte.';

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
                            O usuário foi cadastrado com sucesso!
                    </div>
                    <div style="text-align: center;"><img src="../../util/confirma.png" height="175px" width="175px" /></div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                  <a href="create_usuario.php" type="button" class="btn btn-primary" id="designar">Cadastrar Outro</a>
                </div>
              </div>
            </div>
        </div>
        
        <p></p>
    </body>
</html>
