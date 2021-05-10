<?php

require_once "helpers/database.php";


class Controller {

    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }


    public function getTestQuestions($testId) {
        $stmt3 = $this->conn->prepare("SELECT * FROM questions WHERE test_id=? ");
        $stmt3->bindValue(1, $testId);
        $stmt3->execute();
        return $stmt3->fetchAll(PDO::FETCH_ASSOC);
    }

    public function savePaintQuestion($testId, $name, $text, $content = "") {
        $type = 'paint';
        $stmt = $this->conn->prepare('INSERT INTO questions (test_id, name, type, text, content) VALUES(:test_id, :name, :type, :text, :content)');
        $stmt->bindParam(':test_id', $testId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':type', $type);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function getNewTestId() {
        $stmt7 = $this->conn->prepare("SELECT MAX(id) as max_id FROM tests");
        $stmt7->execute();
        $invNum = $stmt7->fetch(PDO::FETCH_ASSOC);
        return $invNum['max_id'];
    }

}