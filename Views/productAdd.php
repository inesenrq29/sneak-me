<?php
$title = "Ajout de produit";

$productController = new ProductController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['price'])) {
    try {
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $price = trim($_POST['price']);

        // Gestion de l'image
        $image = '';
        if (isset($_FILES['image'])) {
            $dir = "Public/uploads/";
            $image = $productController->ajoutImage($_FILES['image'], $dir, $title);
        }

        // On ajoute le produit
        $productSuccess = $productController->addProduct($title, $description, $price, $image);

        if (!$productSuccess) {
            throw new Exception("Erreur lors de l'ajout du produit.");
        }

        $successMessage = "Le produit '$title' a été ajouté avec succès.";
        
    } catch (Exception $exception) {
        $errorMessage = $exception->getMessage();
    }
}
?>

<h2 class="title-add">Ajouter un produit</h2>
<div class="form-container">
    <form method="post" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Titre du produit : </label>
            <input type="text" name="title" id="title" required />
        </div>
        <div class="form-group">
            <label for="description">Description : </label>
            <textarea name="description" id="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="price">Prix : </label>
            <input type="number" step="0.01" name="price" id="price" required />
        </div>
        <div class="form-group">
            <label for="image">Image : </label>
            <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/webp" />
        </div>
        <button type="submit" class="submit-btn">Ajouter</button>
    </form>
</div>

<?php if (isset($successMessage)): ?>
    <div class="container-md">
        <div class="message success alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($successMessage) ?>
            <button type="button" class="close-btn btn-close" data-bs-dismiss="alert" aria-label="Fermer">Fermer</button>
        </div>
    </div>
<?php elseif (isset($errorMessage)): ?>
    <div class="container-md">
        <div class="message error alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($errorMessage) ?>
            <button type="button" class="close-btn btn-close" data-bs-dismiss="alert" aria-label="Fermer">Fermer</button>
        </div>
    </div>
<?php endif; ?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".btn-close").forEach(button => {
            button.addEventListener("click", function () {
                this.parentElement.style.display = "none";
            });
        });
    });
</script>

<a class="link-button" href="<?= URL ?>product">
    <button class="backproduct">
        <i class="fas fa-arrow-left"></i> Retour aux produits
    </button>
</a>
