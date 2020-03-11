<?php

session_start(); 
if((substr_compare($_SESSION['permissao']['empresa'], '0', 1, 1)) == 0) {
    header("Location: ../Erro/permissao.php");
}

if(!empty($_POST)) {
    include_once '../../domain/Empresa.php';
    include_once '../../domain/endereco.php';
    include_once '../../controller/EmpresaControle.php';
    include_once '../../controller/enderecocontrole.php';

    $empresa = new Empresa();
    
    $empresa->setNome($_POST['nome']);
    if (!empty($_POST['cpf_cnpj']))
        $empresa->setCpf_cnpj($_POST['cpf_cnpj']);
    if (filter_has_var(INPUT_POST, "telefone1")){
        $empresa->setTelefone($_POST['telefone1']);
    }

    $endereco = new Endereco();
    if (filter_has_var(INPUT_POST, "cep")) {
        $endereco->setCEP($_POST['cep']);
        if ($endereco->getCEP()=="")
            $endereco->setCEP(NULL);
    }
    if (filter_has_var(INPUT_POST, "rua")) {
        $endereco->setRua($_POST['rua']);
        if ($endereco->getRua()=="")
            $endereco->setRua(NULL);
    }
    if (filter_has_var(INPUT_POST, "numero")) {
        $endereco->setNumero($_POST['numero']);
        if ($endereco->getNumero()=="")
            $endereco->setNumero(NULL);
    }
    if (filter_has_var(INPUT_POST, "bairro")) {
        $endereco->setBairro($_POST['bairro']);  
        if ($endereco->getBairro()=="")
            $endereco->setBairro(NULL);
    }
    if (filter_has_var(INPUT_POST, "cidade")) {
        $endereco->setCidade($_POST['cidade']);
        if ($endereco->getCidade()=="")
            $endereco->setCidade(NULL);
    }
    if (filter_has_var(INPUT_POST, "uf")) {
        $endereco->setEstado($_POST['uf']);
        if ($endereco->getEstado()=="")
            $endereco->setEstado(NULL);
    }

    $empresaControle = new EmpresaControle();
    $try = $empresaControle->inserirEmpresa($empresa);
    if (!empty($endereco->getRua())) {
        $enderecoControle = new EnderecoControle();
        $try = $enderecoControle->inserirEndereco($endereco, "empresa");
    }
    //header("Location: list_empresa.php");
}
?>

