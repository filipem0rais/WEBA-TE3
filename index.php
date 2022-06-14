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
        if (isset($_GET['fetchGrades']) && !isset($_GET['id'])) {
            if ($_GET['fetchGrades'] == 'true' && $count == 2) {
                $viewLoaded = $controller->getGradesBySubjects();
            } else if ($_GET['fetchGrades'] == 'false' && $count == 2) {
                $viewLoaded = $controller->getSubjects();
            } else {
                $viewLoaded = $controller->errorCode(400);
            }
        } else if (isset($_GET['id'])) {
            if (is_numeric($_GET['id'])) {
                if (isset($_GET['fetchGrades'])) {
                    if ($_GET['fetchGrades'] == 'true') {
                        $viewLoaded = $controller->getGradesBySubjects($_GET['id']);
                    } else if ($_GET['fetchGrades'] == 'false') {
                        $viewLoaded = $controller->getSubject($_GET['id']);
                    } else {
                        $viewLoaded = $controller->errorCode(400);
                    }
                } else if ($count == 2) {
                    $viewLoaded = $controller->getSubject($_GET['id']);
                }
            }
        } else if ($count == 1) {
            $viewLoaded = $controller->getSubjects();
        } else {
            $viewLoaded = $controller->errorCode(400);
        }


    } else if ($action == 'grade') {
        if ($count > 2) {
            $viewLoaded = $controller->errorCode(400);
        } else if (!isset($_GET['bySubjectId']) && $count == 1) {
            $viewLoaded = $controller->getGrades();
        }

        if (isset($_GET['bySubjectId'])) {
            if (is_numeric($_GET['bySubjectId'])) {
                $viewLoaded = $controller->getGradesFromSubject($_GET['bySubjectId']);
            } else {
                $viewLoaded = $controller->errorCode(400);
            }
        }
        if (isset($_GET['byGradeId'])) {
            if (is_numeric($_GET['byGradeId'])) {
                $viewLoaded = $controller->getGrade($_GET['byGradeId']);
            } else {
                $viewLoaded = $controller->errorCode(400);
            }
        }
    } else if ($action == 'addGrade' ) {
        if ($count == 3) {
            if (isset($_GET['idSubject']) && isset($_GET['value']) && "PUT" == $_SERVER['REQUEST_METHOD']) {
                $id = $controller->clear_input($_GET['idSubject']);
                $value = $controller->clear_input($_GET['value']);
                $viewLoaded = $controller->addGrade($id, $value);
            } else {
                $viewLoaded = $controller->errorCode(400);
            }
        } else {
            $viewLoaded = $controller->errorCode(400);
        }

    } else if ($action == 'deleteGrade') {

        if ($count == 1) {
            $id = $controller->clear_input($_GET['idGrade']);
            if (isset($id)  && "DELETE" == $_SERVER['REQUEST_METHOD']) {
                $viewLoaded = $controller->deleteGrade($id);
            } else {
                $viewLoaded = $controller->errorCode(400);
            }
        } else {
            $viewLoaded = $controller->errorCode(400);
        }
    } else if ($action == 'subjectAverage') {
        if ($count == 1) {
            if (isset($_GET['idSubject']) && is_numeric($_GET['idSubject'])) {
                $id = $controller->clear_input($_GET['idSubject']);
                $viewLoaded = $controller->getAverage($id);
            } else {
                $viewLoaded = $controller->errorCode(400);
            }
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
