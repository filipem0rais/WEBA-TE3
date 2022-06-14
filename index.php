<?php
declare(strict_types=1);

require_once "Controllers/Controller.php";
$controller = new Controller();
$action = null;
$viewLoaded = false;
$count = count($_GET);

if (isset($_GET['action']) && !empty($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $viewLoaded = $controller->errorCode(400);
}

try {
    if ($action == 'subject') {
        if ($count > 3) {
            $viewLoaded = $controller->errorCode(400);
        }
        if (isset($_GET['fetchGrades']) && !isset($_GET['idSubject'])) {
            if ($_GET['fetchGrades'] == 'true' && $count == 2) {
                $viewLoaded = $controller->getGradesBySubjects();
            } else if ($_GET['fetchGrades'] == 'false' && $count == 2) {
                $viewLoaded = $controller->getSubjects();
            } else {
                $viewLoaded = $controller->errorCode(400);
            }
        } else if (isset($_GET['idSubject'])) {

            if (is_numeric($_GET['idSubject'])) {
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
        } else if ($count == 1) {
            $viewLoaded = $controller->getSubjects();
        } else {
            $viewLoaded = $controller->errorCode(400);
        }


    } else if ($action == 'grade') {
        if ($count > 2) {
            $viewLoaded = $controller->errorCode(400);
        }
        if ($count == 1) {
            $viewLoaded = $controller->getGrades();
        } else if (!isset($_GET['bySubjectId']) && !isset($_GET['byGradeId'])) {
            $viewLoaded = $controller->errorCode(400);
        }

        if (isset($_GET['bySubjectId'])) {
            if (is_numeric($_GET['bySubjectId'])) {
                $id = $controller->clear_input($_GET['bySubjectId']);
                $viewLoaded = $controller->getGradesFromSubject($id);
            } else {
                $viewLoaded = $controller->errorCode(400);
            }
        }
        if (isset($_GET['byGradeId'])) {
            if (is_numeric($_GET['byGradeId'])) {
                $id = $controller->clear_input($_GET['byGradeId']);
                $viewLoaded = $controller->getGrade($id);
            } else {
                $viewLoaded = $controller->errorCode(400);
            }
        }
    } else if ($action == 'addGrade') {
        if (isset($_GET['idSubject']) && isset($_GET['value']) && "PUT" == $_SERVER['REQUEST_METHOD'] && $count == 3) {
            $id = $controller->clear_input($_GET['idSubject']);
            $value = $controller->clear_input($_GET['value']);
            $viewLoaded = $controller->addGrade($id, $value);
        } else {
            $viewLoaded = $controller->errorCode(400);
        }
    } else if ($action == 'deleteGrade') {
        if (isset($_GET['idGrade']) && "DELETE" == $_SERVER['REQUEST_METHOD'] && $count == 2) {

            $id = $controller->clear_input($_GET['idGrade']);
            $viewLoaded = $controller->deleteGrade($id);
        } else {
            $viewLoaded = $controller->errorCode(400);
        }
    } else if ($action == 'subjectAverage') {
        if (isset($_GET['idSubject']) && is_numeric($_GET['idSubject']) && $count == 2) {
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
