<?php


class Database
{
    private $db;

    /**
     * Constructeur
     * @param bool $withErrors
     */
    public function __construct(bool $withErrors = false)
    {
        $this->db = new PDO("mysql:host=localhost;dbname=weba_te3;charset=UTF8", "root", "");
        if ($withErrors) {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }
    }

    /**
     * Renvoie toutes les branches
     * @return array|false
     */
    public function getSubjects()
    {
        $stmt = $this->db->prepare("SELECT * FROM subject");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Renvoie une branche en particulier
     * @param $id
     * @return array|false
     */
    public function getSubject($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM subject WHERE idSubject = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Renvoie les notes associés à une branche
     * @param $id
     * @return array|false
     */
    public function getGradesFromSubject($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM grade WHERE idSubject = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Ajoute une note
     * @param $id
     * @param $value
     * @return false|string
     */
    public function addGrade($id, $value, $description)
    {
        $stmt = $this->db->prepare("INSERT INTO grade (idGrade, idSubject, description, value, date) VALUES (NULL,  :id, :description, :value, NOW()); ");
        $stmt->execute(["id" => $id, "value" => $value, "description"=>$description]);
        return $this->db->lastInsertId();
    }

    /**
     * Renvoie toutes les notes
     * @return array|false
     */
    public function getGrades()
    {
        $stmt = $this->db->prepare("SELECT * FROM grade");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Renvoie les informations d'une note
     * @param $id
     * @return mixed
     */
    public function getGrade($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM grade WHERE idGrade = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Supprime une note
     * @param $id
     * @return void
     */
    public function deleteGrade($id)
    {
        $stmt = $this->db->prepare("DELETE from grade where idGrade = :id");
        $stmt->execute(["id" => $id]);
    }

    /**
     * Renvoie la moyenne des notes d'une branche
     * @param $id
     * @return mixed
     */
    public function getAverage($id)
    {
        $stmt = $this->db->prepare("SELECT AVG(value) AS 'AVG' FROM grade WHERE idSubject = :id");
        $stmt->execute(["id" => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}