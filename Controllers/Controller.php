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
}