<body id="chatbot_body">
    <h1><i class="fas fa-robot"></i> Chatbot - Mots-clés et Réponses</h1>
    
    <a href="<?= URL ?>chatbot-add" class="add-button">
        <i class="fas fa-plus"></i> Ajouter un mot-clé et une réponse
    </a>

    <table>
        <thead>
            <tr>
                <th>Mot-clé</th>
                <th>Réponse</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($keywordsAndResponses as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars(strtolower($item['keyword_name'])); ?></td>
                    <td><?php echo htmlspecialchars(strtolower($item['response_name'])); ?></td>
                    <td>
                        <div class="action-buttons">
                            <form method="POST" action="index.php?page=deleteKeyword" style="display: inline;">
                                <input type="hidden" name="keyword_name" value="<?php echo htmlspecialchars($item['keyword_name']); ?>">
                                <button type="submit" class="action-button delete-button">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </form>
                            <form method="POST" action="<?= URL ?>chatbot-update" style="display: inline;">
                                <input type="hidden" name="keyword_id" value="<?php echo htmlspecialchars($item['keyword_id']); ?>">
                                <input type="hidden" name="response_id" value="<?php echo htmlspecialchars($item['response_id']); ?>">
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