<html>
    <head>
        <title>PMA - Cadastrar Empresa</title>
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
                <h2>Cadastro de Empresas</h2><h4><span class="badge badge-secondary">PMA - Project Management Aplication</span></h4>
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
                <h3 class="well"> Adicionar Empresa </h3>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="create_empresa.php" method="post">

                <fieldset>
                <legend>Nova Empresa</legend>
                
                <div class="form-group col-md-8">
                    <label for="nome">Nome: </label>
                        <span id="nome1" class="textfieldHintState">
                            <input class="form-control" type="text" name="nome" id="nome" placeholder="Nome" value="<?php if (!empty($_POST['nome'])) echo $_POST['nome'] ?>" />
                            <span class="textfieldMaxCharsMsg">Esse campo tem limite de 150 caracteres.</span>
                               <span class="textfieldRequiredMsg">Esse campo é obrigatório</span>
                        </span>
                </div>
                <script>
                    var nome1 = new Spry.Widget.ValidationTextField("nome1", "custom", {validateOn:["blur"], maxChars: 150});
                </script>
                
                <div class="form-group col-md-3">
                    <input type="radio" name="document" value="CPF" id="cpf" onclick="changeDocType()" <?php if(!empty($_POST)) if(!empty($empresa->getCpf_cnpj())) if(strlen($empresa->getCpf_cnpj())==14){echo 'checked';} ?>> CPF 
                    <input type="radio" name="document" value="CNPJ" id="cnpj" onclick="changeDocType()" <?php if(!empty($_POST)) if(!empty($empresa->getCpf_cnpj())) if(strlen($empresa->getCpf_cnpj())>14){echo 'checked';} ?>> CNPJ <br>
                    <div id="documentfield"></div>
                    
                    <script type="text/javascript">
                        var radio = document.getElementsByName("document");
                        if (radio[0].checked || radio[1].checked) { 
                            changeDocType();
                            document.getElementById("cpf_cnpj_field").value= "<?php if(!empty($_POST)) echo $empresa->getCpf_cnpj()?>";
                        };
                                
                                
                        function changeDocType() {
                            var cpf = document.getElementById("cpf").checked;
                            var cnpj = document.getElementById("cnpj").checked;

                            document.getElementById("documentfield").innerHTML = '<span id="cpf_cnpj" class="textfieldHintState">'
                        +    '<input class="form-control" name="cpf_cnpj" id="cpf_cnpj_field" type="text" placeholder="" value="">'
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
                </div>
                
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
                        
                    <div class="form-group row" style="margin-left: 3px">
                        <div class="form-group col-md-2">
                            <label for="cep">CEP: </label>
                                <span id="cep1" class="textfieldHintState">
                                    <input type="text" class="form-control" name="cep" id="cep" placeholder="CEP" value="" />
                                    <span class="textfieldMaxCharsMsg">Esse campo tem limite de 9 caracteres.</span>
                                </span>
                        </div>
                        <div class="form-group col-md-6">
                        <label for="rua">Rua: </label>
                            <span id="rua1" class="textfieldHintState">
                                <input type="text" class="form-control" name="rua" id="rua" placeholder="Rua" value="" />
                                <span class="textfieldMaxCharsMsg">Esse campo tem limite de 85 caracteres.</span>
                                <span class="textfieldRequiredMsg">Esse campo é obrigatório</span>
                            </span>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="numero">Numero: </label>
                                <span id="numero1" class="textfieldHintState">
                                    <input type="text" class="form-control" name="numero" id="numero" placeholder="Numero" value="" />
                                    <span class="textfieldMaxCharsMsg">Esse campo tem limite de 7 caracteres.</span>
                                </span>
                        </div>
                          
                        <div class="form-group col-md-5"> 
                            <label for="bairro">Bairro: </label>
                                <span id="bairro1" class="textfieldHintState">
                                    <input type="text" class="form-control" name="bairro" id="bairro" placeholder="Bairro" value="" />
                                    <span class="textfieldMaxCharsMsg">Esse campo tem limite de 40 caracteres.</span>
                                </span>
                        </div>
                        
                        <div class="form-group col-md-5">
                            <label for="cidade">Cidade: </label>
                                <span id="cidade1" class="textfieldHintState">
                                    <input type="text" class="form-control" name="cidade" id="cidade" placeholder="Cidade" value="" />
                                    <span class="textfieldMaxCharsMsg">Esse campo tem limite de 40 caracteres.</span>
                                    <span class="textfieldRequiredMsg">Esse campo é obrigatório</span>
                                </span>
                        </div>
                    
                        <div class="form-group col-md-1">
                            <label for="uf">Estado: </label>
                                <span id="uf1" class="textfieldHintState">
                                    <input type="text" class="form-control" name="uf" id="uf" placeholder="UF" value="" />
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
                    <button type="button" style="min-width: 200px;" class="btn btn-outline-secondary" onclick="toogleAdress()" id='toogle' nome='toogle'> Não cadastrar endereço </button>
                    </fieldset>
                    <script>
                        function toogleAdress () {
                            x = document.getElementById("endereco");
                            
                            if (x.style.display == 'none') {
                                x.style.display = 'block';
                                document.getElementById("toogle").innerHTML = 'Não cadastrar endereço';
                                rua1 = new Spry.Widget.ValidationTextField("rua1", "custom", {validateOn:["blur"], maxChars: 85});
                                cidade1 = new Spry.Widget.ValidationTextField("cidade1", "custom", {validateOn:["blur"], maxChars: 40});
                                uf1 = new Spry.Widget.ValidationTextField("uf1", "custom", {format:"custom", pattern: "AA", validateOn:["blur"], useCharacterMasking: true});
                            } else {
                                x.style.display = 'none';
                                rua1.reset(); // remove the error message
                                rua1.destroy(); // remove the validation
                                cidade1.reset(); // remove the error message
                                cidade1.destroy(); // remove the validation
                                uf1.reset(); // remove the error message
                                uf1.destroy(); // remove the validation
                                document.getElementById("toogle").innerHTML = 'Cadastrar endereço';
                            }
                        }
                    </script>
                    
                    <?php 
                    if (!empty($_POST))
                        if(empty ($endereco->getRua()))
                            echo '<script>
                            setTimeout(function (){
                                document.getElementById("toogle").click();
                            }, 250); 
                            </script>';
                    ?>
                
                <div class="form-actions">
                    <br/>

                    <button type="submit" class="btn btn-success">Adicionar</button>
                    <a href="../Home/home.php" type="btn" class="btn btn-default">Menu Principal</a>
                    <a href="list_empresa.php" type="btn" class="btn btn-default">Voltar</a>

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
            if(!empty($try))
                echo '<script> 
                    $(document).ready(function() {
                        $("#exampleModalCenter").modal("toggle");
                    });
                </script>';
            elseif (!empty ($try2))
                echo '<script> 
                    $(document).ready(function() {
                        $("#exampleModalCenter").modal().on("hidden.bs.modal", function (e) {
                            window.location.href = "list_cliente.php";
                        })
                        $("#exampleModalCenter").modal("toggle");
                    });
                </script>';
            else
                echo '<script> 
                    $(document).ready(function() {
                        $("#confirmModal").modal().on("hidden.bs.modal", function (e) {
                            window.location.href = "list_cliente.php";
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
                            
                            if (!empty($try)) {
                                if (strpos($try, 'Duplicate')) { 

                                if (strpos($try, "'nome'"))
                                    echo 'O nome inserido já existe no banco de dados, e não pode ser cadastrado em duplicidade. Em caso de dúvidas, entre em contato com o suporte.';
                                elseif (strpos($try, "'cpf_cnpj'"))
                                    echo 'O campo CPF/CNPJ inserido já existe no banco de dados, e não pode ser cadastrado em duplicidade. Em caso de dúvidas, entre em contato com o suporte.';

                                } else { echo $try; }
                            } elseif (!empty($try2)) {
                                echo 'Dados inválidos ao cadastrar endereço. '.$try2;
                            }

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
                            A empresa foi cadastrada com sucesso!
                    </div>
                    <div style="text-align: center;"><img src="../../util/confirma.png" height="175px" width="175px" /></div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                  <a href="create_empresa.php" type="button" class="btn btn-primary" id="designar">Cadastrar Outra</a>
                </div>
              </div>
            </div>
        </div>
    
    <p></p>
  </body>
</html>
