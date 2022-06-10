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
    if ($action == 'subject') {
        if (isset($_GET['fetchGrades']) && !isset($_GET['id'])) {
            if ($_GET['fetchGrades'] == 'true') {
                $viewLoaded = $controller->getGradesBySubjects();
            } else if ($_GET['fetchGrades'] == 'false') {
                $viewLoaded = $controller->getSubjects();
            } else {
                $code = 400;
                require_once('Views/template.php');
                $viewLoaded = true;
            }
        } else if (isset($_GET['id'])) {
            if (is_numeric($_GET['id'])) {
                if (isset($_GET['fetchGrades'])) {
                    if ($_GET['fetchGrades'] == 'true') {
                        $viewLoaded = $controller->getGradesBySubjects($_GET['id']);
                    } else if ($_GET['fetchGrades'] == 'false') {
                        $viewLoaded = $controller->getSubject($_GET['id']);
                    } else {
                        $code = 400;
                        require_once('Views/template.php');
                        $viewLoaded = true;
                    }
                }
            }
        } else {
            $viewLoaded = $controller->getSubjects();
        }


    } else if ($action == 'grade') {
        // TODO : lister les notes avec leurs champs
        if (!isset($_GET['bySubjectId']) && !isset($_GET['byGradeId'])) {
            $controller->getGrades();
        }

        if (isset($_GET['bySubjectId'], $_GET['byGradeId'])) {
            $code = 400;
            require_once('Views/template.php');
            $viewLoaded = true;
        }

        if (isset($_GET['bySubjectId'])) {
            if (is_numeric($_GET['bySubjectId'])) {
                $controller->getGradesFromSubject($_GET['bySubjectId']);
            } else {
                $code = 400;
                require_once('Views/template.php');
                $viewLoaded = true;
            }
        }
        if (isset($_GET['byGradeId'])) {
            if (is_numeric($_GET['byGradeId'])) {
                $controller->getGrade($_GET['byGradeId']);
            } else {
                $code = 400;
                require_once('Views/template.php');
                $viewLoaded = true;
            }
        }


    } else if ($action == 'grade') {
        // TODO : lister les notes avec leurs champs
    } else if ($action == 'addGrade') {

        $id = $controller->test_input($_GET['idSubject']);
        $value = $controller->test_input($_GET['value']);

        if (isset($id) && isset($value)) {
            $viewLoaded = $controller->addGrade($id,$value);
        }
        else
        {
            $viewLoaded = true;
            $code = 400;
            require_once('Views/template.php');
        }
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
