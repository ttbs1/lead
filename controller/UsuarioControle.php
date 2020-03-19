<?php

require_once '../../util/conexao.php';
include_once '../../controller/permissaocontrole.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsuarioControle
 *
 * @author Thiago
 */
class UsuarioControle {
    
    function inserirUsuario ($usuario) {
        try {
            $pdo = conexao::conectar();
            $permissaoControle = new PermissaoControle();
            $permissao_id = $permissaoControle->inserirPermissao($pdo, $usuario->getPermissao_id());
            if ($permissao_id[0] != NULL) {
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO usuario (permissao_id, usuario, senha, ativo) VALUES (?,?,?,?)";
                $q2 = $pdo->prepare($sql);
                $q2->execute(array($permissao_id[1], $usuario->getUsuario(), $usuario->getSenha(), TRUE));
            } else {
                $pdo = conexao::desconectar();
                return 'Erro ao inserir permissões de usuário: '. $permissao_id[1];
            }
            $pdo = conexao::desconectar();
        } catch (Exception $ex) {
            return 'Erro: '. $ex->getMessage();
        }
    }
    
        function listUsuario () {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = 'SELECT * FROM usuario WHERE ativo = 1 ORDER BY usuario ASC';
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
    
    function deletePermUsuario ($id) {
        try{
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $sql = "SELECT (permissao_id) FROM usuario WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
            $permissao_id = $q->fetch(PDO::FETCH_ASSOC);
            
            $sql = "DELETE FROM usuario WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
            
            $sql = "DELETE FROM permissao WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($permissao_id['permissao_id']));
            
            conexao::desconectar();
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }
    
    function deleteUsuario ($id) {
        try{
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE usuario SET ativo = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array(FALSE, $id));
            
            $date = new DateTime();
            $date->modify('-4 hours');
            $dateTime = $date->format("Y-m-d H:i:s");
            
            $user = $this->readUsuario($id);
            $sql2 = "INSERT INTO registro (usuario_id, acao, tabela, identificacao, datahora) VALUES (?,?,?,?,?)";
            $q = $pdo->prepare($sql2);
            
            $q->execute(array($_SESSION['usuario_id'], 'Exclusão', 'Usuário', $user['usuario'], $dateTime));
            conexao::desconectar();
        } catch (Exception $ex) {
            return 'Erro: '. $ex->getMessage();
        }
    }
    
    function updateUsuario ($usuario, $id) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE usuario SET usuario = ?, senha = ?, ativo = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($usuario->getUsuario(), $usuario->getSenha(), TRUE, $id));
            $pdo = conexao::desconectar();
        } catch (Exception $ex) {
            return 'Erro: '. $ex->getMessage();
        }
    }
    
    function updateUsuario_semSenha ($usuario, $id) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE usuario SET usuario = ?, ativo = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($usuario->getUsuario(), TRUE, $id));
            $pdo = conexao::desconectar();
        } catch (Exception $ex) {
            return 'Erro: '. $ex->getMessage();
        }
    }
    
    function readUsuario ($id) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM usuario WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();
            return $data;
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }
    
    function readUsuarioByUserName ($usuario) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT (id) FROM usuario WHERE usuario = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($usuario));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();
            return $data;
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }
    
    function autenticarUsuario ($usuario, $senha) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT id, permissao_id FROM usuario WHERE usuario = ? and senha = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($usuario, $senha));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();
            return $data;
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }
    
}
