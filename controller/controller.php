<?php

require_once "helpers/database.php";


class Controller {

    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function formatDate($value) {
        if (substr($value,0,1)=="0")
            return substr($value,1);
        else
            return $value;
    }

    public function getStudents() {
        $students = [];
        $stmt = $this->conn->prepare("SELECT DISTINCT name FROM user_actions;");
        $stmt->execute();
        $lectures = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $lectures;
    }

    public function getTimeLeft($name, $lecture_id) {
        $stmt3 = $this->conn->prepare("SELECT timestamp FROM user_actions WHERE action='left' && lecture_id=? && name=?");
        $stmt3->bindValue(1, $lecture_id);
        $stmt3->bindValue(2, $name);
        $stmt3->execute();
        $left = $stmt3->fetchAll(PDO::FETCH_ASSOC);
        $values = [];
        if(count($left) == 0) {
            return null;
        }
        foreach($left as $le) {
            $values[] = strtotime($le['timestamp']);
        }
        return max($values);
    }

    public function getInfo($id, $name) {
        $stmt3 = $this->conn->prepare("SELECT * FROM user_actions WHERE lecture_id=? && name=?");
        $stmt3->bindValue(1, $id);
        $stmt3->bindValue(2, $name);
        $stmt3->execute();
        return $stmt3->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTimeJoined($name, $lecture_id) {
        $stmt3 = $this->conn->prepare("SELECT timestamp FROM user_actions WHERE action='joined' && lecture_id=? && name=?");
        $stmt3->bindValue(1, $lecture_id);
        $stmt3->bindValue(2, $name);
        $stmt3->execute();
        return $stmt3->fetch(PDO::FETCH_ASSOC);
    }

    public function getMaxTime($lecture_id) {
        $stmt3 = $this->conn->prepare("SELECT MAX(timestamp) as max FROM user_actions WHERE lecture_id=?");
        $stmt3->bindValue(1, $lecture_id);
        $stmt3->execute();
        return $stmt3->fetch(PDO::FETCH_ASSOC);
    }

    public function getTestQuestions($testId) {
        $stmt3 = $this->conn->prepare("SELECT * FROM questions WHERE test_id=? ");
        $stmt3->bindValue(1, $testId);
        $stmt3->execute();
        return $stmt3->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGraphInfo() {
        $stmt3 = $this->conn->prepare("SELECT count(DISTINCT name) as total, lecture_id FROM user_actions WHERE action='joined' GROUP by lecture_id");
        $stmt3->execute();
        $rows = $stmt3->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function setUser($country, $city, $lat, $lon, $ip) {
        $confirm = 0;
        $stmt = $this->conn->prepare('INSERT INTO user (lat, lon, country_id, city, ip, confirm) VALUES(:lat, :lon, :country_id, :city, :ip, :confirm)');
        $stmt->bindParam(':lat', $lat);
        $stmt->bindParam(':lon', $lon);
        $stmt->bindParam(':country_id', $country);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':ip', $ip);
        $stmt->bindParam(':confirm', $confirm);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function getUser($ip) {
        $stmt3 = $this->conn->prepare("SELECT * FROM user WHERE ip=? ");
        $stmt3->bindValue(1, $ip);
        $stmt3->execute();
        return $stmt3->fetch(PDO::FETCH_ASSOC);

    }

    public function setCountry($country, $flag) {
        $stmt = $this->conn->prepare('INSERT INTO country (name, flag) VALUES(:name, :flag)');
        $stmt->bindParam(':name', $country);
        $stmt->bindParam(':flag', $flag);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function setAccess($timestamp, $userId, $page, $city) {
        $stmt = $this->conn->prepare('INSERT INTO access (timestamp, user_id, page, city) VALUES(:time, :user_id, :page, :city)');
        $stmt->bindParam(':time', $timestamp);
        $stmt->bindParam(':user_id', $userId['id']);
        $stmt->bindParam(':page', $page);
        $stmt->bindParam(':city', $city);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function getTimesAccess() {
        $dtt1 = date_create("24:00");
        $dtt2 = date_create("6:00");
        $dtt3 = date_create("15:00");
        $dtt4 = date_create("21:00");
        $dt1 = $dtt1->format("H:i");
        $dt2 = $dtt2->format("H:i");
        $dt3 = $dtt3->format("H:i");
        $dt4 = $dtt4->format("H:i");
        $c1 = 0;
        $c2 = 0;
        $c3 = 0;
        $c4 = 0;

        $times = [4];
        $stmt7 = $this->conn->prepare("SELECT * FROM access");
        $stmt7->execute();
        $rows = $stmt7->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row) {
            $dt = date_create($row['timestamp']);
            $date = $dt->format("H:i");
            echo $date;
            if($date < $dt2) {
                $c1 += 1;
            } else if($date > $dt2 && $date < $dt3) {
                $c2 += 1;
            } else if($date > $dt3 && $date < $dt4) {
                $c3 += 1;
            } else if($date > $dt4 && $date < $dt1) {
                $c4 += 1;
            }
            $times[0] = $c2;
            $times[1] = $c3;
            $times[2] = $c4;
            $times[3] = $c1;
            return $times;
        }
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
        $max_id = $invNum['max_id'];
        return $max_id;
    }

    public function getBestSite() {
        $stmt7 = $this->conn->prepare("SELECT * FROM access");
        $stmt7->execute();
        $rows = $stmt7->fetchAll(PDO::FETCH_ASSOC);
        $a = 0;
        $b = 0;
        $c = 0;
        $max = [3];
        foreach($rows as $row) {
            if($row['page'] == 'b') {
                $b += 1;
            } else if($row['page'] == 'c') {
                $c += 1;
            } else if($row['page'] == 'a') {
                $a += 1;
            }
        }
        $max[0] = $a;
        $max[1] = $b;
        $max[2] = $c;
        $vm = max($max);
        if($vm == $a) {
            return 'a';
        } else if($vm == $b) {
            return 'b';
        } else {
            return 'c';
        }
    }

    public function getAccess($userId, $page) {
        $dateTest = date_create();
        $dt = $dateTest->format("Y/m/d");
        $stmt7 = $this->conn->prepare("SELECT * FROM access WHERE user_id=? and page=? and timestamp LIKE '".$dt."%'");
        $stmt7->bindValue(1, $userId);
        $stmt7->bindValue(2, $page);
        $stmt7->execute();
        $rows = $stmt7->fetch(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function getAllAccess() {
        $stmt7 = $this->conn->prepare("SELECT * FROM country");
        $stmt7->execute();
        $rows = $stmt7->fetchAll(PDO::FETCH_ASSOC);
        $countries = [];
        foreach($rows as $row) {
            $country = [];
            $stmt8 = $this->conn->prepare("SELECT * FROM access INNER JOIN user ON user.id = access.user_id WHERE user.country_id=?");
            $stmt8->bindValue(1, $row['id']);
            $stmt8->execute();
            $rows2 = $stmt8->fetchAll(PDO::FETCH_ASSOC);
            $count = 0;
            foreach($rows2 as $r) {
                $count += 1;
            }
            array_push($country, $row);
            array_push($country, $count);
            array_push($country, $row['id']);
            array_push($countries, $country);
        }
        return $countries;
    }

    public function getCitiesCount($id, $name) {
        $stmt8 = $this->conn->prepare("SELECT user.city, user.id FROM user WHERE country_id=?");
        //$stmt8 = $this->conn->prepare("SELECT user.city, COUNT(access.user_id) AS Citycount FROM user INNER JOIN access ON access.user_id = user.id WHERE user.country_id = ?");
        $stmt8->bindValue(1, $id);
        $stmt8->execute();
        $rows2 = $stmt8->fetchAll(PDO::FETCH_ASSOC);
        $cities = [];
        foreach($rows2 as $row) {
            $city = [];
            array_push($city, $row['city']);
            $stmt9 = $this->conn->prepare("SELECT * FROM access WHERE user_id=? and city=?");
            $stmt9->bindValue(1, $row['id']);
            $stmt9->bindValue(2, $row['city']);
            $stmt9->execute();
            $rows3 = $stmt9->fetchAll(PDO::FETCH_ASSOC);
            $count = 0;
            foreach($rows3 as $r) {
                $count += 1;
            }
            array_push($city, $count);
            array_push($cities, $city);
        }
        return $cities;
    }

    public function ignoreCountries($code, $title) {
        $stmt = $this->conn->prepare('INSERT IGNORE INTO countries (code, title) VALUES(:code, :title)');
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':title', $title);
        $stmt->execute();
    }

    public function ignoreDays($day, $month) {
        $stmt = $this->conn->prepare('INSERT IGNORE INTO days (day, month) VALUES(:day, :month)');
        $stmt->bindParam(':day', $day);
        $stmt->bindParam(':month', $month);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function getFirst() {
        $stmt = $this->conn->prepare("SELECT osoby.id, osoby.name, COUNT(umiestnenia.placing) AS Orderscount FROM osoby INNER JOIN umiestnenia ON umiestnenia.person_id = osoby.id GROUP BY osoby.id, osoby.name ORDER BY Orderscount DESC LIMIT 10 ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateRecord($id, $fname, $lname, $bday, $bplace, $bcountry, $dday, $dplace, $dcountry) {
        $stmt = $this->conn->prepare("UPDATE osoby SET name=?, surname=?, birth_day=?, birth_place=?, birth_country=?, death_day=?, death_place=?, death_country=? WHERE id=?");
        $stmt->bindValue(1, $fname);
        $stmt->bindValue(2, $lname);
        $stmt->bindValue(3, $bday);
        $stmt->bindValue(4, $bplace);
        $stmt->bindValue(5, $bcountry);
        $stmt->bindValue(6, $dday);
        $stmt->bindValue(7, $dplace);
        $stmt->bindValue(8, $dcountry);
        $stmt->bindValue(9, $id);
        $stmt->execute();
        //return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getView($id) {
        $stmt = $this->conn->prepare("SELECT * FROM osoby WHERE id=?");
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPlacings($id) {
        $stmt = $this->conn->prepare($sql = "SELECT * FROM umiestnenia, oh WHERE oh.id = umiestnenia.oh_id and person_id=?");
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}