<?php
declare(strict_types=1);

require_once "Controllers/Controller.php";

$controller = new Controller();
$action = null;
$viewLoaded = false;
$count = count($_GET);

// Vérification qu'une action est définie
if (isset($_GET['action']) && !empty($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $viewLoaded = $controller->errorCode(400);
}

try {
    // Requêtes de branches
    if ($action == 'subject') {
        if ($count > 3) {
            $viewLoaded = $controller->errorCode(400);
        }
        // Si fetchGrades en paramètre mais pas idSubject
        if (isset($_GET['fetchGrades']) && !isset($_GET['idSubject']) && "GET" == $_SERVER['REQUEST_METHOD']) {
            if ($_GET['fetchGrades'] == 'true' && $count == 2) {
                $viewLoaded = $controller->getGradesBySubjects();
            } else if ($_GET['fetchGrades'] == 'false' && $count == 2) {
                $viewLoaded = $controller->getSubjects();
            } else {
                $viewLoaded = $controller->errorCode(400);
            }
            // Si idSubject est défini
        } else if (isset($_GET['idSubject'])) {
            if (is_numeric($_GET['idSubject']) && "GET" == $_SERVER['REQUEST_METHOD']) {
                $id = $controller->clear_input($_GET['idSubject']);
                if (isset($_GET['fetchGrades'])) {

                    if ($_GET['fetchGrades'] == 'true') {
                        $viewLoaded = $controller->getGradesBySubjects($id);
                    } else if ($_GET['fetchGrades'] == 'false') {
                        $viewLoaded = $controller->getSubject($id);
                    } else {
                        $viewLoaded = $controller->errorCode(400);
                    }
                } else if ($count == 2) {
                    $viewLoaded = $controller->getSubject($id);
                }
            } else {
                $viewLoaded = $controller->errorCode(400);
            }
            // Affichage de toutes les notes
        } else if ($count == 1) {
            $viewLoaded = $controller->getSubjects();
        } else {
            $viewLoaded = $controller->errorCode(400);
        }

        // Requêtes de notes
    } else if ($action == 'grade') {
        if ($count > 2) {
            $viewLoaded = $controller->errorCode(400);
        }
        if ($count == 1 && "GET" == $_SERVER['REQUEST_METHOD']) {
            $viewLoaded = $controller->getGrades();
        } else if (!isset($_GET['bySubjectId']) && !isset($_GET['byGradeId'])) {
            $viewLoaded = $controller->errorCode(400);
        }

        if (isset($_GET['bySubjectId'])) {
            if (is_numeric($_GET['bySubjectId']) && "GET" == $_SERVER['REQUEST_METHOD']) {
                $id = $controller->clear_input($_GET['bySubjectId']);
                $viewLoaded = $controller->getGradesFromSubject($id);
            } else {
                $viewLoaded = $controller->errorCode(400);
            }
        }
        if (isset($_GET['byGradeId'])) {
            if (is_numeric($_GET['byGradeId']) && "GET" == $_SERVER['REQUEST_METHOD']) {
                $id = $controller->clear_input($_GET['byGradeId']);
                $viewLoaded = $controller->getGrade($id);
            } else {
                $viewLoaded = $controller->errorCode(400);
            }
        }
        // Requête ajout d'une note
    } else if ($action == 'addGrade') {
        if (isset($_GET['idSubject'], $_GET['value']) && "PUT" == $_SERVER['REQUEST_METHOD'] && ($count == 4 || $count == 3)) {
            $id = $controller->clear_input($_GET['idSubject']);
            $value = $controller->clear_input($_GET['value']);
            if ($count == 4){
                if (isset ($_GET['description'])){
                    $description = $controller->clear_input($_GET['description']);
                } else {
                    $description = null;
                }
            }
            $viewLoaded = $controller->addGrade($id, $value, $description);
        } else {
            $viewLoaded = $controller->errorCode(400);
        }
        // Requête de suppression d'une note
    } else if ($action == 'deleteGrade') {
        if (isset($_GET['idGrade']) && "DELETE" == $_SERVER['REQUEST_METHOD'] && $count == 2) {

            $id = $controller->clear_input($_GET['idGrade']);
            $viewLoaded = $controller->deleteGrade($id);
        } else {
            $viewLoaded = $controller->errorCode(400);
        }
        // Requête pour la moyenne d'une branche
    } else if ($action == 'subjectAverage') {
        if (isset($_GET['idSubject']) && is_numeric($_GET['idSubject']) && "GET" == $_SERVER['REQUEST_METHOD'] && $count == 2) {
            $id = $controller->clear_input($_GET['idSubject']);
            $viewLoaded = $controller->getAverage($id);
        } else {
            $viewLoaded = $controller->errorCode(400);
        }
    }
    if (!$viewLoaded) {
        $controller->errorCode(404);
    }

} catch (Exception $e) {
    $controller->errorCode(500);
}
