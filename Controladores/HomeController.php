<?php

use League\Plates\Engine;

class HomeController {
    protected $templates;

    public function __construct() {
        // Usar __DIR__ para obtener la ruta absoluta del directorio actual
        $basePath = dirname(__DIR__);
        $templatePath = $basePath . DIRECTORY_SEPARATOR . 'Vista' . DIRECTORY_SEPARATOR . 'Plantillas';
        $this->templates = new Engine($templatePath);
    }
    
/**
 * Renderiza la página "HOME" con una lista de usuarios.
 *
 * Este método obtiene todos los usuarios de la base de datos utilizando el modelo User,
 * luego renderiza la plantilla 'home' con los datos de los usuarios.
 *
 * @return void Este método no devuelve un valor, sino que imprime directamente la plantilla renderizada.
 */
    public function index() {
        $userModel = new User();
        $users = $userModel->getUsers();
        echo $this->templates->render('home', ['users' => $users]);
    }
}

