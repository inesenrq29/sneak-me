<?php

require_once __DIR__ . '/../Includes/db.php';
require_once __DIR__ . '/../Models/produitModel.php';

class ProduitController {

    public function read() {
        require_once __DIR__ . "/../Includes/head.php";
        require_once __DIR__ . "/../Includes/header.php";

        $produitModel = new ProduitModel();
        $produits = $produitModel->getAllProduits();

        include __DIR__ . '/../Views/produit.php';
    }

    public function deleteProduit() {
        // Vérifier qu'un ID est passé en POST
        if (isset($_POST['produit_id'])) {
            $produit_id = $_POST['produit_id'];
            $produitModel = new ProduitModel();
            
            // Récupérer l'image avant la suppression
            $produit = $produitModel->getProduitById($produit_id);
            if ($produit && !empty($produit['image'])) {
                $targetDir = "Public/uploads/";
                if (file_exists($targetDir . $produit['image'])) {
                    unlink($targetDir . $produit['image']);
                }
            }
            
            $produitModel->deleteProduit($produit_id);
            header("Location: " . URL . "produit");
            exit();
        }
    }

    public function addProduit() {
        require_once __DIR__ . "/../Includes/head.php";
        require_once(__DIR__ . '/../Includes/header.php');
        require_once(__DIR__ . '/../Includes/db.php');
        require_once(__DIR__ . '/../Models/produitModel.php');

        $message = ""; // Stockage du message

        if (!empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['price'])) {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            
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

            $produitModel = new ProduitModel();
            
            $produitAdded = $produitModel->addProduit($title, $description, $price, $image);

            if ($produitAdded) {
                $message = "<p class='success'>Le produit a bien été ajouté.</p>";
            } else {
                $message = "<p class='error'>Erreur lors de l'ajout du produit.</p>";
            }
        } else {
            $message = "<p class='error'>Tous les champs sont requis.</p>";
        }

        include __DIR__ . '/../Views/produitAdd.php';
    }

    public function updateProduit() {
        require_once __DIR__ . "/../Includes/head.php";
        require_once(__DIR__ . '/../Includes/header.php');

        if (!empty($_POST['title']) && !empty($_POST['description']) && 
            !empty($_POST['price']) && !empty($_POST['produit_id'])) {

            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $produit_id = intval($_POST['produit_id']);

            $produitModel = new ProduitModel();
            

            $produitUpdated = $produitModel->updateProduit($title, $description, $price, $image, $produit_id);
        }

        include __DIR__ . '/../Views/produitUpdate.php';
    }
}

?>
