<?php

include_once("Models/Database.php");

class Controller
{
    private $db;

    /**
     * Renvoie un code d'erreur
     * @param $code
     * @return bool
     */
    public function errorCode($code)
    {
        require_once('Views/template.php');
        return true;
    }

    /**
     * Prepare la connection à la base de donnée
     * @return void
     */
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

    /**
     * Nettoie les inputs
     * @param $data
     * @return string
     */
    public function clear_input($data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }

    /**
     * Renvoie une reponse avec un code http
     * @param $code
     * @param $data
     * @return bool
     */
    public function sendResponse($code, $data = null): bool
    {
        include_once "Views/template.php";
        return true;
    }

    /**
     * Renvoie la liste des branches
     * @return bool
     */
    public function getSubjects(): bool
    {
        $this->loadDB();
        $data = $this->db->getSubjects();
        if (!empty($data)) {
            return $this->sendResponse(200, $data);
        } else {
            return false;
        }

    }

    /**
     * Ajout d'une note
     * @param $value
     * @param $id
     * @return bool
     */
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

    /**
     * Supression d'une note
     * @param $id
     * @return bool
     */
    public function deleteGrade($id): bool
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

    /**
     * Renvoie la liste des notes
     * @param $id
     * @return bool
     */
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
        if (!empty($subjects)) {
            return $this->sendResponse(200, $subjects);
        } else {
            return false;
        }
    }

    /**
     * Renvoie une branche
     * @param $id
     * @return bool
     */
    public function getSubject($id): bool
    {
        $this->loadDB();

        $data = $this->db->getSubject($id);
        if (!empty($data)) {
            return $this->sendResponse(200, $data);
        } else {
            return false;
        }
    }

    /**
     * Renvoie les notes
     * @return bool
     */
    public function getGrades(): bool
    {
        $this->loadDB();
        $data = $this->db->getGrades();
        if (!empty($data)) {
            return $this->sendResponse(200, $data);
        } else {
            return false;
        }
    }

    /**
     * Renvoie les notes d'une branche
     * @param $id
     * @return bool
     */
    public function getGradesFromSubject($id): bool
    {
        $this->loadDB();
        $data = $this->db->getGradesFromSubject($id);
        if (!empty($data)) {
            return $this->sendResponse(200, $data);
        } else {
            return $this->sendResponse(204, $data);
        }
    }

    /**
     * Renvoie une note selon son id
     * @param $id
     * @return bool
     */
    public function getGrade($id): bool
    {
        $this->loadDB();
        $data = $this->db->getGrade($id);
        if (!empty($data)) {
            return $this->sendResponse(200, $data);
        } else {
            return false;
        }
    }

    /**
     * Renvoie la moyenne d'une branche
     * @param $id
     * @return bool
     */
    public function getAverage($id): bool
    {
        $this->loadDB();
        $data = $this->db->getAverage($id)['AVG'];
        if (!empty($data)) {
            return $this->sendResponse(200, $data);
        } else {
            return false;
        }
    }


}