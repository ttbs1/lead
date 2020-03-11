
<?php
session_start(); 
if((substr_compare($_SESSION['permissao']['empresa'], '0', 0, 1)) == 0) {
    header("Location: ../Erro/permissao.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../util/links/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>PMA - Detalhar Empresa</title>
    <link rel="icon" href="../../util/icon.png" type="image/icon type">
    <link href="../../util/aligns.css" rel="stylesheet" type="text/css" />
    <link href="../../util/styles.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="container">

        <div class="jumbotron row">
            <div>
                <h2>Detalhamento da Empresa</h2><h4><span class="badge badge-secondary">PMA - Project Management Aplication</span></h4>
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


        <div class="span10 offset1">
                    <?php

                    if(!empty($_GET['id']))
                    {
                        $id = $_REQUEST['id'];
                        include '../../controller/EmpresaControle.php';
                        $empresaControle = new EmpresaControle();
                        $data = $empresaControle->readEmpresa($id);
                    }
                    if(!empty($_POST))
                    {

                    }

                    ?>
            <div class="pbuttons" align="right">
                <?php

                    echo ' ';
                    echo '<a class="btn btn-outline-warning" href="update_empresa.php?id='.$data['id'].'">Atualizar</a>';
                    echo ' ';
                    echo '<a class="btn btn-outline-danger" href="delete_empresa.php?id='.$data['id'].'">Excluir</a>';

                ?>

            </div>


            <div class="card">
            <div class="card-header">
                <h3 class="well">Informações da Empresa</h3> 
                <div align="right"> 

                </div>
            </div>
            <div class="container">
            <div class="form-horizontal">
                <div class="control-group">
                    <label class="control-label">Nome</label>
                    <div class="controls">
                        <label class="carousel-inner">
                            <?php echo $data['nome'];?>
                        </label>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">CPF/CNPJ</label>
                    <div class="controls">
                        <label class="carousel-inner">
                            <?php echo $data['cpf_cnpj'];?>
                        </label>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Telefone</label>
                    <div class="controls">
                        <label class="carousel-inner">
                            <?php echo $data['telefone'];?>
                        </label>
                    </div>
                </div>

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
                                    echo '<th scope="col">Atualizar</th>';
                                    echo '<th scope="col">Excluir</th>';
                                echo '</tr>';
                            echo '</thead>';

                    include '../../controller/enderecocontrole.php';
                    $enderecoControle = new EnderecoControle();
                    $data_fk = $enderecoControle->list_enderecosEmpresa($data['id']);
                    if ($data_fk != NULL) {
                        foreach($data_fk as $row) if($row['ativo']) {


                            echo '<tbody>';
                                echo '<tr>';
                                                  echo '<th scope="row">'. $row['id'] . '</th>';
                                echo '<td>'. $row['rua'] . '</td>';
                                echo '<td>'. $row['numero'] . '</td>';
                                echo '<td>'. $row['bairro'] . '</td>';
                                echo '<td>'. $row['cidade'] . '</td>';
                                echo '<td>'. $row['estado'] . '</td>';
                                echo '<td>'. $row['CEP'] . '</td>';
                                echo ' ';
                                echo '<td width=80><a class="btn btn-outline-warning btn-sm" href="../Endereco/update_endereco.php?id='.$row['id'].'&empresa='.$data['id'].'">Atualizar</a></td>';
                                echo ' ';
                                echo '<td width=80><a class="btn btn-outline-danger btn-sm" href="../Endereco/delete_endereco.php?id='.$row['id'].'&empresa='.$data['id'].'">Excluir</a></td>';
                                echo '</tr>';        
                            echo '</tbody>';

                        }
                    }


                        echo '</table>';

                ?>
                        </label>
                    </div>
                </div>

                <div class="form-actions" align="right">
                    <?php echo '<a class="btn btn-default" href="../Endereco/create_endereco.php?empresa='.$data['id'].'">Adicionar Endereço</a>' ?>
                </div>

                <br/>
                <div class="form-actions">
                    <a href="../Home/home.php" type="btn" class="btn btn-default">Menu Principal</a>
                    <a href="list_empresa.php" type="btn" class="btn btn-default">Voltar</a>
                </div>
              </div>
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