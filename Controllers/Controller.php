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
                include_once "Views/500.php";
                return;
            }
        }
    }

    public function getSubjects()
    {
        $this->loadDB();

        $subjects = $this->db->getSubjects();
        echo "1";
        include_once "Views/200.php";
        return true;
    }
}