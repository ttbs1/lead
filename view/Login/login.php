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
        
        
        <link href="login.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
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
        
        <div class="login-reg-panel">
            
            <div class="register-info-box">
                    <h2>Humberto Amorim</h2>
                    <p>Arquitetura e hurbanismo<br> algum texto legal etc</p>
            </div>
						
            <form action="login.php" method="post">
                <div class="white-panel">
                        <div class="login-show">
                                <h2>LOGIN</h2>
                                <input type="text" name="usuario" placeholder="Usuário">
                                <input type="password" name="senha" placeholder="Senha">
                                <button type="submit" value="Login">Login</button>
                                <a href=""><?php if($msg) {echo 'Usuário ou senha incorretos!';} ?></a>
                        </div>
                </div>
            </form>
	</div>
        
    </body>
</html>
