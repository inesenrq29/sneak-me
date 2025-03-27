<?php
require_once __DIR__ . '/../Includes/header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Statistiques</title>
    <link rel="stylesheet" href="styles.css"> <!-- Si vous avez un fichier CSS -->
</head>
<body>
    <h1>Dashboard</h1>
        
    <h2>Statistiques du Chatbot</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Valeur</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Utilisateurs non admin</td>
                <td><?= htmlspecialchars($nonAdminCount); ?></td>
            </tr>
            <tr>
                <td>Nombre de mots-clés</td>
                <td><?= htmlspecialchars($keywordsCount); ?></td>
            </tr>
            <tr>
                <td>Nombre de réponses</td>
                <td><?= htmlspecialchars($responsesCount); ?></td>
            </tr>
        </tbody>
    </table>

    <br>
    <a href="<?= URL ?>chatbot">Retour à la gestion des mots-clés</a> 
</body>
</html>












?>