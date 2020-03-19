<?php


session_start();


if(!empty($_GET['id'])) {
    $campanha_id = $_REQUEST['id'];
}
if(!empty($_POST)) {
    include_once '../../domain/lead.php';
    include_once '../../controller/leadcontrole.php';

    $lead = new Lead();
    if (filter_has_var(INPUT_POST, "nome")) {
        $lead->setNome($_POST['nome']);  
    }
    if (filter_has_var(INPUT_POST, "idade")) {
        $lead->setIdade($_POST['idade']);  
    }
    if (filter_has_var(INPUT_POST, "telefone1")) {
        $lead->setTelefone1($_POST['telefone1']);  
    }
    if (filter_has_var(INPUT_POST, "telefone2")) {
        $lead->setTelefone2($_POST['telefone2']);  
    }
    if (filter_has_var(INPUT_POST, "email")) {
        $lead->setEmail($_POST['email']);
        if ($lead->getEmail()=="")
            $lead->setEmail(NULL);
    }
    
    if(!empty($_POST['campanha_id'])) {
        $lead->setCampanha_id($_POST['campanha_id']);
    }

    $leadControle = new LeadControle();
    $try = $leadControle->inserirLead($lead);
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
        <script src="../../util/links/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="../../util/links/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="../../util/links/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        
        <script type="text/javascript" src="../../util/validationForm.js"></script>
        
        <script type="text/javascript" src="../../util/jquery.mask.js"></script>
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
                <form id="teste" class="form-horizontal needs-validation" novalidate action="cadastro.php" method="post">

                <fieldset>
                <legend>Meus dados:</legend>
                
                <input type="hidden" name="campanha_id" value="<?php echo $campanha_id ?>" />
                
                <div class="form-group col-md-8">
                    <label for="nome">Nome: </label>
                    <input class="form-control" type="text" required name="nome" id="nome" placeholder="Nome" value="" pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ][A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ\s*?]{3,50}" />
                    <div class="valid-feedback">
                        Ok!
                    </div>
                    <div class="invalid-feedback">
                        Nome inválido.
                    </div>
                </div>
                
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
                    <input class="form-control telefone" type="text" inputmode="tel" pattern=".{13,14}" required name="telefone1" id="telefone1" placeholder="(00)00000-0000" />
                    <div class="valid-feedback">
                        Ok!
                    </div>
                    <div class="invalid-feedback">
                        Telefone inválido.
                    </div>
                </div>

                <div class="form-group col-md-2">
                    <label for="telefone">Telefone 02: </label>
                    <input class="form-control telefone" type="text" inputmode="tel" pattern=".{13,14}" name="telefone2" id="telefone2" placeholder="(00)00000-0000" />
                    <div class="invalid-feedback">
                        Telefone inválido.
                    </div>
                </div>
                
                <script type="text/javascript">
                    
                    var SPMaskBehavior = function (val) {
                        return val.replace(/\D/g, '').length === 11 ? '(00)00000-0000' : '(00)0000-00000';
                    },
                    spOptions = {
                        onKeyPress: function(val, e, field, options) {
                            field.mask(SPMaskBehavior.apply({}, arguments), options);
                        }
                    };

                    $('.telefone').mask(SPMaskBehavior, spOptions);
                    
                </script>

                <div class="form-group col-md-6">
                    <label for="email">E-Mail: </label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="exemplo@meudominio.com" value="" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" /><br>
                </div>
                
                
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
            else
                echo '<script> 
                    $(document).ready(function() {
                        $("#confirmModal").modal().on("hidden.bs.modal", function (e) {
                            window.location.href = "redirect.php";
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
                                echo 'O nome inserido já foi registrado!';
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
                  <h5 class="modal-title" id="exampleModalLongTitle">Cadastro realizado! </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="form-group col-md-8">
                            Obrigado por realizar o cadastro! Em breve entraremos em contato!
                    </div>
                    <div style="text-align: center;"><img src="../../util/confirma.png" height="175px" width="175px" /></div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                  <!--<a href="create_cliente.php" type="button" class="btn btn-primary" id="designar">Cadastrar Outro</a>-->
                </div>
              </div>
            </div>
        </div>
    <p></p>
  </body>
</html>
