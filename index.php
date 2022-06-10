<?php
declare(strict_types=1);

require_once "Controllers/Controller.php";
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
        require_once('Views/404.php');
    } else if ($action == 'subject') {
        if (isset($_GET['fetchGrades'])) {
            if ($_GET['fetchGrades'] == 'true') {
                $viewLoaded = true;
            } else {
                require_once('Views/400.php');
                $viewLoaded = true;
            }
        } else {
            $viewLoaded = $controller->getSubjects();
        }
        // TODO : Lister les branches avec leurs champs


    } else if ($action == 'grade') {
        // TODO : lister les notes avec leurs champs
    } else if ($action == 'addGrade') {
        if (isset($_GET['idSubject']) && isset($_GET['value'])) {
            $idSubject = $_GET['idSubject'];
            $value = $_GET['value'];
            $viewLoaded = $controller->addGrade($idSubject,$value);
        }
        else
        {
            $viewLoaded = true;
            require_once('Views/400.php');
        }
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
