<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cliente
 *
 * @author Thiago
 */
class Lead {
    private $campanha_id;
    private $nome;
    private $idade;
    private $telefone1;
    private $telefone2;
    private $email;
    
    function getCampanha_id() {
        return $this->campanha_id;
    }

    function setCampanha_id($campanha_id) {
        $this->campanha_id = $campanha_id;
    }
        
    function getNome() {
        return $this->nome;
    }

    function getIdade() {
        return $this->idade;
    }

    function getTelefone1() {
        return $this->telefone1;
    }

    function getTelefone2() {
        return $this->telefone2;
    }

    function getEmail() {
        return $this->email;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setIdade($idade) {
        $this->idade = $idade;
    }

    function setTelefone1($telefone1) {
        $this->telefone1 = $telefone1;
    }

    function setTelefone2($telefone2) {
        $this->telefone2 = $telefone2;
    }

    function setEmail($email) {
        $this->email = $email;
    }
}
