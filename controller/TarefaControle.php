<?php

require_once '../../util/conexao.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TarefaControle
 *
 * @author Thiago
 */
class TarefaControle {
    function list_tarefasTipoProjeto ($tipoProjeto_id) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM tarefa WHERE tipoprojeto_id = ? AND ativo = 1";
            $q = $pdo->prepare($sql);
            $q->execute(array($tipoProjeto_id));
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
    
    function list_tarefasProjeto ($projeto_id) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM tarefa WHERE projeto_id = ? AND ativo = 1";
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
    
        function list_tarefasUsuario ($usuario_id) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM tarefa WHERE usuario_id = ? AND ativo = 1 ORDER BY projeto_id";
            $q = $pdo->prepare($sql);
            $q->execute(array($usuario_id));
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
    
    function novaTarefa_TipoProjeto ($tarefa,$tipoProjeto_id) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO tarefa (tipoprojeto_id, descricao, peso, ativo) VALUES (?,?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($tipoProjeto_id,$tarefa->getDescricao(), $tarefa->getPeso(), TRUE));
            
            
            $sql2 = "INSERT INTO registro (usuario_id, acao, tabela, identificacao, datahora) VALUES (?,?,?,?,?)";
            $q = $pdo->prepare($sql2);
            
            $date = new DateTime();
            $date->modify('-4 hours');
            $dateTime = $date->format("Y-m-d H:i:s");
            $q->execute(array($_SESSION['usuario_id'], 'Cadastro', 'Tarefa', $tarefa->getDescricao(), $dateTime));
            $pdo = conexao::desconectar();
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }
    
    function novaTarefa_Projeto ($tarefa) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $projeto_id = $pdo->query("SELECT MAX(id) FROM projeto");
            $projeto_id = $projeto_id->fetchColumn();
            $sql = "INSERT INTO tarefa (projeto_id, descricao, peso, status, ativo) VALUES (?,?,?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($projeto_id,$tarefa['descricao'], $tarefa['peso'], 'a', TRUE));
            $pdo = conexao::desconectar();
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }
    
    function novaTarefa_Projeto2 ($tarefa,$projeto_id) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO tarefa (projeto_id, descricao, peso, status, ativo) VALUES (?,?,?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($projeto_id,$tarefa->getDescricao(), $tarefa->getPeso(), 'a', TRUE));
            
            $sql2 = "INSERT INTO registro (usuario_id, acao, tabela, identificacao, datahora) VALUES (?,?,?,?,?)";
            $q = $pdo->prepare($sql2);
            
            $date = new DateTime();
            $date->modify('-4 hours');
            $dateTime = $date->format("Y-m-d H:i:s");
            $q->execute(array($_SESSION['usuario_id'], 'Cadastro', 'Tarefa', $tarefa->getDescricao(), $dateTime));
            $pdo = conexao::desconectar();
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }
    
    function updateTarefa ($id, $tarefa) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE tarefa SET descricao = ?, peso = ? , ativo = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($tarefa->getDescricao(), $tarefa->getPeso(), TRUE, $id));
            
            $sql2 = "INSERT INTO registro (usuario_id, acao, tabela, identificacao, datahora) VALUES (?,?,?,?,?)";
            $q = $pdo->prepare($sql2);
            
            $date = new DateTime();
            $date->modify('-4 hours');
            $dateTime = $date->format("Y-m-d H:i:s");
            $q->execute(array($_SESSION['usuario_id'], 'Atualização', 'Tarefa', $tarefa->getDescricao(), $dateTime));
            $pdo = conexao::desconectar();
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }
    
    function updateStatus ($id, $status) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            session_start();
            $data = $this->readTarefa($id);
            
            if (strcmp($data['status'], $status) != 0) {
                $sql = "UPDATE tarefa SET status = ?, usuario_id = ? WHERE id = ?";
                $q = $pdo->prepare($sql);
                
                $q->execute(array($status, $_SESSION['usuario_id'], $id));
                
                $sql3 = "INSERT INTO registro (usuario_id, acao, tabela, identificacao, datahora) VALUES (?,?,?,?,?)";
                $q = $pdo->prepare($sql3);
                
                $date = new DateTime();
                $date->modify('-4 hours');
                $dateTime = $date->format("Y-m-d H:i:s");
                $q->execute(array($_SESSION['usuario_id'], 'Atualização', 'Tarefa-Status', 'Projeto '.$data['projeto_id'].'->'.$data['descricao'], $dateTime));
            }
            $pdo = conexao::desconectar();
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }
    
        function updateStatus_designar ($id, $status, $usuario) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $data = $this->readTarefa($id);
            
            if (strcmp($data['status'], $status) != 0) {
                $sql = "UPDATE tarefa SET status = ?, usuario_id = ? WHERE id = ?";
                $q = $pdo->prepare($sql);
                $q->execute(array($status, $usuario, $id));
                
                $sql3 = "INSERT INTO registro (usuario_id, acao, tabela, identificacao, datahora) VALUES (?,?,?,?,?)";
                $q = $pdo->prepare($sql3);
                
                $date = new DateTime();
                $date->modify('-4 hours');
                $dateTime = $date->format("Y-m-d H:i:s");
                $q->execute(array($_SESSION['usuario_id'], 'Atualização', 'Tarefa-Status', 'Projeto '.$data['projeto_id'].'->'.$data['descricao'], $dateTime));
            }
            $pdo = conexao::desconectar();
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }
    
    function deletePermTarefa ($id) {
        //Delete do banco:
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM tarefa WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
            conexao::desconectar();
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }
    
    function deleteTarefa ($id) {
        //Delete do banco:
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE tarefa SET ativo = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array(FALSE, $id));
            
            $data = $this->readTarefa($id);
            
            $sql2 = "INSERT INTO registro (usuario_id, acao, tabela, identificacao, datahora) VALUES (?,?,?,?,?)";
            $q = $pdo->prepare($sql2);
            
            $date = new DateTime();
            $date->modify('-4 hours');
            $dateTime = $date->format("Y-m-d H:i:s");
            $q->execute(array($_SESSION['usuario_id'], 'Exclusão', 'Tarefa', $data['descricao'], $dateTime));
            conexao::desconectar();
        } catch (Exception $ex) {
            return 'Erro: '. $ex->getMessage();
        }
    }
    
    function readTarefa ($id) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM tarefa WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();
            return $data;
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }
}
