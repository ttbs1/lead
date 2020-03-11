<?php

if(!empty($_POST))
{
    include_once '../../controller/TarefaControle.php';
    include_once '../../controller/UsuarioControle.php';
    
    $id = $_POST['id'];
    $status = $_POST['status'];
    $tarefaControle = new TarefaControle();
    
    if(empty($_POST['usuario'])) {
        $tarefaControle->updateStatus($id, $status);
        //header("Location: ../detail_projeto.php?id=".$id);
    } else {
        $usuarioControle = new UsuarioControle();
        $usuario = $usuarioControle->readUsuarioByUserName($_POST['usuario']);
        
        $tarefaControle->updateStatus_designar($id, $status, $usuario['id']);
    }
    
}
?>