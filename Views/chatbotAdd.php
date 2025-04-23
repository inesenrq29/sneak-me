<h2 class="title-add">Ajouter un mot-clé et sa réponse</h2>
<div class="form-container">
    <form method="post" action="">
        <div class="form-group">
            <label for="keyword_name">Mot-clé :</label>
            <input type="text" name="keyword_name" id="keyword_name" required>
        </div>
        <div class="form-group">
            <label for="response_name">Réponse :</label>
            <input type="text" name="response_name" id="response_name" required>
        </div>
        <button type="submit" class="submit-btn">Ajouter</button>
    </form>
</div>

<?php if (!empty($message)): ?>
    <div class="container-md">
        <div class="message alert alert-<?= htmlspecialchars($type) ?> alert-dismissible fade show" role="alert">
            <p><?= htmlspecialchars($message) ?></p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    </div>
<?php endif; ?>


<a class="link-button" href="<?= URL ?>chatbot">
    <button class="backchat"><i class="fas fa-arrow-left"></i> Retour au chat</button>
</a>
