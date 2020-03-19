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
    private $campanha;
    private $lead;
    private $usuario;
    
    function getAdm() {
        return $this->adm;
    }

    function getCampanha() {
        return $this->campanha;
    }

    function getLead() {
        return $this->lead;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function setAdm($adm) {
        $this->adm = $adm;
    }

    function setCampanha($campanha) {
        $this->campanha = $campanha;
    }

    function setLead($lead) {
        $this->lead = $lead;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
}
