<?php $this->layout('layout'); ?>


<?php $this->start('welcome') ?>
<h1>Welcome!</h1>
<p>Hello World </p>
<?php $this->stop() ?>

<?php $this->start('listado') ?>
<h1>Lista de Usuarios</h1>
<ul>
<?php foreach ($users as $user): ?>
        <li><?= $user['name']; ?> - <?= $user['email']; ?> </li>
    <?php endforeach; ?>

</ul>
<?php $this->stop() ?>

<?php $this->start('header') ?>
<header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">SANIMAL</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="?menu=mantenimiento">MANTENIMIENTO <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            LISTADOS
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="?menu=listadoanimales">ANIMALES</a>
                            <a class="dropdown-item" href="?menu=listadovacunas">VACUNACIONES</a>
                        </div>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                </form>
            </div>
        </nav>
    </header>
<?php $this->stop() ?>

<?php $this->start('footer') ?>
    <footer class="bg-light text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p>Copyright © SIU</p>
                </div>
            </div>
        </div>
    </footer>
<?php $this->stop() ?>

<?php $this->start('body') ?>
    <div class="container">
        
    </div>
<?php $this->stop() ?>

<?php $this->start('3rayas') ?>
        <div id="juegan">
            <div class="titulo">Turno de:</div>
            <span class="jugador">X</span>
            <span class="jugador">O</span>
        </div>
        
        <table id="tablero">
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
<?php $this->stop()?>        