<?php $title = "Modifier un produit"; ?>

<h2 class="title-add">Modifier un produit</h2>
<div class="form-container">
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>" />

        <div class="form-group">
            <label for="title">Titre :</label>
            <input type="text" name="title" id="title" value="<?= htmlspecialchars($product['title']) ?>" required />
        </div>
        <div class="form-group">
            <label for="description">Description :</label>
            <input type="text" name="description" id="description" value="<?= htmlspecialchars($product['description']) ?>" required />
        </div>
        <div class="form-group">
            <label for="price">Prix :</label>
            <input type="number"
                   step="0.01"
                   inputmode="decimal"
                   name="price"
                   id="price"
                   value="<?= htmlspecialchars($product['price']) ?>"
                   required />
        </div>
        <div class="form-group">
            <label for="image">Image actuelle :</label><br>
            <?php if (!empty($product['image'])): ?>
                <img src="<?= URL . 'Public/uploads/' . htmlspecialchars($product['image']) ?>"
                     alt="Image du produit"
                     style="max-height: 150px; border: 1px solid #ccc; padding: 5px;object-fit: cover">
            <?php else: ?>
                <p class="text-muted">Aucune image enregistrée.</p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="image">Changer l'image :</label>
            <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/webp" />
        </div>

        <button type="submit" class="submit-btn">Mettre à jour</button>
    </form>
</div>

<?php if (!empty($successMessage)): ?>
    <div class="message success alert alert-success">
        <?= htmlspecialchars($successMessage) ?>
    </div>
<?php elseif (!empty($errorMessage)): ?>
    <div class="message error alert alert-danger">
        <?= htmlspecialchars($errorMessage) ?>
    </div>
<?php endif; ?>

<a class="link-button" href="<?= URL ?>product">
    <button class="backchat">
        <i class="fas fa-arrow-left"></i> Retour aux produits
    </button>
</a>
