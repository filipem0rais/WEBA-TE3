<?php

include_once("Subject.php");

class Database
{
    private $db;

    public function __construct(bool $withErrors = false) {
        $this->db = new PDO("mysql:host=localhost;dbname=weba_te3;charset=UTF8", "root", "");
        if ($withErrors) {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }
    }

    public function getSubjects(){
        $stmt = $this->db->prepare("SELECT * FROM subject");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getSubject($id){
        $stmt = $this->db->prepare("SELECT * FROM subject WHERE idSubject = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGradesFromSubject($id){
        $stmt = $this->db->prepare("SELECT * FROM grade WHERE idSubject = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}