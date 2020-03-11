<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Projeto
 *
 * @author Thiago
 */
class Campanha {
    private $usuario_id;
    private $data_inicio;
    private $data_prevista;
    private $descricao;
    private $cidade;
    
    function getUsuario_id() {
        return $this->usuario_id;
    }

    function getData_inicio() {
        return $this->data_inicio;
    }

    function getData_prevista() {
        return $this->data_prevista;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getCidade() {
        return $this->cidade;
    }

    function setUsuario_id($usuario_id) {
        $this->usuario_id = $usuario_id;
    }

    function setData_inicio($data_inicio) {
        $this->data_inicio = $data_inicio;
    }

    function setData_prevista($data_prevista) {
        $this->data_prevista = $data_prevista;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setCidade($cidade) {
        $this->cidade = $cidade;
    }

}
