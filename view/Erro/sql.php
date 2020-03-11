
<?php 

if(!empty($_GET['erro'])) {
    $erro = $_REQUEST['erro'];
}
if(!empty($_POST)) {
    $erro = $_POST['erro'];
}

?>

<html>
    <head>
        <title>PMA - Erro</title>
        <link rel="icon" href="../../util/icon.png" type="image/icon type">
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../../util/links/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="../../util/styles.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <form id="form" action="sql.php" method="POST">
            <input type="hidden" name="erro" value="<?php echo $erro ?>" />
        </form>
        <script>
            document.getElementById("form").submit();
        </script>
        
        <div class="container">
            <div class="jumbotron row">
                <div>
                    <h2>Erro no banco de dados</h2><h4><span class="badge badge-secondary">PMA - Project Management Aplication</span></h4>
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
            
            <div clas="span10 offset1">
                <div class="card">
                    <div class="card-header">
                        <h3 class="well"> Erro no banco de dados </h3>
                    </div>
                    <div class="card-body">
            
                        <?php echo $erro ?>
                        
                        <div style="text-align: center;"><img src="../../util/suporte-tecnico.png" /></div>
                        
                        <div class="form-actions">
                            <a href="../Home/home.php" type="btn" class="btn btn-default">Menu Principal</a>
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
