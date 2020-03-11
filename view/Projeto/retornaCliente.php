<?php

require_once '../../util/conexao.php';

$pdo = conexao::conectar();
$dados = $pdo->prepare("SELECT nome FROM cliente WHERE ativo = 1 ORDER BY nome ASC");
$dados->execute();
echo json_encode($dados->fetchAll(PDO::FETCH_ASSOC));
conexao::desconectar();
?>