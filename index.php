<?php
declare(strict_types=1);

include_once "Controllers/Controller.php";
$action = null;

if (isset($_GET['action']) && !empty($_GET['action'])) {
    $action = $_GET['action'];
}

try {
    $controller = new Controller();

    $viewLoaded = false;

    if ($action == null) {
        // TODO : Renvoie code erreur
        // $viewLoaded = $controller->listAction();
    } else if ($action == 'subject') {

        // TODO : Lister les branches avec leurs champs
        $viewLoaded = $controller->getSubjects();

    } else if ($action == 'grade') {
        // TODO : lister les notes avec leurs champs
    } else if ($action == 'addGrade') {
        // TODO : ajout d'une note
    } else if ($action == 'deleteGrade') {
        // TODO : supression d'une note
    } else if ($action == 'subjectAverage') {
        // TODO : moyenne d'une branche
    }

    if (!$viewLoaded) {
        require_once('Views/404.php');
    }

} catch (Exception $e) {
    require_once('Views/500.php');
}
