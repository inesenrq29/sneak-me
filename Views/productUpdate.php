<?php
$title = "Modification du produit";

$productModel = new ProductModel();
$products = $productModel->getAllProduct();

// Récupérer les IDs envoyés via POST
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

$title = "";
$description = "";
$price = "";
$image = "";

// Si le formulaire a été soumis, mettre à jour la base de données
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['price']) && !empty($_POST['image'])) {
    try {
        $title = trim($_POST['title']);
        var_dump($_POST);
        exit;
        $description = trim($_POST['description']);
        $price = trim($_POST['price']);
        $image = '';
        if (isset($_FILES['image'])) {
            $dir = "Public/images/";
            $image = $productController->ajoutImage($_FILES['image'], $dir, $title);
        }

        // Mise à jour du mot-clé et de la réponse
        $productUpdated = $productModel->updateProduct($title, $description, $price, $image, $product_id);
        var_dump($productUpdated);
        exit;

        if (!$productUpdated) {
            throw new Exception("Erreur lors de la modification du produit.");
        }

        $successMessage = "Le produit '$title' a été modifié avec succès.";

    } catch (Exception $exception) {
        $errorMessage = "Une erreur est survenue : " . $exception->getMessage();
    }
}

// Récupérer les valeurs actuelles
foreach ($products as $row) {
    if ($row['id'] == $product_id) {
        $title = htmlspecialchars($row['title']);
        $description = htmlspecialchars($row['description']);
        $price = htmlspecialchars($row['price']);
        $image = htmlspecialchars($row['image']);
        break;
    }
}
?>


<h2 class="title-add">Modifier un produit</h2>

<div class="form-container">
<form method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="product_id" value="<?= $product_id ?>" />

    <div class="form-group">
        <label for="title">Modifier le titre :</label>
        <input type="text" name="title" id="title" value="<?= $title ?>" required />
    </div>
    <div class="form-group">
        <label for="description">Modifier la description :</label>
        <input type="text" name="description" id="description" value="<?= $description ?>" required />
    </div>
    <div class="form-group">
        <label for="price">Modifier le prix :</label>
        <input type="text" name="price" id="price" value="<?= $price ?>" required />
    </div>
    <div class="form-group">
            <label for="image">Image : </label>
            <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/webp" />
    </div>
    <button type="submit" class="submit-btn">Modifier</button>
</form>
</div>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.btn-close').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.alert').remove();
            });
        });
    });
</script>

<a class="link-button" href="<?= URL ?>product"><button class="backchat"><i class="fas fa-arrow-left"></i> Retour au chat</button></a>
