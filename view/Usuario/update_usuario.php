<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php

session_start(); 
if((substr_compare($_SESSION['permissao']['usuario'], '0', 2, 1)) == 0) {
    header("Location: ../Erro/permissao.php");
}

include_once '../../domain/usuario.php';
include_once '../../domain/permissao.php';
include_once '../../controller/usuariocontrole.php';
include_once '../../controller/PermissaoControle.php';

if(!empty($_GET['id'])) {
    {
        $id = $_REQUEST['id'];
    }
}

if(!empty($_POST)) {
    $usuario = new Usuario();
    $usuario->setPermissao_id(new permissao());
    
    $id = $_REQUEST['id'];
    
    $usuario->setUsuario($_POST['usuario']);
    if(isset($_POST['senha']))
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
    
    if (isset($_POST['ler_lead'])) {
        $permissao = "1";
    } else {
        $permissao = "0";
    }
    if (isset($_POST['cadastrar_lead'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    if (isset($_POST['alterar_lead'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    if (isset($_POST['excluir_lead'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    
    $usuario->getPermissao_id()->setLead($permissao);
    
    if (isset($_POST['ler_campanha'])) {
        $permissao = "1";
    } else {
        $permissao = "0";
    }
    if (isset($_POST['cadastrar_campanha'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    if (isset($_POST['alterar_campanha'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    if (isset($_POST['excluir_campanha'])) {
        $permissao = $permissao."1";
    } else {
        $permissao = $permissao."0";
    }
    
    $usuario->getPermissao_id()->setCampanha($permissao);
    $permissao_id = $_REQUEST['permissao_id'];
    
    $usuarioControle = new UsuarioControle();
    if(!empty($_POST['senha']))
        $try = $usuarioControle->updateUsuario($usuario, $id);
    else
        $try = $usuarioControle->updateUsuario_semSenha ($usuario, $id);
    $permissaoControle = new PermissaoControle();
    if(empty($try))
        $try = $permissaoControle->updatePermissao($usuario->getPermissao_id(), $permissao_id);
    
    //header("Location: list_usuario.php");
} else {
    $usuarioControle = new UsuarioControle();
    $data = $usuarioControle->readUsuario($id);
    $permissaoControle = new PermissaoControle();
    $data_fk = $permissaoControle->readPermissao($data['permissao_id']);
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>PMA - Atualizar Usuário</title>
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
                    <h2>Atualização de Usuários</h2><h4><span class="badge badge-secondary">PMA - Project Management Aplication</span></h4>
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
                        <h3 class="well"> Atualizar Usuário </h3>
                    </div>
                    <div class="card-body">
                    <form class="form-horizontal" action="update_usuario.php" method="post">

                        <div class="row">
                            <fieldset style="padding-left: 1.5em;">
                                <legend>Usuário</legend>
                                        
                                <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
                                <input type="hidden" name="permissao_id" id="permissao_id" value="<?php echo $data['permissao_id']; ?>" />
                                
                                <div class="form-group col-md-12">
                                <label for="usuario">Nome de usuário: </label>
                                            <span id="usuario1" class="textfieldHintState">
                                                <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Usuario" value="<?php if(!empty($_POST)) echo $_POST['usuario']; else echo $data['usuario']; ?>" />
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
                                    var senha = new Spry.Widget.ValidationTextField("senha", "custom", {validateOn:["blur"], maxChars: 12, isRequired: false});
                                </script>

                                <label for="adm">Administrador: </label> <input type="checkbox" name="adm" id="adm" <?php if(isset($_POST['adm'])) echo 'checked'; else if(empty ($_POST)) if($data_fk["adm"]) echo 'checked'; ?>>

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
                                        <td style="padding-left: 5%;"><input type="checkbox" name="ler_usuario" id="ler_usuario" <?php if(!empty($_POST['ler_usuario'])) echo 'checked'; else if(empty ($_POST)) if(substr($data_fk['usuario'], 0, 1) == '1') { echo 'checked=""';} ?> ></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="cadastrar_usuario" id="cadastrar_usuario" <?php if(!empty($_POST['cadastrar_usuario'])) echo 'checked'; else if(empty ($_POST)) if(substr($data_fk['usuario'], 1, 1) == '1') { echo 'checked=""';} ?> ></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="alterar_usuario" id="alterar_usuario" <?php if(!empty($_POST['alterar_usuario'])) echo 'checked'; else if(empty ($_POST)) if(substr($data_fk['usuario'], 2, 1) == '1') { echo 'checked=""';} ?> ></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="excluir_usuario" id="excluir_usuario" <?php if(!empty($_POST['excluir_usuario'])) echo 'checked'; else if(empty ($_POST)) if(substr($data_fk['usuario'], 3, 1) == '1') { echo 'checked=""';} ?> ></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="marcar_usuario" id="marcar_usuario" onclick="marcarUsuarios();"></td>
                                    </tr>
                                    <tr>
                                        <td><label>Leads</label></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="ler_lead" id="ler_lead" <?php if(!empty($_POST['ler_lead'])) echo 'checked'; else if(empty ($_POST)) if(substr($data_fk['lead'], 0, 1) == '1') { echo 'checked=""';} ?> ></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="cadastrar_lead" id="cadastrar_lead" <?php if(!empty($_POST['cadastrar_lead'])) echo 'checked'; else if(empty ($_POST)) if(substr($data_fk['lead'], 0, 1) == '1') { echo 'checked=""';} ?> ></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="alterar_lead" id="alterar_lead" <?php if(!empty($_POST['alterar_lead'])) echo 'checked'; else if(empty ($_POST)) if(substr($data_fk['lead'], 0, 1) == '1') { echo 'checked=""';} ?> ></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="excluir_lead" id="excluir_lead" <?php if(!empty($_POST['excluir_lead'])) echo 'checked'; else if(empty ($_POST)) if(substr($data_fk['lead'], 0, 1) == '1') { echo 'checked=""';} ?> ></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="marcar_lead" id="marcar_lead" onclick="marcarLeads();"></td>
                                    </tr>
                                    <tr>
                                        <td><label>Campanhas</label></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="ler_campanha" id="ler_campanha" <?php if(!empty($_POST['ler_campanha'])) echo 'checked'; else if(empty ($_POST)) if(substr($data_fk['campanha'], 0, 1) == '1') { echo 'checked=""';} ?> ></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="cadastrar_campanha" id="cadastrar_campanha" <?php if(!empty($_POST['cadastrar_campanha'])) echo 'checked'; else if(empty ($_POST)) if(substr($data_fk['campanha'], 0, 1) == '1') { echo 'checked=""';} ?> ></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="alterar_campanha" id="alterar_campanha" <?php if(!empty($_POST['alterar_campanha'])) echo 'checked'; else if(empty ($_POST)) if(substr($data_fk['campanha'], 0, 1) == '1') { echo 'checked=""';} ?> ></td>
                                        <td style="padding-left: 5%;"><input type="checkbox" name="excluir_campanha" id="excluir_campanha" <?php if(!empty($_POST['excluir_campanha'])) echo 'checked'; else if(empty ($_POST)) if(substr($data_fk['campanha'], 0, 1) == '1') { echo 'checked=""';} ?> ></td>
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

                            <button type="submit" class="btn btn-success">Atualizar</button>
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
                  <h5 class="modal-title" id="exampleModalLongTitle">Dados atualizados: </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="form-group col-md-8">
                            O usuário foi atualizado com sucesso!
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
