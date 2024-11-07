<?php

class RepoOrders implements RepoCrud{
    private $conexion;

    public function __construct($conexion){
        $this->conexion = $conexion;
    }
    public function create($Order) {
        // Implementación del método create
        
    }

    public function update($id, $obj) {
        // Implementación del método update
    }

    public function delete($id) {
        // Implementación del método delete
    }

    public function getById($id) {
        // Implementación del método getById
    }

    public function getAll() {
        // Implementación del método getAll
    }

    public function find($criterio) {
        // Implementación del método find
    }

    public function count() {
        // Implementación del método count
    }
}
