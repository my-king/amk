<?php

class SistemaSecurity {

    private $nome;
    private $dao;
    private $logic;
    private $entity;
    private $vDao;
    private $vLogic;
    private $vEntity;
    private $config;
    private $conexoes;

    public function getNome() {
        return $this->nome;
    }

    public function getDao() {
        return $this->dao;
    }

    public function getLogic() {
        return $this->logic;
    }

    public function getEntity() {
        return $this->entity;
    }

    public function getVDao() {
        return $this->vDao;
    }

    public function getVLogic() {
        return $this->vLogic;
    }

    public function getVEntity() {
        return $this->vEntity;
    }

    public function getConfig() {
        return $this->config;
    }

    public function getConexoes() {
        return $this->conexoes;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setDao($dao) {
        $this->dao = $dao;
    }

    public function setLogic($logic) {
        $this->logic = $logic;
    }

    public function setEntity($entity) {
        $this->entity = $entity;
    }

    public function setVDao($vDao) {
        $this->vDao = $vDao;
    }

    public function setVLogic($vLogic) {
        $this->vLogic = $vLogic;
    }

    public function setVEntity($vEntity) {
        $this->vEntity = $vEntity;
    }

    public function setConexoes($conexoes) {
        $this->conexoes = $conexoes;
    }

    public function setConfig($config) {
        $this->config = $config;
    }

}