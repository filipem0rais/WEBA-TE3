<?php

include_once("Models/Database.php");

class Controller
{
    private $db;

    public function errorCode($code)
    {
        require_once('Views/template.php');
        return true;
    }

    private function loadDB()
    {
        if ($this->db == null) {
            try {
                $this->db = new Database();
            } catch (Exception $e) {
                $this->errorCode(500);
            }
        }
    }


    public function getSubjects(): bool
    {
        $this->loadDB();
        $data = $this->db->getSubjects();
        $code = 200;
        include_once "Views/template.php";
        return true;
    }

    public function addGrade($id, $value)
    {
        $this->loadDB();
        $data = $this->db->getSubject($id);
        if (is_numeric($id) && $value >= 1 && $value <= 6) {
            if (empty($data)) {
                return false;
            } else {
                $data = $this->db->addGrade($id, $value);
                $code = 201;
                include_once "Views/template.php";
                return true;
            }
        } else {
            $code = 400;
            include_once "Views/template.php";
            return true;
        }
    }

    public function deleteGrade($id)
    {
        $this->loadDB();
        $check = $this->db->getGrade($id);
        if (is_numeric($id)) {
            if (empty($check)) {
                return false;
            } else {
                $data = $this->db->deleteGrade($id);
                $code = 204;
                include_once "Views/template.php";
                return true;
            }
        } else {
            $code = 400;
            include_once "Views/template.php";
            return true;
        }
    }

    public function getGradesBySubjects($id = null): bool
    {
        $this->loadDB();
        if ($id == null) {
            $subjects = $this->db->getSubjects();
        } else {
            $subjects = $this->db->getSubject($id);
        }
        if (empty($subjects)) {
            return false;
        }
        for ($i = 0; $i < count($subjects); $i++) {
            $subjects[$i]['grades'] = $this->db->getGradesFromSubject($subjects[$i]['idSubject']);
        }

        $data = $subjects;

        $code = 200;
        include_once "Views/template.php";
        return true;
    }

    public function getSubject($id): bool
    {
        $this->loadDB();

        $data = $this->db->getSubject($id);
        if (empty($data)) {
            return false;
        }
        $code = 200;
        include_once "Views/template.php";
        return true;
    }

    function clear_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }

    public function getGrades(): bool
    {
        $this->loadDB();
        $data = $this->db->getGrades();
        if (empty($data)) {
            return false;
        }
        $code = 200;
        include_once "Views/template.php";
        return true;
    }

    public function getGradesFromSubject($id): bool
    {
        $this->loadDB();
        $data = $this->db->getGradesFromSubject($id);
        if (empty($data)) {
            return false;
        }
        $code = 200;
        include_once "Views/template.php";
        return true;
    }

    public function getGrade($id): bool
    {
        $this->loadDB();
        $data = $this->db->getGrade($id);
        if (empty($data)) {
            return false;
        }
        $code = 200;
        include_once "Views/template.php";
        return true;
    }

    public function getAverage($id): bool
    {
        $this->loadDB();
        $data = $this->db->getAverage($id)['AVG'];
        if (empty($data)) {
            return false;
        }
        $code = 200;
        include_once "Views/template.php";
        return true;
    }


}