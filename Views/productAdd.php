<?php
$title = "Ajout de produit";

$productModel = new ProductModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['keyword_name']) && !empty($_POST['response_name'])) {
    try {
        $keyword_name = trim($_POST['keyword_name']);
        $response_name = trim($_POST['response_name']);

        // on ajoute le mot-clé et la réponse
        $productSuccess = $productModel->addProduct($keyword_name);

        $successMessage = "Le mot-clé '$keyword_name' a été ajouté avec succès.";
        
    } catch (Exception $exception) {
        $errorMessage = $exception->getMessage();
    }
}
?>

<h2 class="title-add">Ajouter un produit</h2>
<div class="form-container">
    <form method="post" action="">
        <div class="form-group">
            <label for="keyword_name">Ajouter un/des produit(s): </label>
            <input type="text" name="keyword_name" id="keyword_name" required />
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

<a class="link-button" href="<?= URL ?>product"><button class="backchat"><i class="fas fa-arrow-left"></i> Retour au chat</button></a>
