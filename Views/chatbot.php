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
    <table border="1">
        <thead>
            <tr>
                <th>Mot-clé</th>
                <th>Réponse</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($keywordsAndResponses as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['keyword_name']); ?></td>
                    <td><?php echo htmlspecialchars($item['response_name']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>








?>