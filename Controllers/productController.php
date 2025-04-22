<?php

require_once __DIR__ . '/../Includes/db.php';
require_once __DIR__ . '/../Models/productModel.php';

class ProductController {

    private function ajoutImage($file, $dir, $nom): string
    {
        //on teste que l'on récupère bine un fichier
        if(!isset($file['name']) || empty($file['name'])){
            throw new RuntimeException("Vous devez indiquer une image");
        }

        // on teste que l'on ait bien un répertoire vers lequel enregistrer le fichier
        if(!file_exists($dir)) if (!mkdir($dir, 0777, true ) && !is_dir($dir)){
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
            return $file['name'];
        }
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
        require_once(__DIR__ . '/../Includes/db.php');
        require_once(__DIR__ . '/../Models/productModel.php');

        $message = ""; // Stockage du message

        if (!empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['price'])) {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            
            try {
                // Gestion de l'image avec la nouvelle fonction
                $image = '';
                if (isset($_FILES['image'])) {
                    $dir = "Public/images/";
                    $image = $this->ajoutImage($_FILES['image'], $dir, $title);
                }

                $productModel = new ProductModel();
                $productAdded = $productModel->addProduct($title, $description, $price, $image);

                if ($productAdded) {
                    $message = "<p class='success'>Le produit a bien été ajouté.</p>";
                } else {
                    $message = "<p class='error'>Erreur lors de l'ajout du produit.</p>";
                }
            } catch (RuntimeException $e) {
                $message = "<p class='error'>" . $e->getMessage() . "</p>";
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

            $productModel = new ProductModel();
            $oldProduct = $productModel->getProductById($product_id);
            $image = $oldProduct['image']; // Garder l'ancienne image par défaut

            try {
                // Gestion de la nouvelle image si fournie
                if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
                    $dir = "Public/images/";
                    // Supprimer l'ancienne image
                    if (!empty($oldProduct['image'])) {
                        $old_file = $dir . $oldProduct['image'];
                        if (file_exists($old_file)) {
                            unlink($old_file);
                        }
                    }
                    $image = $this->ajoutImage($_FILES['image'], $dir, $title);
                }

                $productUpdated = $productModel->updateProduct($title, $description, $price, $image, $product_id);
                if ($productUpdated) {
                    $_SESSION['success'] = "Produit modifié avec succès";
                } else {
                    $_SESSION['error'] = "Erreur lors de la modification du produit";
                }
            } catch (RuntimeException $e) {
                $_SESSION['error'] = $e->getMessage();
            }
            
            header("Location: " . URL . "product");
            exit();
        }

        include __DIR__ . '/../Views/productUpdate.php';
    }
}

?> 