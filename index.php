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
        $code = 404;
        require_once('Views/template.php');
    } else if ($action == 'subject') {
        if (isset($_GET['fetchGrades']) && !isset($_GET['id'])) {
            if ($_GET['fetchGrades'] == 'true') {
                $viewLoaded = $controller->getGradesBySubjects();
            }else if ($_GET['fetchGrades'] == 'false') {
                $viewLoaded = $controller->getSubjects();
            }
            else {
                $code = 400;
                require_once('Views/template.php');
                $viewLoaded = true;
            }
        } else if (isset($_GET['id'])) {
            if (is_numeric($_GET['id'])) {
                // retour vide = 404
                // retour ok = 200
                if (isset($_GET['fetchGrades'])){
                    if ($_GET['fetchGrades'] == 'true') {
                        $viewLoaded = $controller->getGradesBySubjects($_GET['id']);
                    }else if ($_GET['fetchGrades'] == 'false') {
                        $viewLoaded = $controller->getSubject($_GET['id']);
                    }
                    else {
                        $code = 400;
                        require_once('Views/template.php');
                        $viewLoaded = true;
                    }
                } else {
                    $code = 200;
                    $viewLoaded = $controller->getSubject($_GET['id']);
                }



            } else {
                $code = 400;
                require_once('Views/template.php');
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
            $data = null;
            $code = 400;
            require_once('Views/template.php');
        }
        // TODO : ajout d'une note
    } else if ($action == 'deleteGrade') {
        // TODO : supression d'une note
    } else if ($action == 'subjectAverage') {
        // TODO : moyenne d'une branche
    }

    if (!$viewLoaded) {
        $code = 404;
        require_once('Views/template.php');
    }

} catch (Exception $e) {
    $code = 500;
    require_once('Views/template.php');
}
