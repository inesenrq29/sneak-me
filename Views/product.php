<body id="chatbot_body">
    <h1><i class="fas fa-robot"></i> Chatbot - Produit</h1>
    
    <a href="<?= URL ?>product-add" class="add-button">
        <i class="fas fa-plus"></i> Ajouter un produit
    </a>

    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Description</th>
                <th>Prix</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars(strtolower($item['title'])); ?></td>
                    <td><?php echo htmlspecialchars(strtolower($item['description'])); ?></td>
                    <td><?php echo htmlspecialchars(strtolower($item['price'])); ?></td>
                    <td>
                        <?php if (!empty($item['image'])): ?>
                            <img src="<?= URL ?>Public/uploads/<?= htmlspecialchars($item['image']) ?>"
                                 alt="Image de <?= htmlspecialchars($item['title']) ?>"
                                 style="max-width: 100px; height: auto;">
                        <?php else: ?>
                            Pas d'image
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <form method="POST" action="index.php?page=deleteProduct" style="display: inline;">
                                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                                <button type="submit" class="action-button delete-button">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </form>
                            <form method="GET" action="index.php">
                                <input type="hidden" name="page" value="product-update">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($item['id']) ?>">
                                <button type="submit" class="action-button edit-button">
                                    <i class="fas fa-edit"></i> Modifier
                                </button>
                            </form>

                        </div>
                    </td>                          
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
