<?php
require_once __DIR__ . '/../Includes/db.php';

class AuthModel {

    public function getUserByUsername($username){
        $pdo = getConnection();

        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

