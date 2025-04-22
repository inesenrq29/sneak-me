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
        $image = trim($_POST['image']);

        // Mise à jour du mot-clé et de la réponse
        $productUpdated = $productModel->updateProduct($title, $description, $price, $image, $product_id);

        if ($productUpdated) {
            $updateSuccess = true;
        } else {
            $updateSuccess = false;
        }
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
<form method="post" action="">
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
        <label for="image">Modifier l'image :</label>
        <input type="text" name="image" id="image" value="<?= $image ?>" required />
    </div>
    <button type="submit" class="submit-btn">Modifier</button>
</form>
</div>

<?php if (isset($updateSuccess) && $updateSuccess): ?>
    <div class="container-md">
        <div class="message success alert alert-success alert-dismissible fade show" role="alert">
            <p>Le produit a bien été modifié.</p>
            <button type="button" class="close-btn btn-close" data-bs-dismiss="alert" aria-label="Fermer">Fermer</button>
        </div>
    </div>
<?php elseif (isset($errorMessage)): ?>
    <div class="container-md">
        <div class="message error alert alert-danger alert-dismissible fade show" role="alert">
            <p>Erreur: <?= htmlspecialchars($errorMessage) ?></p>
            <button type="button" class="close-btn btn-close" data-bs-dismiss="alert" aria-label="Fermer">Fermer</button>
        </div>
    </div>
<?php endif; ?>

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
