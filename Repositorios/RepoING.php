<?php

class RepoIng implements RepoCrud{
    private $conexion;
    
    public function __construct($conexion){
        $this->conexion = $conexion;
    }

    //METODOS CRUD
    public function create($ingrediente) {
        $name = $ingrediente->getName();
        $price = $ingrediente->getPrice();
        $stmt = $this->conexion->prepare("SELECT * FROM ingredients WHERE name = :name");
        $stmt->execute(["name"=>$name]);

        if ($stmt->rowCount() > 0) {
            echo "El ingrediente ya existe";
            return false;
        } else {
            $stmt = $this->conexion->prepare("INSERT INTO ingredients (name, price) VALUES (:name, :price)");
            return $stmt->execute(["name" => $name, "price" => $price]);
        }
        // Implementación del método create
    }

    public function update($name, $ingrediente) {
        // Implementación del método update
        $newName = $ingrediente->getName();
        $price = $ingrediente->getPrice();
        $photo = $ingrediente->getPhoto();

        $stmt = $this->conexion->prepare("UPDATE ingredients SET name = :newName, price = :price ,photo = :photo  WHERE name = :name");
        $result = $stmt->execute(["newName" => $newName, "price" => $price, "photo" => $photo, "name" => $name]);

        if ($result) {
            echo "Ingrediente actualizado correctamente";
            return true;
        } else {
            echo "No se ha podido actualizar el ingrediente";
            return false;
        }
    }

    public function updatePrice($name, $ingrediente) {
        // Implementación del método update
        $name = $ingrediente->getName();
        $price = $ingrediente->getPrice();

        $stmt = $this->conexion->prepare("UPDATE ingredients SET price = :price WHERE name = :name");
        $result = $stmt->execute(["price" => $price, "name" => $name]);

        if ($result) {
            echo "Ingrediente actualizado correctamente";
            return true;
        } else {
            echo "No se ha podido actualizar el ingrediente";
            return false;
        }
    }
    public function updateName($name, $ingrediente) {
        // Implementación del método update
        $nameNew = $ingrediente->getName();

        $stmt = $this->conexion->prepare("UPDATE ingredients SET name = :name WHERE name = :name");
        $result = $stmt->execute(["name" => $nameNew, "name" => $name]);

        if ($result) {
            echo "Ingrediente actualizado correctamente";
            return true;
        } else {
            echo "No se ha podido actualizar el ingrediente";
            return false;
        }
    }
    public function updatePhoto($name, $ingrediente) {
        // Implementación del método update
        $photo = $ingrediente->getPhoto();

        $stmt = $this->conexion->prepare("UPDATE ingredients SET photo = :photo WHERE name = :name");
        $result = $stmt->execute(["photo" => $photo, "name" => $name]);

        if ($result) {
            echo "Ingrediente actualizado correctamente";
            return true;
        } else {
            echo "No se ha podido actualizar el ingrediente";
            return false;
        }
    }
    
    public function delete($name) {
        // Implementación del método delete
        $stmt = $this->conexion->prepare("DELETE FROM ingredients WHERE name = :name");
        $result = $stmt->execute(["name" => $name]);

        if ($result) {
            echo "Ingrediente eliminado correctamente";
            return true;
        } else {
            echo "No se ha podido eliminar el ingrediente";
            return false;
        }
    }
    
    public function getById($name) {
        $stmt = $this->conexion->prepare("SELECT * FROM ingredients WHERE name = :name");
        $stmt->execute(["name" => $name]);

        if ($stmt->rowCount() > 0) {
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
            return new Ingredient($fila['idIngredients'],$fila['name'], $fila['price']);
        } else{
            return null;
        }
        // Implementación del método getById
    }
    
    public function getAll() {
        // Implementación del método getAll
        $stmt = $this->conexion->prepare("SELECT * FROM ingredients");
        $stmt->execute();
        
        $ingredientes = [];

        if ($stmt->rowCount() > 0) {
            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $ingredientes[] = new Ingredient($fila['name'], $fila['price']);
            }
            return $ingredientes;
        } else {
            return array();  // No hay ingredientes en la base de datos
            echo "No hay ingredientes en la base de datos";
        }
    }
    
    public function find($criterio) {
        // Implementación del método find
        $stmt = $this->conexion->prepare("SELECT * FROM ingredients WHERE name LIKE :criterio");
        $stmt->execute(["criterio" => $criterio]);

        $ingredientes = [];

        if ($stmt->rowCount() > 0) {
            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $ingredientes[] = new Ingredient($fila['name'], $fila['price']);
            }
            return $ingredientes;
        } else {
            return array();  // No hay ingredientes que coincidan con el criterio
            echo "No hay ingredientes que coincidan con el criterio";
        }
    }
    
    public function count() {
        // Implementación del método count
        $stmt = $this->conexion->prepare("SELECT COUNT(*) AS total FROM ingredients");
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
            return $fila['total'];
        } else {
            return 0;  // No hay ingredientes en la base de datos
            echo "No hay ingredientes en la base de datos";
        }
    }
    
}
