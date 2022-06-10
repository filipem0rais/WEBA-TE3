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
}