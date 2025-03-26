<?php
require_once __DIR__ . '/../Includes/db.php'; // Inclusion du fichier de connexion

class ChatbotModel {

    public function getAllKeywordsAndResponses() {
        
        $pdo = getConnection(); 

        // Requête SQL pour récupérer les mots-clés et leurs réponses
        $stmt = $pdo->query('
            SELECT keyword_name, response_name
            FROM keyword_response
            INNER JOIN keyword ON keyword_response.keyword_id = keyword.id
            INNER JOIN response ON keyword_response.response_id = response.id
        ');

        return $stmt->fetchAll(); // Retourne les résultats sous forme de tableau associatif
    }
}
?>

