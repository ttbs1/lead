<?php

require_once '../../util/conexao.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClienteControle
 *
 * @author Thiago
 */
class ClienteControle {
    function inserirCliente ($cliente) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO cliente (nome, cpf_cnpj, telefone1, telefone2, email, ativo) VALUES (?,?,?,?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($cliente->getNome(), $cliente->getCpf_cnpj(), $cliente->getTelefone1(), $cliente->getTelefone2(), $cliente->getEmail(), TRUE));
            $sql2 = "INSERT INTO registro (usuario_id, acao, tabela, identificacao, datahora) VALUES (?,?,?,?,?)";
            $q = $pdo->prepare($sql2);
            
            $date = new DateTime();
            $date->modify('-4 hours');
            $dateTime = $date->format("Y-m-d H:i:s");
            $q->execute(array($_SESSION['usuario_id'], 'Cadastro', 'Cliente', $cliente->getNome(), $dateTime));
            $pdo = conexao::desconectar();
        } catch (Exception $ex) {
            return 'Erro: '. $ex->getMessage();
        }
    }
    
    function updateCliente ($cliente, $id) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE cliente SET nome = ?, cpf_cnpj = ?, telefone1 = ?, telefone2 = ?, email = ?, ativo = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($cliente->getNome(), $cliente->getCpf_cnpj(), $cliente->getTelefone1(), $cliente->getTelefone2(), $cliente->getEmail(), TRUE, $id));
            $sql2 = "INSERT INTO registro (usuario_id, acao, tabela, identificacao, datahora) VALUES (?,?,?,?,?)";
            $q = $pdo->prepare($sql2);
            
            
            $date = new DateTime();
            $date->modify('-4 hours');
            $dateTime = $date->format("Y-m-d H:i:s");
            
            $q->execute(array($_SESSION['usuario_id'], 'Atualização', 'Cliente', $cliente->getNome(), $dateTime));
            $pdo = conexao::desconectar();
        } catch (Exception $ex) {
            return 'Erro: '. $ex->getMessage();
        }
    }
    
       /* {
       $pdo = Banco::conectar();
       $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $sql = "SELECT * FROM pessoa where id = ?";
       $q = $pdo->prepare($sql);
       $q->execute(array($id));
       $data = $q->fetch(PDO::FETCH_ASSOC);
       Banco::desconectar();
    }
    
    
    function pesquisarPorNome ($nomeCliente) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $consulta = $pdo->query("SELECT * FROM cliente WHERE nome = '".$nomeCliente."'");
            $result = $consulta->fetch(PDO::FETCH_OBJ);
            return $result->id;
            $pdo = conexao::desconectar();
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    } */
    
    function pesquisarPorNome ($nomeCliente) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM cliente WHERE nome = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($nomeCliente));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();
            return $data;
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }
    
    function readCliente ($id) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM cliente WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();
            return $data;
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }
    
    function pesquisarCliente ($pesquisa) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM cliente WHERE nome = ?";
            //$sql = "SELECT * FROM cliente WHERE nome like ?";
            $q = $pdo->prepare($sql);
            //$pesquisa = '%'.$pesquisa.'%';
            $q->execute(array($pesquisa));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();
            return $data;
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }
    
    function deletePermCliente ($id) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql_fk = "DELETE FROM endereco WHERE cliente_id = ?";
            $sql = "DELETE FROM cliente WHERE id = ?";
            $q = $pdo->prepare($sql_fk);
            $q->execute(array($id));
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
            conexao::desconectar();
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }
    
    function deleteCliente ($id) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE cliente SET ativo = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array(FALSE,$id));
            $sql2 = "INSERT INTO registro (usuario_id, acao, tabela, identificacao, datahora) VALUES (?,?,?,?,?)";
            $q = $pdo->prepare($sql2);
            
            
            $date = new DateTime();
            $date->modify('-4 hours');
            $dateTime = $date->format("Y-m-d H:i:s");
            
            $cli = $this->readCliente($id);
            $q->execute(array($_SESSION['usuario_id'], 'Exclusão', 'Cliente', $cli['nome'], $dateTime));
            conexao::desconectar();
        } catch (Exception $ex) {
            return 'Erro: '. $ex->getMessage();
        }
    }
    
    function measureCliente ($pagina, $limite) {
        try {
            $pdo = conexao::conectar();
            $sql = 'SELECT COUNT(id) AS clientes FROM cliente;';
            $registros = $pdo->query($sql);
            $registros = $registros->fetchColumn();
            $paginas = $registros / $limite;
            $inicio = $pagina - 1;
            $inicio = $inicio * $limite;
            conexao::desconectar();
            return [
                "inicio" => $inicio,
                "paginas" => $paginas,
            ];
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }
    
    function findInPageLimitCliente ($inicio, $limite) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = 'SELECT * FROM cliente ORDER BY nome ASC LIMIT '.$inicio.', '.$limite;
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
    
    function listCliente ( ) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = 'SELECT * FROM cliente WHERE ativo = 1 ORDER BY nome ASC';
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
    
}