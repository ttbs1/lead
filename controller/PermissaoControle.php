<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PermissaoControle
 *
 * @author Thiago
 */
class PermissaoControle {
    function inserirPermissao ($pdo, $permissao) {
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO permissao (adm, lead, campanha, usuario) VALUES (?,?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($permissao->getAdm(), $permissao->getLead(), $permissao->getCampanha(), $permissao->getUsuario()));
            $id = $pdo->query("SELECT MAX(id) FROM permissao");
            $id = $id->fetchColumn();
            return array (
                0=>1,
                1=>$id
            );
        } catch (Exception $ex) {
            return array(
                0=>NULL,
                1=>$ex->getMessage()
            );
        }
    }
    
    function deletePermissao ($id) {
        try{
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM permissao WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
            conexao::desconectar();
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }
    
    function readPermissao ($id) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM permissao WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();
            return $data;
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }
    
    function updatePermissao ($permissao, $id) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE permissao SET adm = ?, lead = ?, campanha = ?, usuario = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($permissao->getAdm(), $permissao->getLead(), $permissao->getCampanha(), $permissao->getUsuario(), $id));
            $pdo = conexao::desconectar();
        } catch (Exception $ex) {
            return 'Erro: '. $ex->getMessage();
        }
    }
}
