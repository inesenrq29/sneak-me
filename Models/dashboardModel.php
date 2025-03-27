<?php
require_once __DIR__ . '/../Includes/db.php'; 

class DashboardModel {

  public function countNonAdminUsers() {
    $pdo = getConnection();
    
    $query = "SELECT COUNT(*) FROM users WHERE role != 'admin'";
    $stmt = $pdo->query($query);
    
    return $stmt->fetchColumn();
}

  public function countKeyword() {
    $pdo = getConnection();
    
    $query = "SELECT COUNT(*) FROM keyword";
    $stmt = $pdo->query($query);
    
    return $stmt->fetchColumn();
}

  public function countResponse() {
    $pdo = getConnection();
    
    $query = "SELECT COUNT(*) FROM response";
    $stmt = $pdo->query($query);
    
    return $stmt->fetchColumn();
}



}
