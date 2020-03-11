<?php

require_once '../../util/conexao.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IteracaoControle
 *
 * @author Thiago
 */
class IteracaoControle {
    function list_iteracoesProjeto ($projeto_id) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM iteracao WHERE projeto_id = ? AND ativo = 1";
            $q = $pdo->prepare($sql);
            $q->execute(array($projeto_id));
            $data = NULL;
            while($row = $q->fetch(PDO::FETCH_ASSOC)){
                $data[] = $row;
            }
            conexao::desconectar();
            return $data;
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }
    
    function novaIteracao_Projeto ($usuario_id, $projeto_id, $descricao, $dataHora) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO iteracao (usuario_id, projeto_id, descricao, datahora, ativo) VALUES (?,?,?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($usuario_id, $projeto_id, $descricao, $dataHora, TRUE));
            $sql2 = "INSERT INTO registro (usuario_id, acao, tabela, identificacao, datahora) VALUES (?,?,?,?,?)";
            $q = $pdo->prepare($sql2);
            
            $date = new DateTime();
            $date->modify('-4 hours');
            $dateTime = $date->format("Y-m-d H:i:s");
            $q->execute(array($_SESSION['usuario_id'], 'Cadastro', 'Iteração', $descricao, $dateTime));
            $pdo = conexao::desconectar();
        } catch (Exception $ex) {
            return 'Erro: '. $ex->getMessage();
        }
    }
    
    function deletePermIteracao ($id) {
        //Delete do banco:
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM iteracao WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
            conexao::desconectar();
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }
    
    function deleteIteracao ($id) {
        //Delete do banco:
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE iteracao SET ativo = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array(FALSE, $id));
            $sql2 = "INSERT INTO registro (usuario_id, acao, tabela, identificacao, datahora) VALUES (?,?,?,?,?)";
            $q = $pdo->prepare($sql2);
            
            $date = new DateTime();
            $date->modify('-4 hours');
            $data = $this->readIteracao($id);
            $dateTime = $date->format("Y-m-d H:i:s");
            $q->execute(array($_SESSION['usuario_id'], 'Exclusão', 'Iteração', $data['descricao'], $dateTime));
            conexao::desconectar();
        } catch (Exception $ex) {
            return 'Erro: '. $ex->getMessage();
        }
    }
    
    function readIteracao ($id) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM iteracao WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();
            return $data;
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }
    
    function updateIteracao ($id, $descricao, $dataHora) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE iteracao SET descricao = ?, datahora = ?, ativo = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($descricao, $dataHora, TRUE, $id));
            $sql2 = "INSERT INTO registro (usuario_id, acao, tabela, identificacao, datahora) VALUES (?,?,?,?,?)";
            $q = $pdo->prepare($sql2);
            
            $date = new DateTime();
            $date->modify('-4 hours');
            $dateTime = $date->format("Y-m-d H:i:s");
            $q->execute(array($_SESSION['usuario_id'], 'Atualização', 'Iteração', $descricao, $dateTime));
            $pdo = conexao::desconectar();
        } catch (Exception $ex) {
            return 'Erro: '. $ex->getMessage();
        }
    }
}
