<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of permissao
 *
 * @author Thiago
 */
class permissao {
    private $adm;
    private $cliente;
    private $empresa;
    private $endereco;
    private $iteracao;
    private $projeto;
    private $tarefa;
    private $tipoprojeto;
    private $usuario;
    
    function getAdm() {
        return $this->adm;
    }

    function setAdm($adm) {
        $this->adm = $adm;
    }
        
    function getCliente() {
        return $this->cliente;
    }

    function getEmpresa() {
        return $this->empresa;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function getIteracao() {
        return $this->iteracao;
    }

    function getProjeto() {
        return $this->projeto;
    }

    function getTarefa() {
        return $this->tarefa;
    }

    function getTipoprojeto() {
        return $this->tipoprojeto;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    function setEmpresa($empresa) {
        $this->empresa = $empresa;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    function setIteracao($iteracao) {
        $this->iteracao = $iteracao;
    }

    function setProjeto($projeto) {
        $this->projeto = $projeto;
    }

    function setTarefa($tarefa) {
        $this->tarefa = $tarefa;
    }

    function setTipoprojeto($tipoprojeto) {
        $this->tipoprojeto = $tipoprojeto;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
}
