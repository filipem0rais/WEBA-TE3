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

    public function getSubjects()
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

            $grades = $this->db->addGrade($id, $value);
            $data = "TODO LAST INSERT ID";
            $code = 201;
            include_once "Views/template.php";
            return true;

            $data = "tu commences a me détruire les couilles à mal écrire";
            $code = 400;
            include_once "Views/template.php";
            return true;

    }
}