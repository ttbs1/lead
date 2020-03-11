<?php

require_once '../../util/conexao.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmpresaControle
 *
 * @author Thiago
 */
class EmpresaControle {
    function inserirEmpresa ($empresa) {
        try {
            $pdo = conexao::conectar();
            $enderecoControle = new EnderecoControle();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO empresa (nome, cpf_cnpj, telefone, ativo) VALUES (?,?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($empresa->getNome(), $empresa->getCpf_cnpj(), $empresa->getTelefone(), TRUE));
            $sql2 = "INSERT INTO registro (usuario_id, acao, tabela, identificacao, datahora) VALUES (?,?,?,?,?)";
            $q = $pdo->prepare($sql2);
            
            $date = new DateTime();
            $date->modify('-4 hours');
            $dateTime = $date->format("Y-m-d H:i:s");
            $q->execute(array($_SESSION['usuario_id'], 'Cadastro', 'Empresa', $empresa->getNome(), $dateTime));
            $pdo = conexao::desconectar();
        } catch (Exception $ex) {
            return 'Erro: '. $ex->getMessage();
        }
    }
    
    function listEmpresa ( ) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = 'SELECT * FROM empresa WHERE ativo = 1 ORDER BY nome ASC';
            $q = $pdo->prepare($sql);
            $q->execute();
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
    
    function deletePermEmpresa ($id) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql_fk = "DELETE FROM endereco WHERE empresa_id = ?";
            $sql = "DELETE FROM empresa WHERE id = ?";
            $q = $pdo->prepare($sql_fk);
            $q->execute(array($id));
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
            conexao::desconectar();
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }

    function deleteEmpresa ($id) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE empresa SET ativo = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array(FALSE,$id));
            $sql2 = "INSERT INTO registro (usuario_id, acao, tabela, identificacao, datahora) VALUES (?,?,?,?,?)";
            $q = $pdo->prepare($sql2);
            $empresa = $this->readEmpresa($id);
            
            $date = new DateTime();
            $date->modify('-4 hours');
            $dateTime = $date->format("Y-m-d H:i:s");
            $q->execute(array($_SESSION['usuario_id'], 'Exclusão', 'Empresa', $empresa['nome'], $dateTime));
            conexao::desconectar();
        } catch (Exception $ex) {
            return 'Erro: '. $ex->getMessage();
        }
    }
    
    function readEmpresa ($id) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM empresa WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();
            return $data;
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }
    
    function updateEmpresa ($empresa, $id) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE empresa SET nome = ?, cpf_cnpj = ?, telefone = ?, ativo = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($empresa->getNome(), $empresa->getCpf_cnpj(), $empresa->getTelefone(), TRUE, $id));
            $sql2 = "INSERT INTO registro (usuario_id, acao, tabela, identificacao, datahora) VALUES (?,?,?,?,?)";
            $q = $pdo->prepare($sql2);
            
            $date = new DateTime();
            $date->modify('-4 hours');
            $dateTime = $date->format("Y-m-d H:i:s");
            $q->execute(array($_SESSION['usuario_id'], 'Atualização', 'Empresa', $empresa->getNome(), $dateTime));
            $pdo = conexao::desconectar();
        } catch (Exception $ex) {
            return 'Erro: '. $ex->getMessage();
        }
    }
}
