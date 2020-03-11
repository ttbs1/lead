<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuario
 *
 * @author Thiago
 */
class Usuario {
    private $permissao_id;
    private $usuario;
    private $senha;
    
    function getPermissao_id() {
        return $this->permissao_id;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getSenha() {
        return $this->senha;
    }

    function setPermissao_id($permissao_id) {
        $this->permissao_id = $permissao_id;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }


}
