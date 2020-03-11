<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
session_start(); 
if((substr_compare($_SESSION['permissao']['empresa'], '0', 2, 1)) == 0) {
    header("Location: ../Erro/permissao.php");
}
?>

<html>
    <head>
        <title>PMA - Atualizar Empresa</title>
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
        <?php
        
            include '../../domain/Empresa.php';
            include '../../controller/EmpresaControle.php';
            include '../../controller/enderecocontrole.php';
            
            
	if ( !empty($_GET['id']))
            {
		$id = $_REQUEST['id'];
            }
	if (!empty($_POST)) {
            $empresa = new Empresa();
            $id = ($_POST['id']);
            $empresa->setNome($_POST['nome']);
            if (!empty($_POST['cpf_cnpj']))
                $empresa->setCpf_cnpj($_POST['cpf_cnpj']);
            if (!empty($_POST['telefone1']))
                $empresa->setTelefone($_POST['telefone1']);
            
            $empresaControle = new EmpresaControle();
            $try = $empresaControle->updateEmpresa($empresa, $id);
            
	} else {
            $empresaControle = new EmpresaControle();
            $data = $empresaControle->readEmpresa($id);
	}
	
    ?>
        <div class="container">
            <div class="jumbotron row">
                <div>
                    <h2>Atualização de Empresas</h2><h4><span class="badge badge-secondary">PMA - Project Management Aplication</span></h4>
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
                <h3 class="well"> Atualizar Empresa </h3>
            </div>
                <div class="card-body">
                    <form class="form-horizontal" action="update_empresa.php" method="post">
                    <fieldset>
                            <legend>Empresa</legend>

                            <input type="hidden" name="id" id="id" placeholder="id" value="<?php echo $id ?>" /><br>

                            <div class="form-group col-md-6">
                                <label for="nome">Nome: </label>
                                    <span id="nome1" class="textfieldHintState">
                                        <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome" value="<?php if(!empty($_POST)) echo $empresa->getNome(); else echo $data['nome']?>" />
                                        <span class="textfieldMaxCharsMsg">Esse campo tem limite de 150 caracteres.</span>
                                           <span class="textfieldRequiredMsg">Esse campo é obrigatório</span>
                                    </span>
                            </div>

                            <script>
                                var nome1 = new Spry.Widget.ValidationTextField("nome1", "custom", {validateOn:["blur"], maxChars: 150});
                            </script>

                            <div class="form-group col-md-3">
                                <input type="radio" name="document" value="CPF" id="cpf" onclick="changeDocType()" <?php if(empty($_POST)) { if(strlen($data['cpf_cnpj'])==14){echo 'checked';} } else { if(!empty($empresa->getCpf_cnpj())) if(strlen($empresa->getCpf_cnpj())==14){echo 'checked';} } ?>> CPF 
                                <input type="radio" name="document" value="CNPJ" id="cnpj" onclick="changeDocType()" <?php if(empty($_POST)) { if(strlen($data['cpf_cnpj'])>14){echo 'checked';} } else { if(!empty($empresa->getCpf_cnpj())) if(strlen($empresa->getCpf_cnpj())>14){echo 'checked';} } ?>> CNPJ <br>
                                <div id="documentfield"></div>
                            </div>

                            <script type="text/javascript">
                                

                                function changeDocType() {
                                    var cpf = document.getElementById("cpf").checked;
                                    var cnpj = document.getElementById("cnpj").checked;

                                    document.getElementById("documentfield").innerHTML = '<span id="cpf_cnpj" class="textfieldHintState">'
                                +    '<input class="form-control" size="20" name="cpf_cnpj" id="cpf_cnpj_field" type="text" placeholder="" >'
                                +    '<span class="textfieldInvalidFormatMsg">Formato inválido de entrada</span>'
                                +'</span>';

                                    if (cpf) {
                                        document.getElementById("cpf_cnpj_field").placeholder = "000.000.000-00";
                                        var cpf_cnpj = new Spry.Widget.ValidationTextField("cpf_cnpj", "custom", {format:"custom", pattern: "000.000.000-00", validateOn:["blur"], useCharacterMasking: true, isRequired:false});
                                    } if (cnpj) {
                                        document.getElementById("cpf_cnpj_field").placeholder = "00.000.000/0000-00";
                                        var cpf_cnpj = new Spry.Widget.ValidationTextField("cpf_cnpj", "custom", {format:"custom", pattern: "00.000.000/0000-00", validateOn:["blur"], useCharacterMasking: true, isRequired:false});
                                    }
                                }
                            </script>
                            <?php if(!empty($_POST)) {
                                echo '<script>
                                var radio = document.getElementsByName("document");
                                if (radio[0].checked || radio[1].checked) { 
                                    changeDocType();
                                    document.getElementById("cpf_cnpj_field").value= "'.$empresa->getCpf_cnpj().'";
                                }
                                </script>';
                            } else {
                                echo '<script>
                                var radio = document.getElementsByName("document");
                                if (radio[0].checked || radio[1].checked) { 
                                    changeDocType();
                                    document.getElementById("cpf_cnpj_field").value= "'.$data['cpf_cnpj'].'";
                                }
                                </script>';
                            }
                            
                            ?>

                            <div class="form-group col-md-2">
                                <label for="telefone">Telefone: </label>
                                <select id=tipo1 onchange="changeTelType(1)">
                                    <option> </option>
                                    <option>Celular</option>
                                    <option>Fixo</option>
                                </select>
                                <div id="tel1field"></div>    
                            </div>

                            <script type="text/javascript">

                                if (<?php if(!empty($_POST)) { if(!empty ($empresa->getTelefone())) echo strlen($empresa->getTelefone()); else echo 0; } else { echo strlen($data['telefone']); } ?> >= 13) {
                                    if (<?php if(!empty($_POST)) { if(!empty ($empresa->getTelefone())) echo strlen($empresa->getTelefone()); else echo 0; } else { echo strlen($data['telefone']); } ?> > 13)
                                        document.getElementById("tipo1").value = "Celular";
                                    else
                                        document.getElementById("tipo1").value = "Fixo";
                                    changeTelType(1);
                                    document.getElementById("telefone1").value = "<?php if(!empty($_POST)) { if(!empty ($empresa->getTelefone())) echo $empresa->getTelefone(); } else { echo $data['telefone']; } ?>";
                                }

                                function changeTelType(i) {

                                    var tipo = document.getElementById("tipo"+i).value;

                                    document.getElementById("tel"+i+"field").innerHTML = '<span id="telefone1'+i+'" class="textfieldHintState">'
                                    +       '<input class="form-control" type="text" name="telefone'+i+'" id="telefone'+i+'" />'
                                    +       '<span class="textfieldInvalidFormatMsg">Formato inválido de entrada</span>'
                                    +'</span>';

                                    if(tipo == 'Celular'){
                                        document.getElementById("telefone"+i+"").placeholder = "(00)00000-0000";
                                        var telefone = new Spry.Widget.ValidationTextField("telefone1"+i, "custom", {format:"custom", pattern: "(00)90000-0000", validateOn:["blur"], useCharacterMasking: true, isRequired:false});
                                    }else if(tipo == 'Fixo') {
                                        document.getElementById("telefone"+i+"").placeholder = "(00)0000-0000";
                                        var telefone = new Spry.Widget.ValidationTextField("telefone1"+i, "custom", {format:"custom", pattern: "(00)0000-0000", validateOn:["blur"], useCharacterMasking: true, isRequired:false});
                                    } else document.getElementById("tel"+i+"field").innerHTML = "";
                                }
                            </script>


                            </fieldset>



                            <div class="control-group">
                                    <label class="control-label">Endereço(s):</label>
                                    <div class="controls">
                                        <label class="carousel-inner">
                                <?php

                                    echo '<table class="table table-striped">';
                                            echo '<thead>';
                                                echo '<tr>';
                                                    echo '<th scope="col"></th>';
                                                    echo '<th scope="col">Rua</th>';
                                                    echo '<th scope="col">Número</th>';
                                                    echo '<th scope="col">Bairro</th>';
                                                    echo '<th scope="col">Cidade</th>';
                                                    echo '<th scope="col">Estado</th>';
                                                    echo '<th scope="col">CEP</th>';
                                                    echo '<th scope="col"></th>';
                                                echo '</tr>';
                                            echo '</thead>';

                                            include_once '../../controller/enderecocontrole.php';
                                    $enderecoControle = new EnderecoControle();
                                    $data_fk = $enderecoControle->list_enderecosEmpresa($id);
                                    if ($data_fk != NULL) {
                                        foreach($data_fk as $row) if($row['ativo']) {
                                        //echo $row['rua'];


                                            echo '<tbody>';
                                                echo '<tr>';
                                                                  echo '<th scope="row">'. $row['id'] . '</th>';
                                                echo '<td>'. $row['rua'] . '</td>';
                                                echo '<td>'. $row['numero'] . '</td>';
                                                echo '<td>'. $row['bairro'] . '</td>';
                                                echo '<td>'. $row['cidade'] . '</td>';
                                                echo '<td>'. $row['estado'] . '</td>';
                                                echo '<td>'. $row['CEP'] . '</td>';
                                                echo '<td width=250>';
                                                echo '<a class="btn btn-warning" href="../Endereco/update_endereco.php?id='.$row['id'].'&empresa='.$id.'">Atualizar</a>';
                                                echo ' ';
                                                echo '<a class="btn btn-danger" href="../Endereco/delete_endereco.php?id='.$row['id'].'&empresa='.$id.'">Excluir</a>';
                                                echo '</td>';
                                                echo '</tr>';        
                                            echo '</tbody>';

                                        }
                                    }


                                        echo '</table>';

                                ?>
                                        </label>


                                <div class="form-actions" align="right">
                                    <?php echo '<a class="btn btn-default" href="../Endereco/create_endereco.php?empresa='.$id.'">Adicionar Endereço</a>' ?>
                                </div>

                                <br/>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success">Atualizar</button>
                                    <a href="list_empresa.php" type="btn" class="btn btn-default">Voltar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <script src="../../util/links/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="../../util/links/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="../../util/links/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        
        <?php 
        
        
        if(!empty($_POST))
            if(!empty($try))
                echo '<script> 
                    $(document).ready(function() {
                        $("#exampleModalCenter").modal("toggle");
                    });
                </script>';
            else
                echo '<script> 
                    $(document).ready(function() {
                        $("#confirmModal").modal().on("hidden.bs.modal", function (e) {
                            window.location.href = "list_empresa.php";
                        })
                        $("#confirmModal").modal("toggle");
                    });
                </script>';
        
        ?>
        
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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

                            if (strpos($try, "'nome'"))
                                echo 'O nome inserido já existe no banco de dados, e não pode ser cadastrado em duplicidade. Em caso de dúvidas, entre em contato com o suporte.';
                            elseif (strpos($try, "'cpf_cnpj'"))
                                echo 'O campo CPF/CNPJ inserido já existe no banco de dados, e não pode ser cadastrado em duplicidade. Em caso de dúvidas, entre em contato com o suporte.';

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
                            A empresa foi atualizada com sucesso!
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
