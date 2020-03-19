<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>PMA - Login</title>
        <link rel="icon" href="../../util/icon.png" type="image/icon type">
        <link rel="stylesheet" href="../../util/links/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <!-- Custom styles for this template -->
        <link href="login.css" rel="stylesheet">
    </head>
    <body class="text-center">
        
        <?php
        
        session_start();
        
        if(!empty($_SESSION['usuario_id'])) {
            header("Location: ../home/home.php");
        }
        
        $msg = FALSE;
        if(!empty($_POST)) 
        {
            
            include_once '../../controller/UsuarioControle.php';
            
            $usuario = $_POST['usuario'];
            $senha = $_POST['senha'];
            
            $usuarioControle = new UsuarioControle();
            $auth = $usuarioControle->autenticarUsuario($usuario, $senha);
            
            if($auth) {
                $_SESSION['usuario_id'] = $auth['id'];
                
                header("Location: ../home/home.php");
            } else {
                $msg = true;
            }
            
        }
        ?>
        
        <form class="form-signin" action="login.php" method="post">
            <img class="mb-4" src="../../util/icon.png" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">Faça login</h1>
            <label for="usuario" class="sr-only">Usuário</label>
            <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Usuário" required="" autofocus="">
            <label for="senha" class="sr-only">Senha</label>
            <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" required="">
            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Lembrar meus dados
                </label>
            </div>
            <button class="btn btn-lg btn-secondary btn-block" type="submit">Entrar</button>
            <p class="mt-5 mb-3 text-muted">© 2020</p>
        </form>
    </body>
</html>
