<?php
require_once __DIR__ . '/../Includes/header.php';
 ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Chatbot - Mots-clés et Réponses</title>
</head>
<body>
    <h1>Chatbot - Mots-clés et Réponses</h1>
    <a href="<?= URL ?>chatbot-add"><button>Ajouter un mot-clé et une réponse</button></a>
    <table border="1">
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
                    <td><?php echo htmlspecialchars($item['keyword_name']); ?></td>
                    <td><?php echo htmlspecialchars($item['response_name']); ?></td>
                    <td>
                        <form method="POST" action="index.php?page=deleteKeyword">
                            <!-- Champ caché pour envoyer le mot-clé à supprimer -->
                            <input type="hidden" name="keyword_name" value="<?php echo htmlspecialchars($item['keyword_name']); ?>">
                            <button type="submit">Supprimer</button>
                        </form>
                        <form method="POST" action="<?= URL ?>chatbot-update">
                            <!-- Champ caché pour envoyer le mot-clé à modifier -->
                            <input type="hidden" name="keyword_name" value="<?php echo htmlspecialchars($item['keyword_name']); ?>">
                            <input type="hidden" name="response_name" value="<?php echo htmlspecialchars($item['response_name']); ?>">
                            <button type="submit">Modifier</button>
                        </form>
                    </td>                          
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>