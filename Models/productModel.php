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

    public function ajoutImage($file, $dir, $nom): string
    {
        //on teste que l'on récupère bine un fichier
        if(!isset($file['name']) || empty($file['name'])){
            throw new RuntimeException("Vous devez indiquer une image");
        }

        // on teste que l'on ait bien un répertoire vers lequel enregistrer le fichier
        if(!file_exists($dir)) if (!mkdir($dir, ) && !is_dir($dir)){
            throw new RuntimeException(sprintf('Le répertoir "%s" n\a pas été créé !', $dir));
        }

        // on récupère l'extension du fichier, son type MIME
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        // on enregistre le nom de notre fichier
        $target_file = $dir. $nom . "_". $file['name'];
        // On teste le type MIME que ce soit bien un type image
        if(!getimagesize($file["tmp_name"])) {
            throw new RuntimeException("Le fichier n'est pas une image");
        }
        // On teste que le type MIME corresponde à ce que l'on autorise
        if($extension !== "jpg" && $extension !== "jpeg" && $extension !== "png" && $extension !== "webp") {
            throw new RuntimeException("L' extension du fichier n'est pas reconnue");
        }
        // On teste que l'on a pas déjà un fichier avec ce nom
        if(file_exists($target_file)) {
            throw new RuntimeException("Le fichier existe déjà");
        }
        // On teste que le fichier ne dépasse pas un certain poids
        if($file['size'] > 500000) {
            throw new RuntimeException("Le fichier est trop gros");
        }
        // On teste que l'enregistrement du fichier dans le répertoire souhaité a bien été effectué
        if (!move_uploaded_file($file['tmp_name'], $target_file)) {
            throw new RuntimeException("L'ajout de l'image n'a pas fonctionné");
        } else {
            return $nom . "_" . $file['name'];
        }
    }

    public function addProduct($title, $description, $price, $image) {
        $dbh = getConnection();

        // Vérifier si le produit existe déjà
        $checkQuery = "SELECT id FROM product WHERE title = :title";
        $checkStmt = $dbh->prepare($checkQuery);
        $checkStmt->bindValue(":title", $title, PDO::PARAM_STR);
        $checkStmt->execute();

        if ($checkStmt->fetchColumn()) {
            return false;
        }

        // Insérer le produit s'il n'existe pas
        $req = "INSERT INTO product (title, description, price, image) 
                VALUES (:title, :description, :price, :image)";
        $stmt = $dbh->prepare($req);
        
        $stmt->bindValue(":title", $title, PDO::PARAM_STR);
        $stmt->bindValue(":description", $description, PDO::PARAM_STR);
        $stmt->bindValue(":price", $price, PDO::PARAM_STR);
        $stmt->bindValue(":image", $image, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function deleteProduct($product_id) {
        $pdo = getConnection();
        $query = "DELETE FROM product WHERE id = :product_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateProduct($title, $description, $price, $image, $product_id) {
        $dbh = getConnection();

        $checkQuery = "UPDATE product SET 
            title = :title,
            description = :description,
            price = :price,
            image = :image
            WHERE id = :product_id";

        $checkStmt = $dbh->prepare($checkQuery);
        $checkStmt->bindValue(":title", $title, PDO::PARAM_STR);
        $checkStmt->bindValue(":description", $description, PDO::PARAM_STR);
        $checkStmt->bindValue(":price", $price, PDO::PARAM_STR);
        $checkStmt->bindValue(":image", $image, PDO::PARAM_STR);
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