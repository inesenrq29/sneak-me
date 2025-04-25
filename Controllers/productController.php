<?php

require_once __DIR__ . '/../Includes/db.php';
require_once __DIR__ . '/../Models/productModel.php';

class ProductController {

    public function ajoutImage($file, $dir, $nom): string
    {
        if (!isset($file['name']) || empty($file['name'])) {
            throw new RuntimeException("Vous devez indiquer une image");
        }

        if (!file_exists($dir)) {
            if (!mkdir($dir, 0775, true) && !is_dir($dir)) {
                throw new RuntimeException("Le répertoire '$dir' n'a pas pu être créé");
            }
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $target_file = $dir . $nom . "_" . basename($file['name']);

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!$mime) {
            throw new RuntimeException("Impossible de détecter le type MIME du fichier.");
        }

        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($mime, $allowedMimeTypes)) {
            throw new RuntimeException("Le fichier n'est pas une image valide. Type MIME détecté : $mime");
        }

        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
            throw new RuntimeException("Extension non autorisée ($extension)");
        }

        if (file_exists($target_file)) {
            throw new RuntimeException("Le fichier existe déjà");
        }

        if ($file['size'] > 500000) {
            throw new RuntimeException("Le fichier est trop lourd (> 500 Ko)");
        }

        if (!move_uploaded_file($file['tmp_name'], $target_file)) {
            throw new RuntimeException("L'ajout de l'image a échoué");
        }

        return $nom . "_" . basename($file['name']);
    }


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
                $targetDir = "Public/images/";
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

        $successMessage = null;
        $errorMessage = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = trim($_POST['price'] ?? '');

            if ($title && $description && $price) {
                try {
                    $image = '';
                    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                        $dir = "Public/uploads/";
                        $image = $this->ajoutImage($_FILES['image'], $dir, $title);
                    }

                    $productModel = new ProductModel();
                    $added = $productModel->addProduct($title, $description, $price, $image);

                    if ($added) {
                        $successMessage = "Le produit '$title' a été ajouté avec succès.";
                    } else {
                        $errorMessage = "Erreur lors de l'ajout du produit.";
                    }

                } catch (RuntimeException $e) {
                    $errorMessage = $e->getMessage();
                }
            } else {
                $errorMessage = "Tous les champs sont requis.";
            }
        }

        include __DIR__ . '/../Views/productAdd.php';
    }

    public function updateProduct() {
        require_once __DIR__ . "/../Includes/head.php";
        require_once __DIR__ . "/../Includes/header.php";

        $productModel = new ProductModel();
        $successMessage = null;
        $errorMessage = null;
        $product = null;

        // Accepte l'ID en GET (pour l'affichage initial) ou POST (après soumission)
        $product_id = $_GET['id'] ?? $_POST['product_id'] ?? null;
        var_dump($_GET);
        var_dump($_POST);
        var_dump($product_id);
        if ($product_id) {
            $product = $productModel->getProductById($product_id);
        }

        // Soumission du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $product) {
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = str_replace(',', '.', trim($_POST['price'] ?? ''));

            if ($title && $description && $price) {
                try {
                    $image = $product['image'];

                    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                        $dir = "Public/uploads/";
                        if (!empty($image) && file_exists($dir . $image)) {
                            unlink($dir . $image);
                        }
                        $image = $this->ajoutImage($_FILES['image'], $dir, $title);
                    }

                    $updated = $productModel->updateProduct($title, $description, $price, $image, $product_id);
                    if ($updated) {
                        $successMessage = "Le produit a été mis à jour avec succès.";
                        $product = $productModel->getProductById($product_id); // Recharger
                    } else {
                        $errorMessage = "Erreur lors de la mise à jour.";
                    }
                } catch (RuntimeException $e) {
                    $errorMessage = $e->getMessage();
                }
            } else {
                $errorMessage = "Tous les champs sont requis.";
            }

            //redirection vers la page product
            header("Location: " . URL . "product");
            exit();

        }

        include __DIR__ . '/../Views/productUpdate.php';
    }
}

?> 