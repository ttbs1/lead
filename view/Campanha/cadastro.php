<?php


session_start();

if(!empty($_POST)) {
    include_once '../../domain/cliente.php';
    include_once '../../domain/endereco.php';
    include_once '../../controller/clientecontrole.php';
    include_once '../../controller/enderecocontrole.php';

    $cliente = new Cliente();
    if (filter_has_var(INPUT_POST, "nome")) {
        $cliente->setNome($_POST['nome']);  
    }
    if (filter_has_var(INPUT_POST, "cpf_cnpj")) {
        $cliente->setCpf_cnpj($_POST['cpf_cnpj']);  
    }
    if (filter_has_var(INPUT_POST, "telefone1")) {
        $cliente->setTelefone1($_POST['telefone1']);  
    }
    if (filter_has_var(INPUT_POST, "telefone2")) {
        $cliente->setTelefone2($_POST['telefone2']);  
    }
    if (filter_has_var(INPUT_POST, "email")) {
        $cliente->setEmail($_POST['email']);
        if ($cliente->getEmail()=="")
            $cliente->setEmail(NULL);
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

    $clienteControle = new ClienteControle();
    $try = $clienteControle->inserirCliente($cliente);
    
    
    if(empty($try)) {
        if (!empty($endereco->getRua())) {
            $enderecoControle = new EnderecoControle();
            $try = $enderecoControle->inserirEndereco($endereco, "cliente");
        }
    }
}
?>

<html>
    <head>
        <title>PMA - Cadastrar</title>
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
        <link href="cadastro.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
    <div class="container">
        <div class="jumbotron">
            <div>
                <h2>Cadastro</h2><h4><span class="badge badge-secondary">PMA - Project Management Aplication</span></h4>
            </div>
        
        <div clas="span10 offset1">
          <div class="card">
            <div class="card-header">
                <h3 class="well"> Cadastrar na campanha </h3>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="cadastro.php" method="post">

                <fieldset>
                <legend>Meus dados:</legend>
                
                <div class="form-group col-md-8">
                <label for="nome">Nome: </label>
                        <span id="nome1" class="textfieldHintState">
                            <input class="form-control" type="text" name="nome" id="nome" placeholder="Nome" value="<?php if(!empty($try)) echo $cliente->getNome(); ?>" />
                            <span class="textfieldMaxCharsMsg">Esse campo tem limite de 150 caracteres.</span>
                               <span class="textfieldRequiredMsg">Esse campo é obrigatório</span>
                        </span>
                </div>
                <script>
                    var nome1 = new Spry.Widget.ValidationTextField("nome1", "custom", {validateOn:["blur"], maxChars: 150});
                </script>
                
                <div class="form-group col-md-8">
                    <label for="formControlRange">Idade: </label>
                    <input type="range" min="16" max="100" value="16" class="form-control-range slider" id="idade" name="idade">
                    <div style="margin-top: 9px" id="demo"></div>
                </div>
                
                <script>
                    var slider = document.getElementById("idade");
                    var output = document.getElementById("demo");
                    output.innerHTML = slider.value; // Display the default slider value

                    // Update the current slider value (each time you drag the slider handle)
                    slider.oninput = function() {
                      output.innerHTML = this.value;
                    }
                </script>
                
                <div class="form-group col-md-2">
                    <label for="telefone">Telefone 01: </label>
                    <select id=tipo1 onchange="changeTelType(1)">
                        <option> </option>
                        <option>Celular</option>
                        <option>Fixo</option>
                    </select>
                    <div id="tel1field"></div>  
                </div>

                <div class="form-group col-md-2">
                    <label for="telefone">Telefone 02: </label>
                    <select id=tipo2 onchange="changeTelType(2)">
                        <option> </option>
                        <option>Celular</option>
                        <option>Fixo</option>
                    </select>
                    <div id="tel2field"></div>
                </div>
                
                <script type="text/javascript">
                    
                    if (<?php if(!empty($try)) { if(!empty($cliente->getTelefone1())) { echo strlen($cliente->getTelefone1()); } else echo 0;} else echo 0; ?> >= 13) {
                        if (<?php if(!empty($try)) { if(!empty($cliente->getTelefone1())) { echo strlen($cliente->getTelefone1()); } else echo 0;} else echo 0; ?> > 13)
                            document.getElementById("tipo1").value = "Celular";
                        else
                            document.getElementById("tipo1").value = "Fixo";
                        changeTelType(1);
                        document.getElementById("telefone1").value = "<?php if(!empty($try)) echo $cliente->getTelefone1() ?>";
                    }
                    if (<?php if(!empty($try)) { if(!empty($cliente->getTelefone2())) { echo strlen($cliente->getTelefone2()); } else echo 0;} else echo 0; ?> >= 13) {
                        if (<?php if(!empty($try)) { if(!empty($cliente->getTelefone2())) { echo strlen($cliente->getTelefone2()); } else echo 0;} else echo 0; ?> > 13)
                            document.getElementById("tipo2").value = "Celular";
                        else
                            document.getElementById("tipo2").value = "Fixo";
                        changeTelType(2);
                        document.getElementById("telefone2").value = "<?php if(!empty($try)) echo $cliente->getTelefone2() ?>";
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

                <div class="form-group col-md-6">
                    <label for="email">E-Mail: </label>
                            <span id="email1" class="textfieldHintState">
                                <input type="text" class="form-control" name="email" id="email" placeholder="exemplo@meudominio.com" value="<?php if(!empty($try)) echo $cliente->getEmail()?>" /><br>
                                <span class="textfieldInvalidFormatMsg">Endereço de e-mail inválido</span>
                            </span>
                </div>
                <script>
                    var email1 = new Spry.Widget.ValidationTextField("email1", "email", {validateOn:["blur"], maxChars: 85, isRequired: false});
                </script>
                
                
                </fieldset>
                
                
                <div class="form-actions">

                    <button type="submit" class="btn btn-success">Adicionar</button>

                </div>
            </form>
          </div>
        </div>
        </div>
    </div>
        
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
                  <h5 class="modal-title" id="exampleModalLongTitle">Dados adicionados: </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="form-group col-md-8">
                            O cliente foi cadastrado com sucesso!
                    </div>
                    <div style="text-align: center;"><img src="../../util/confirma.png" height="175px" width="175px" /></div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                  <a href="create_cliente.php" type="button" class="btn btn-primary" id="designar">Cadastrar Outro</a>
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
