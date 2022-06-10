<?php

include_once("Models/Database.php");

class Controller
{
    private $db;

    private function loadDB()
    {
        if ($this->db == null) {
            try {
                $this->db = new Database();
            } catch (Exception $e) {
                $code = 500;
                include_once "Views/template.php";
                return;
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

    public function addGrade($id,$value)
    {
        $this->loadDB();
        $data = $this->db->getSubject($id);
        if (is_numeric($id) && $value >=1 && $value <=6) {
            if (empty($data)) {
                return false;
            } else {
                $data = $this->db->addGrade($id, $value);
                $code = 201;
                include_once "Views/template.php";
                return true;
            }
        }
        else{
            $code = 400;
            include_once "Views/template.php";
            return true;
        }
    }

    public function getGradesBySubjects($id = null): bool
    {
        $this->loadDB();

        if ($id == null){
            $subjects = $this->db->getSubjects();
        } else {
            $subjects = $this->db->getSubject($id);
        }

        if (empty($subjects)){
            return false;
        }

        for ($i = 0; $i < count($subjects); $i++) {
            //$subjects[$i]['grades'] = '2';
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
        if (empty($data)){
            return false;
        }
        $code = 200;
        include_once "Views/template.php";
        return true;
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function getGrades()
    {
        $this->loadDB();
        $data = $this->db->getGrades();
        if (empty($data)){
            return false;
        }
        $code = 200;
        include_once "Views/template.php";
        return true;
    }

    public function getGradesFromSubject($id){
        $this->loadDB();
        $data = $this->db->getGradesFromSubject($id);
        if (empty($data)){
            return false;
        }
        $code = 200;
        include_once "Views/template.php";
        return true;
    }

    public function getGrade($id)
    {
        $this->loadDB();
        $data = $this->db->getGrade($id);
        if (empty($data)){
            return false;
        }
        $code = 200;
        include_once "Views/template.php";
        return true;
    }
}