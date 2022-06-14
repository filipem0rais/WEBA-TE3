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

    public function clear_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }

    public function sendResponse($code, $data = null)
    {
        include_once "Views/template.php";
        return true;
    }

    public function getSubjects(): bool
    {
        $this->loadDB();
        $data = $this->db->getSubjects();
        return $this->sendResponse(200, $data);
    }

    public function addGrade($id, $value): bool
    {
        $this->loadDB();
        $data = $this->db->getSubject($id);
        if (is_numeric($id) && $value >= 1 && $value <= 6) {
            if (empty($data)) {
                return false;
            } else {
                $data = $this->db->addGrade($id, $value);
                return $this->sendResponse(201, $data);
            }
        } else {
            return $this->sendResponse(400);
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
                return $this->sendResponse(204, $data);
            }
        } else {
            return $this->sendResponse(400);
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
        return $this->sendResponse(200, $subjects);
    }

    public function getSubject($id): bool
    {
        $this->loadDB();

        $data = $this->db->getSubject($id);
        if (empty($data)) {
            return false;
        }
        return $this->sendResponse(200, $data);
    }


    public function getGrades(): bool
    {
        $this->loadDB();
        $data = $this->db->getGrades();
        if (empty($data)) {
            return false;
        }
        return $this->sendResponse(200, $data);
    }

    public function getGradesFromSubject($id): bool
    {
        $this->loadDB();
        $data = $this->db->getGradesFromSubject($id);
        if (empty($data)) {
            return false;
        }
        return $this->sendResponse(200, $data);
    }

    public function getGrade($id): bool
    {
        $this->loadDB();
        $data = $this->db->getGrade($id);
        if (empty($data)) {
            return false;
        }
        return $this->sendResponse(200, $data);
    }

    public function getAverage($id): bool
    {
        $this->loadDB();
        $data = $this->db->getAverage($id)['AVG'];
        if (empty($data)) {
            return false;
        }
        return $this->sendResponse(200, $data);
    }


}