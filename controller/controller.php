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

    //studenti podla test ID
    public function getUsers($testId) {
        $stmt3 = $this->conn->prepare("SELECT * FROM users WHERE test_id=? ");
        $stmt3->bindValue(1, $testId);
        $stmt3->execute();
        return $stmt3->fetchAll(PDO::FETCH_ASSOC);
    }

    //otvorena odpoved
    public function saveAnswerQuestion($testId, $name, $text, $content) {
        $type = 'answer';
        $stmt = $this->conn->prepare('INSERT INTO questions (test_id, name, type, text, content) VALUES(:test_id, :name, :type, :text, :content)');
        $stmt->bindParam(':test_id', $testId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':content', $content);
        $stmt->execute();
        $stmt3 = $this->conn->prepare("SELECT * FROM questions WHERE test_id=? ");
        $stmt3->bindValue(1, $testId);
        $stmt3->execute();
        return $stmt3->fetchAll(PDO::FETCH_ASSOC);
    }

    //otazka s moznostami
    public function saveOptionsQuestion($testId, $name, $text, $content) {
        $type = 'options';
        $stmt = $this->conn->prepare('INSERT INTO questions (test_id, name, type, text, content) VALUES(:test_id, :name, :type, :text, :content)');
        $stmt->bindParam(':test_id', $testId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':content', $content);
        $stmt->execute();
        $stmt3 = $this->conn->prepare("SELECT * FROM questions WHERE test_id=? ");
        $stmt3->bindValue(1, $testId);
        $stmt3->execute();
        return $stmt3->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStudent($userId) {
        $stmt3 = $this->conn->prepare("SELECT * FROM users WHERE id=? ");
        $stmt3->bindValue(1, $userId);
        $stmt3->execute();
        return $stmt3->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getQuestionById($id) {
        $stmt3 = $this->conn->prepare("SELECT * FROM questions WHERE id=? ");
        $stmt3->bindValue(1, $id);
        $stmt3->execute();
        return $stmt3->fetch(PDO::FETCH_ASSOC);
    }

    public function getStudentAnswers($testId, $userId) {
        $stmt3 = $this->conn->prepare("SELECT * FROM answers WHERE user_id=? and test_id=? and handed=1");
        $stmt3->bindValue(1, $userId);
        $stmt3->bindValue(2, $testId);
        $stmt3->execute();
        return $stmt3->fetchAll(PDO::FETCH_ASSOC);
    }

    public function savePaintQuestion($testId, $name, $text, $content = "") {
        $type = 'paint';
        $stmt = $this->conn->prepare('INSERT INTO questions (test_id, name, type, text, content) VALUES(:test_id, :name, :type, :text, :content)');
        $stmt->bindParam(':test_id', $testId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':content', $content);
        $stmt->execute();
        $stmt3 = $this->conn->prepare("SELECT * FROM questions WHERE test_id=? ");
        $stmt3->bindValue(1, $testId);
        $stmt3->execute();
        return $stmt3->fetchAll(PDO::FETCH_ASSOC);
    }

    public function savePairQuestion($testId, $name, $text, $content) {
        $type = 'pair';
        $stmt = $this->conn->prepare('INSERT INTO questions (test_id, name, type, text, content) VALUES(:test_id, :name, :type, :text, :content)');
        $stmt->bindParam(':test_id', $testId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':type', $type);
        $stmt->execute();
        $stmt3 = $this->conn->prepare("SELECT * FROM questions WHERE test_id=? ");
        $stmt3->bindValue(1, $testId);
        $stmt3->execute();
        return $stmt3->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getQuestionContent($questionId) {
        $stmt3 = $this->conn->prepare("SELECT content FROM questions WHERE id=?");
        $stmt3->bindValue(1, $questionId);
        $stmt3->execute();
        return $stmt3->fetch(PDO::FETCH_ASSOC);
    }

    public function getTest($testId) {
        $stmt8 = $this->conn->prepare("SELECT * FROM tests WHERE id=?");
        $stmt8->bindValue(1, $testId);
        $stmt8->execute();
        return $stmt8->fetch(PDO::FETCH_ASSOC);
    }

    public function saveAnswer($testId, $userId, $questionId, $content) {
        $handed = 0;
        $stmt = $this->conn->prepare('INSERT INTO answers (question_id, test_id, user_id, content, handed) VALUES(:question_id, :test_id, :user_id, :content, :handed)');
        $stmt->bindParam(':test_id', $testId);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':question_id', $questionId);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':handed', $handed);
        $stmt->execute();
    }

    public function submitAnswers($userId, $testId) {
        $stmt = $this->conn->prepare('UPDATE answers SET handed=1 WHERE user_id=? and test_id=?');
        $stmt->bindValue(1, $userId);
        $stmt->bindValue(2, $testId);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function saveTest($testId, $name, $startTime, $time, $ucitelId) {
        $state = 'disabled';
        $token = "".time().uniqid(rand());
        $stmt = $this->conn->prepare('UPDATE tests SET name=?, state=?, startTime=?, time=?, token=?, ucitel_id=? WHERE id=?');
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $state);
        $stmt->bindValue(3, $startTime);
        $stmt->bindValue(4, $time);
        $stmt->bindValue(7, $testId);
        $stmt->bindValue(5, $token);
        $stmt->bindValue(6, $ucitelId);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function getTestIdFromUser($id) {
        $stmt7 = $this->conn->prepare("SELECT test_id FROM users WHERE id=?");
        $stmt7->bindValue(1, $id);
        $stmt7->execute();
        return $stmt7->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteQuestion($id) {
        $stmt7 = $this->conn->prepare("DELETE FROM questions WHERE id=?");
        $stmt7->bindValue(1, $id);
        $stmt7->execute();
    }

    public function getNewTestId() {
        $stmt = $this->conn->prepare('INSERT INTO tests () VALUES()');
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    //id otazky(chcel som do zvlast db tabulky ukladat viac odpovedi ale neslo mi to kedtak to potom nejak skusim dorobit)
    public function getNewQuestionId() {
        $stmt = $this->conn->prepare('INSERT INTO questions () VALUES()');
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function getTests() {
        $stmt7 = $this->conn->prepare("SELECT * FROM tests");
        $stmt7->execute();
        return $stmt7->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTestsByUcitelId($id) {
        $stmt7 = $this->conn->prepare("SELECT * FROM tests WHERE ucitel_id=?");
        $stmt7->bindValue(1, $id);
        $stmt7->execute();
        return $stmt7->fetchAll(PDO::FETCH_ASSOC);
    }

    public function setActive($id) {
        $stmt8 = $this->conn->prepare("SELECT * FROM tests WHERE id=?");
        $stmt8->bindValue(1, $id);
        $stmt8->execute();
        $rows = $stmt8->fetch(PDO::FETCH_ASSOC);
        if($rows['state'] == 'active') {
            $stmt7 = $this->conn->prepare("UPDATE tests SET state='disabled' WHERE id=?");
        } else {
            $stmt7 = $this->conn->prepare("UPDATE tests SET state='active' WHERE id=?");
        }
        $stmt7->bindValue(1, $id);
        $stmt7->execute();
    }

    public function deleteTest($id) {
        $stmt7 = $this->conn->prepare("DELETE FROM tests WHERE id=?");
        $stmt7->bindValue(1, $id);
        $stmt7->execute();
    }

}