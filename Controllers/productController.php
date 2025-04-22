<?php

require_once __DIR__ . '/../Includes/db.php';
require_once __DIR__ . '/../Models/productModel.php';

class ProductController {

    public function read() {
        require_once __DIR__ . "/../Includes/head.php";
        require_once __DIR__ . "/../Includes/header.php";

        $productModel = new ProductModel();
        $products = $productModel->getAllProduct();

        include __DIR__ . '/../Views/product.php';
    }

    public function deleteProduct() {
        // Vérifier qu'un ID est passé en POST
        if (isset($_POST['product_id'])) {
            $product_id = $_POST['product_id'];
            $productModel = new ProductModel();
            
            // Récupérer l'image avant la suppression
            $product = $productModel->getProductById($product_id);
            if ($product && !empty($product['image'])) {
                $targetDir = "Public/uploads/";
                if (file_exists($targetDir . $product['image'])) {
                    unlink($targetDir . $product['image']);
                }
            }
            
            $productModel->deleteProduct($product_id);
            header("Location: " . URL . "product");
            exit();
        }
    }

    public function addProduct() {
        require_once __DIR__ . "/../Includes/head.php";
        require_once(__DIR__ . '/../Includes/header.php');
        require_once(__DIR__ . '/../Includes/db.php');
        require_once(__DIR__ . '/../Models/productModel.php');

        $message = ""; // Stockage du message

        if (!empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['price'])) {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            
            // Gestion de l'image
            $image = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $targetDir = "Public/uploads/";
                $fileName = basename($_FILES["image"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                $allowTypes = array('jpg', 'jpeg', 'png', 'gif');
                if (in_array(strtolower($fileType), $allowTypes)) {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                        $image = $fileName;
                    } else {
                        $message = "<p class='error'>Erreur lors de l'upload de l'image.</p>";
                    }
                } else {
                    $message = "<p class='error'>Seuls les fichiers JPG, JPEG, PNG & GIF sont autorisés.</p>";
                }
            }

            $productModel = new ProductModel();
            
            $productAdded = $productModel->addProduct($title, $description, $price, $image, $category_id);

            if ($productAdded) {
                $message = "<p class='success'>Le produit a bien été ajouté.</p>";
            } else {
                $message = "<p class='error'>Erreur lors de l'ajout du produit.</p>";
            }
        } else {
            $message = "<p class='error'>Tous les champs sont requis.</p>";
        }

        include __DIR__ . '/../Views/productAdd.php';
    }

    public function updateProduct() {
        require_once __DIR__ . "/../Includes/head.php";
        require_once(__DIR__ . '/../Includes/header.php');

        if (!empty($_POST['title']) && !empty($_POST['description']) && 
            !empty($_POST['price']) && !empty($_POST['product_id'])) {

            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $product_id = intval($_POST['product_id']);
            $category_id = $_POST['category_id'];

            $productModel = new ProductModel();
            
            // Récupérer l'ancien produit pour l'image
            $oldProduct = $productModel->getProductById($product_id);
            $image = $oldProduct['image']; // Garder l'ancienne image par défaut

            // Gestion de la nouvelle image si fournie
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $targetDir = "Public/uploads/";
                $fileName = basename($_FILES["image"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                $allowTypes = array('jpg', 'jpeg', 'png', 'gif');
                if (in_array(strtolower($fileType), $allowTypes)) {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                        // Supprimer l'ancienne image
                        if (!empty($oldProduct['image']) && file_exists($targetDir . $oldProduct['image'])) {
                            unlink($targetDir . $oldProduct['image']);
                        }
                        $image = $fileName;
                    }
                }
            }

            $productUpdated = $productModel->updateProduct($title, $description, $price, $image, $category_id, $product_id);
        }

        include __DIR__ . '/../Views/productUpdate.php';
    }
}

?> 