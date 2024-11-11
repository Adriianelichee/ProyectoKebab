<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Modelos/User.php';
require_once __DIR__ . '/../Repositorios/RepoUser.php';

use League\Plates\Engine;

class HomeController {
    protected $templates;
    protected $repoUser;

    public function __construct() {
        // Usar __DIR__ para obtener la ruta absoluta del directorio actual
        $basePath = dirname(__DIR__);
        $templatePath = $basePath . DIRECTORY_SEPARATOR . 'Vista' . DIRECTORY_SEPARATOR . 'Plantillas';
        $this->templates = new Engine($templatePath);

        // Inicializar RepoUser (asumiendo que tienes una clase Conexion)
        $conexion = Conexion::getConection();
        $this->repoUser = new RepoUser($conexion);
    }
    
    /**
     * Renderiza la página "HOME" con una lista de usuarios.
     *
     * Este método obtiene todos los usuarios de la base de datos utilizando RepoUser,
     * luego renderiza la plantilla 'home' con los datos de los usuarios.
     *
     * @return void Este método no devuelve un valor, sino que imprime directamente la plantilla renderizada.
     */
    public function index() {
        $users = $this->repoUser->getAll();
        echo $this->templates->render('home', ['users' => $users]);
    }
}