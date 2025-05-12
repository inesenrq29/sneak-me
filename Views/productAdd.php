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
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    </div>
<?php elseif (isset($errorMessage)): ?>
    <div class="container-md">
        <div class="message error alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($errorMessage) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    </div>
<?php endif; ?>

<a class="link-button" href="<?= URL ?>product">
    <button class="backchat">
        <i class="fas fa-arrow-left"></i> Retour aux produits
    </button>
</a>
