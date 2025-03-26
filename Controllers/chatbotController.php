<?php

require_once __DIR__ . '/../Includes/db.php';
require_once __DIR__ . '/../Models/chatbotReadModel.php';

class ChatbotController {

    public function read() {
        $pdo = getConnection();  

        $chatbotModel = new ChatbotModel(); 
        $keywordsAndResponses = $chatbotModel->getAllKeywordsAndResponses();   

        // Requête pour récupérer tous les mots-clés et leurs réponses
        $stmt = $pdo->query('SELECT keyword.word, response.response 
                             FROM keyword_response
                             INNER JOIN keyword ON keyword_response.keyword_id = keyword.id
                             INNER JOIN response ON keyword_response.response_id = response.id');

        // Récupère les résultats sous forme de tableau associatif
        $keywords = $stmt->fetchAll();


        include __DIR__ . '/../Views/chatbot.php';
    }
}


?>


