<?php
require_once __DIR__ . '/../Includes/header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Statistiques</title>
    <link rel="stylesheet" type="text/css" href="Public/dashboard.css">
</head>
<body>
   
    <div class="main-content">     

        <div class="header">
            <h1 class="title">Dashboard</h1>
        </div>
      
        <div class="dashboard-cards">
            <div class="card">
                <h3>Utilisateurs non admin</h3>
                <p><?= htmlspecialchars($nonAdminCount); ?></p>
            </div>
            <div class="card">
                <h3>Mots-Clés</h3>
                <p><?= htmlspecialchars($keywordsCount); ?></p>
            </div>
            <div class="card">
                <h3>Réponses</h3>
                <p><?= htmlspecialchars($responsesCount); ?></p>
            </div>
        </div>
        
        <div class="link-container">
            <a class="btn" href="<?= URL ?>chatbot">Retour à la gestion des mots-clés</a> 
        </div>

    </div> 

</body>
</html>
