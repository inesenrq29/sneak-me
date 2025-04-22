<?php
require_once __DIR__ . '/../Includes/db.php';

class ProductModel {

    public function getAllProduct() {
        $pdo = getConnection();

        $stmt = $pdo->query('
            SELECT 
                id,
                title,
                description,
                price,
                image
            FROM product
        ');

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteProduct($product_id) {
        $pdo = getConnection();
        $query = "DELETE FROM product WHERE id = :product_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function addProduct($title, $description, $price, $image, $category_id) {
        $dbh = getConnection();

        // Vérifier si le produit existe déjà
        $checkQuery = "SELECT id FROM product WHERE title = :title";
        $checkStmt = $dbh->prepare($checkQuery);
        $checkStmt->bindValue(":title", $title, PDO::PARAM_STR);
        $checkStmt->execute();

        if ($checkStmt->fetchColumn()) {
            return false; // Si le produit existe déjà, on retourne false
        }

        // Insérer le produit s'il n'existe pas
        $req = "INSERT INTO product (title, description, price, image, category_id) 
                VALUES(:title, :description, :price, :image, :category_id)";
        $stmt = $dbh->prepare($req);
        $stmt->bindValue(":title", $title, PDO::PARAM_STR);
        $stmt->bindValue(":description", $description, PDO::PARAM_STR);
        $stmt->bindValue(":price", $price, PDO::PARAM_STR);
        $stmt->bindValue(":image", $image, PDO::PARAM_STR);
        $stmt->bindValue(":category_id", $category_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateProduct($title, $description, $price, $image, $category_id, $product_id) {
        $dbh = getConnection();

        $checkQuery = "UPDATE product SET 
            title = :title,
            description = :description,
            price = :price,
            image = :image,
            category_id = :category_id
            WHERE id = :product_id";

        $checkStmt = $dbh->prepare($checkQuery);
        $checkStmt->bindValue(":title", $title, PDO::PARAM_STR);
        $checkStmt->bindValue(":description", $description, PDO::PARAM_STR);
        $checkStmt->bindValue(":price", $price, PDO::PARAM_STR);
        $checkStmt->bindValue(":image", $image, PDO::PARAM_STR);
        $checkStmt->bindValue(":category_id", $category_id, PDO::PARAM_INT);
        $checkStmt->bindValue(":product_id", $product_id, PDO::PARAM_INT);
        return $checkStmt->execute();
    }

    public function getProductById($product_id) {
        $dbh = getConnection();

        $query = "SELECT * FROM product WHERE id = :product_id";
        $stmt = $dbh->prepare($query);
        $stmt->bindValue(":product_id", $product_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?> 