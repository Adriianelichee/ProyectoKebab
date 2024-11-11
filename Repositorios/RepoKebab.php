<?php

class RepoKebab implements RepoCrud{
    private $conexion;

    public function __construct($conexion){
        $this->conexion = $conexion;
    }
    public function create($kebab) {
        // Implementación del método create
            // Insertar el kebab
            $stmt = $this->conexion->prepare("INSERT INTO kebab (name, photo, basePrice) VALUES (:name, :photo, :basePrice)");
            $nombre = $kebab->getName();
            $foto = $kebab->getPhoto();
            $basePrice = $kebab->getBasePrice();
            $result = $stmt->execute(["name" => $nombre, "photo" => $foto, "basePrice" => $basePrice]);
        
            if (!$result) {
                echo "Error al insertar el kebab";
                $this->conexion->rollBack();
                return false;
            }
        
            $kebabId = $this->conexion->lastInsertId();
        
            // Insertar los ingredientes del kebab
            $stmt = $this->conexion->prepare("INSERT INTO ingredientsKebab (kebab_id, ingredient_id) VALUES (:kebab_id, :ingredient_id)");
            $ingredients = $kebab->getIngredients();
            foreach ($ingredients as $ingredient) {
                $result = $stmt->execute(["kebab_id" => $kebabId, "ingredient_id" => $ingredient->getId()]);
            }
        
            echo "Kebab creado con éxito";
            return true;
        }

    public function update($name, $kebab) {
        //Delete
        $stmt = $this->conexion->prepare("UPDATE kebab SET name = :name, photo = :photo, basePrice = :basePrice WHERE idKebabs = :id");
        $nombre = $kebab->getName();
        $foto = $kebab->getPhoto();
        $basePrice = $kebab->getBasePrice();
        $id = $kebab->getId();
        $result = $stmt->execute(["name" => $nombre, "photo" => $foto, "basePrice" => $basePrice, "id" => $id]);
        
        if ($result) {
            echo "Kebab actualizado correctamente";
            return true;
        }

        $stmt = $this->conexion->prepare("DELETE FROM ingredientsKebab WHERE kebab_id = :kebab_id");
        $result = $stmt->execute(["kebab_id" => $id]);
        
        if (!$result) {
            echo "Error al eliminar los ingredientes del kebab";
            return false;
        }
        
        // Insertar los ingredientes del kebab
        $stmt = $this->conexion->prepare("INSERT INTO ingredientsKebab (kebab_id, ingredient_id) VALUES (:kebab_id, :ingredient_id)");
        $ingredients = $kebab->getIngredients();
        foreach ($ingredients as $ingredient) {
            $result = $stmt->execute(["kebab_id" => $id, "ingredient_id" => $ingredient->getId()]);
            if (!$result) {
                echo "Error al insertar los ingredientes del kebab";
                return false;
            }
        }
        
        echo "Ingredientes actualizados correctamente";
    }

    public function delete($id) {
        // Implementación del método delete
        $stmt = $this->conexion->prepare("DELETE FROM kebab WHERE idKebabs = :id");
        $result = $stmt->execute(["id" => $id]);
        
        if ($result) {
            echo "Kebab eliminado correctamente";
            return true;
        }
        
        $stmt = $this->conexion->prepare("DELETE FROM ingredientsKebab WHERE kebab_id = :id");
        $result = $stmt->execute(["id" => $id]);
        
        if (!$result) {
            echo "Error al eliminar los ingredientes del kebab";
            return false;
        }
        
        echo "Ingredientes asociados al kebab eliminados correctamente";
    }

    public function getById($id) {
        // Obtener información básica del kebab
        $stmt = $this->conexion->prepare("SELECT * FROM kebab WHERE idKebabs = :id");
        $stmt->execute(["id" => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$result) {
            echo "Kebab no encontrado";
            return null;
        }
        
        // Crear instancia de Kebab con los datos obtenidos
        $kebab = new Kebab($result['idKebabs'], $result['name'], $result['photo'], $result['basePrice']);
        
        // Obtener los ingredientes del kebab
        $stmt = $this->conexion->prepare("SELECT i.* FROM ingredients i JOIN ingredientsKebab ik ON i.idIngredients = ik.ingredient_id WHERE ik.kebab_id = :id");
        $stmt->execute(["id" => $id]);
        $ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Añadir los ingredientes al kebab
        foreach ($ingredients as $ingredient) {
            $ingObj = new Ingredient($ingredient['idIngredients'], $ingredient['name'], $ingredient['price'], $ingredient['photo']);
            $kebab->addIngredient($ingObj);
        }
        
        return $kebab;
    }

    public function getAll() {
        $kebabs = [];
    
        // Obtener todos los kebabs
        $stmt = $this->conexion->prepare("SELECT * FROM kebab");
        $stmt->execute();
        $kebabsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($kebabsData as $kebabData) {
            // Crear instancia de Kebab
            $kebab = new Kebab($kebabData['idKebabs'], $kebabData['name'], $kebabData['photo'], $kebabData['basePrice']);
    
            // Obtener los ingredientes para este kebab
            $stmtIngredients = $this->conexion->prepare("SELECT i.* FROM ingredients i JOIN ingredientsKebab ik ON i.idIngredients = ik.ingredient_id WHERE ik.kebab_id = :kebab_id");
            $stmtIngredients->execute(['kebab_id' => $kebabData['idKebabs']]);
            $ingredientsData = $stmtIngredients->fetchAll(PDO::FETCH_ASSOC);
    
            // Añadir ingredientes al kebab
            foreach ($ingredientsData as $ingredientData) {
                $ingredient = new Ingredient(
                    $ingredientData['idIngredients'],
                    $ingredientData['name'],
                    $ingredientData['price'],
                    $ingredientData['photo']
                );
                $kebab->addIngredient($ingredient);
            }
    
            // Añadir el kebab completo al array de kebabs
            $kebabs[] = $kebab;
        }
    
        return $kebabs;
    }

    public function find($criterio) {
        $kebabs = [];
    
        // Preparar la consulta SQL para buscar kebabs por nombre
        $stmt = $this->conexion->prepare("SELECT * FROM kebab WHERE name LIKE :criterio");
        $stmt->execute(['criterio' => '%' . $criterio . '%']);
        $kebabsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($kebabsData as $kebabData) {
            // Crear instancia de Kebab
            $kebab = new Kebab($kebabData['idKebabs'], $kebabData['name'], $kebabData['photo'], $kebabData['basePrice']);
    
            // Obtener los ingredientes para este kebab
            $stmtIngredients = $this->conexion->prepare("SELECT i.* FROM ingredients i JOIN ingredientsKebab ik ON i.idIngredients = ik.ingredient_id WHERE ik.kebab_id = :kebab_id");
            $stmtIngredients->execute(['kebab_id' => $kebabData['idKebabs']]);
            $ingredientsData = $stmtIngredients->fetchAll(PDO::FETCH_ASSOC);
    
            // Añadir ingredientes al kebab
            foreach ($ingredientsData as $ingredientData) {
                $ingredient = new Ingredient(
                    $ingredientData['idIngredients'],
                    $ingredientData['name'],
                    $ingredientData['price'],
                    $ingredientData['photo']
                );
                $kebab->addIngredient($ingredient);
            }
    
            // Añadir el kebab completo al array de kebabs
            $kebabs[] = $kebab;
        }
        return $kebabs;
    }

    public function count() {
        // Implementación del método count
        $stmt = $this->conexion->prepare("SELECT COUNT(*) AS total FROM kebab");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
        return 0; // Devuelve 0 si no hay kebabs en la base de datos
    }
}
