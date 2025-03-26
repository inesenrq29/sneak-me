<?php
class ChatbotModel {

    public function getAllKeywordsAndResponses() {
        // Connexion à la base de données
        $pdo = getConnection(); // Appelle la fonction getConnection() du fichier db.php

        // Effectue la requête pour récupérer les mots-clés et leurs réponses
        $stmt = $pdo->query("SELECT keyword, response FROM keyword_response");
        return $stmt->fetchAll(); // Retourne les résultats sous forme de tableau associatif
    }
}
?>
