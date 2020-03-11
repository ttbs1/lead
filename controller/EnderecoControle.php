<?php

require_once '../../util/conexao.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EnderecoControle
 *
 * @author Thiago
 */
class EnderecoControle {
    function inserirEnderecoClienteSemId ($cliente,$endereco) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO endereco (cliente_id, rua, numero, bairro, CEP, cidade, estado) VALUES (?,?,?,?,?,?,?)";
            $q = $pdo->prepare($sql);
            $clienteControle = new ClienteControle();
            $result = $clienteControle->pesquisarPorNome($cliente->getNome());
            $q->execute(array($result['id'],$endereco->getRua(), $endereco->getNumero(), $endereco->getBairro(), $endereco->getCEP(), $endereco->getCidade(), $endereco->getEstado()));
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }
    
    function inserirEndereco ($endereco,$tipo) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if (strcmp($tipo, "empresa") == 0) {
                $id = $pdo->query("SELECT MAX(id) FROM empresa");
                $id = $id->fetchColumn();
                $sql = "INSERT INTO endereco (empresa_id, rua, numero, bairro, CEP, cidade, estado, ativo) VALUES (?,?,?,?,?,?,?,?)";
                $q = $pdo->prepare($sql);
                $q->execute(array($id,$endereco->getRua(), $endereco->getNumero(), $endereco->getBairro(), $endereco->getCEP(), $endereco->getCidade(), $endereco->getEstado(), TRUE));
                
                include_once 'EmpresaControle.php';
                $empresaControle = new EmpresaControle();
                $empresa = $empresaControle->readEmpresa($id);
                $sql2 = "INSERT INTO registro (usuario_id, acao, tabela, identificacao, datahora) VALUES (?,?,?,?,?)";
                $q = $pdo->prepare($sql2);
                
                $date = new DateTime();
                $date->modify('-4 hours');
                $dateTime = $date->format("Y-m-d H:i:s");
                $q->execute(array($_SESSION['usuario_id'], 'Cadastro', 'Endereço-Empresa', $empresa['nome'], $dateTime));
            } else if (strcmp($tipo, "cliente") == 0) {
                $id = $pdo->query("SELECT MAX(id) FROM cliente");
                $id = $id->fetchColumn();
                $sql = "INSERT INTO endereco (cliente_id, rua, numero, bairro, CEP, cidade, estado, ativo) VALUES (?,?,?,?,?,?,?,?)";
                $q = $pdo->prepare($sql);
                $q->execute(array($id,$endereco->getRua(), $endereco->getNumero(), $endereco->getBairro(), $endereco->getCEP(), $endereco->getCidade(), $endereco->getEstado(), TRUE));
                
                include_once 'ClienteControle.php';
                $clienteControle = new ClienteControle();
                $cli = $clienteControle->readCliente($id);
                $sql2 = "INSERT INTO registro (usuario_id, acao, tabela, identificacao, datahora) VALUES (?,?,?,?,?)";
                $q = $pdo->prepare($sql2);
                
                $date = new DateTime();
                $date->modify('-4 hours');
                $dateTime = $date->format("Y-m-d H:i:s");
                $q->execute(array($_SESSION['usuario_id'], 'Cadastro', 'Endereço-Cliente', $cli['nome'], $dateTime));
            }
            $pdo = conexao::desconectar();
        } catch (Exception $ex) {
            return 'Erro: '. $ex->getMessage();
        }
    }
    
    function inserirEnderecoCliente ($cliente_id,$endereco) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO endereco (cliente_id, rua, numero, bairro, CEP, cidade, estado, ativo) VALUES (?,?,?,?,?,?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($cliente_id,$endereco->getRua(), $endereco->getNumero(), $endereco->getBairro(), $endereco->getCEP(), $endereco->getCidade(), $endereco->getEstado(), TRUE));
            $sql2 = "INSERT INTO registro (usuario_id, acao, tabela, identificacao, datahora) VALUES (?,?,?,?,?)";
            $q = $pdo->prepare($sql2);
            include_once 'ClienteControle.php';
            $clienteControle = new ClienteControle();
            $cli = $clienteControle->readCliente($cliente_id);
            
            $date = new DateTime();
            $date->modify('-4 hours');
            $dateTime = $date->format("Y-m-d H:i:s");
            $q->execute(array($_SESSION['usuario_id'], 'Cadastro', 'Endereço-Cliente', $cli['nome'], $dateTime));
            $pdo = conexao::desconectar();
        } catch (Exception $ex) {
            return 'Erro: '. $ex->getMessage();
        }
    }
    
    function inserirEnderecoEmpresa ($empresa_id,$endereco) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO endereco (empresa_id, rua, numero, bairro, CEP, cidade, estado, ativo) VALUES (?,?,?,?,?,?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($empresa_id,$endereco->getRua(), $endereco->getNumero(), $endereco->getBairro(), $endereco->getCEP(), $endereco->getCidade(), $endereco->getEstado(), TRUE));
            $sql2 = "INSERT INTO registro (usuario_id, acao, tabela, identificacao, datahora) VALUES (?,?,?,?,?)";
            $q = $pdo->prepare($sql2);
            include_once 'EmpresaControle.php';
            $empresaControle = new EmpresaControle();
            $empresa = $empresaControle->readEmpresa($empresa_id);
            
            $date = new DateTime();
            $date->modify('-4 hours');
            $dateTime = $date->format("Y-m-d H:i:s");
            $q->execute(array($_SESSION['usuario_id'], 'Cadastro', 'Endereço-Empresa', $empresa['nome'], $dateTime));
            $pdo = conexao::desconectar();
        } catch (Exception $ex) {
            return 'Erro: '. $ex->getMessage();
        }
    }
    
    function updateEndereco ($id, $endereco) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE endereco SET rua = ?, numero = ?, bairro = ?, CEP = ?, cidade = ?, estado = ?, ativo = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($endereco->getRua(), $endereco->getNumero(), $endereco->getBairro(), $endereco->getCEP(), $endereco->getCidade(), $endereco->getEstado(), TRUE, $id));
            
            $data = $this->readEndereco($id);
            if ($data['empresa_id']) {
                include_once 'EmpresaControle.php';
                $empresaControle = new EmpresaControle();
                $empresa = $empresaControle->readEmpresa($data['empresa_id']);
                $sql3 = "INSERT INTO registro (usuario_id, acao, tabela, identificacao, datahora) VALUES (?,?,?,?,?)";
                $q = $pdo->prepare($sql3);
                
                $date = new DateTime();
                $date->modify('-4 hours');
                $dateTime = $date->format("Y-m-d H:i:s");
                $q->execute(array($_SESSION['usuario_id'], 'Atualização', 'Endereço-Empresa', $empresa['nome'], $dateTime));
            } elseif($data['cliente_id']) {
                $sql3 = "INSERT INTO registro (usuario_id, acao, tabela, identificacao, datahora) VALUES (?,?,?,?,?)";
                $q = $pdo->prepare($sql3);
                include_once 'ClienteControle.php';
                $clienteControle = new ClienteControle();
                $cli = $clienteControle->readCliente($data['cliente_id']);
                
                $date = new DateTime();
                $date->modify('-4 hours');
                $dateTime = $date->format("Y-m-d H:i:s");
                $q->execute(array($_SESSION['usuario_id'], 'Atualização', 'Endereço-Cliente', $cli['nome'], $dateTime));
            }
            
            $pdo = conexao::desconectar();
        } catch (Exception $ex) {
            return 'Erro: '. $ex->getMessage();
        }
    }
    
    function readEndereco ($id) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM endereco WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();
            return $data;
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }    
    
    function list_enderecosCliente ($cliente_id) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM endereco WHERE cliente_id = ? AND ativo = 1";
            $q = $pdo->prepare($sql);
            $q->execute(array($cliente_id));
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
    
    function list_enderecosEmpresa ($empresa_id) {
        try {
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM endereco WHERE empresa_id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($empresa_id));
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
    
    function deletePermEndereco ($id) {
        try{
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM endereco WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
            
            conexao::desconectar();
        } catch (Exception $ex) {
            echo 'Erro: '. $ex->getMessage();
        }
    }
    
    function deleteEndereco ($id) {
        try{
            $pdo = conexao::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE endereco SET ativo = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array(FALSE,$id));
            $data = $this->readEndereco($id);
            if ($data['empresa_id']) {
                include_once 'EmpresaControle.php';
                $empresaControle = new EmpresaControle();
                $empresa = $empresaControle->readEmpresa($data['empresa_id']);
                $sql3 = "INSERT INTO registro (usuario_id, acao, tabela, identificacao, datahora) VALUES (?,?,?,?,?)";
                $q = $pdo->prepare($sql3);
                
                $date = new DateTime();
                $date->modify('-4 hours');
                $dateTime = $date->format("Y-m-d H:i:s");
                $q->execute(array($_SESSION['usuario_id'], 'Exclusão', 'Endereço-Empresa', $empresa['nome'], $dateTime));
            } elseif($data['cliente_id']) {
                $sql3 = "INSERT INTO registro (usuario_id, acao, tabela, identificacao, datahora) VALUES (?,?,?,?,?)";
                $q = $pdo->prepare($sql3);
                include_once 'ClienteControle.php';
                $clienteControle = new ClienteControle();
                $cli = $clienteControle->readCliente($data['cliente_id']);
                
                $date = new DateTime();
                $date->modify('-4 hours');
                $dateTime = $date->format("Y-m-d H:i:s");
                $q->execute(array($_SESSION['usuario_id'], 'Exclusão', 'Endereço-Cliente', $cli['nome'], $dateTime));
            }
            conexao::desconectar();
        } catch (Exception $ex) {
            return 'Erro: '. $ex->getMessage();
        }
    }
}
