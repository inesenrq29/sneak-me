<?php
require_once __DIR__ . '/../Includes/db.php'; 

class DashboardModel {

  public function countProduct() {
    $pdo = getConnection();
    
    $query = "SELECT COUNT(*) FROM product";
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
