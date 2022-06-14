<?php


class Database
{
    private $db;

    public function __construct(bool $withErrors = false)
    {
        $this->db = new PDO("mysql:host=localhost;dbname=weba_te3;charset=UTF8", "root", "");
        if ($withErrors) {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }
    }

    public function getSubjects()
    {
        $stmt = $this->db->prepare("SELECT * FROM subject");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSubject($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM subject WHERE idSubject = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGradesFromSubject($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM grade WHERE idSubject = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addGrade($id, $value)
    {
        $stmt = $this->db->prepare("INSERT INTO grade (idGrade, idSubject, description, value, date) VALUES (NULL,  :id, NULL, :value, NULL); ");
        $stmt->execute(["id" => $id, "value" => $value]);
        return $this->db->lastInsertId();
    }

    public function getGrades()
    {
        $stmt = $this->db->prepare("SELECT * FROM grade");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGrade($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM grade WHERE idGrade = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteGrade($id)
    {
        $stmt = $this->db->prepare("DELETE from grade where idGrade = :id");
        $stmt->execute(["id" => $id]);
    }

    public function getAverage($id)
    {
        $stmt = $this->db->prepare("SELECT AVG(value) AS 'AVG' FROM grade WHERE idSubject = :id");
        $stmt->execute(["id" => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}