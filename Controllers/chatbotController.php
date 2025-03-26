<?php

require_once __DIR__ . '/../Includes/db.php';
require_once __DIR__ . '/../Models/chatbotReadModel.php';

class ChatbotController {

    public function read() {

        $chatbotModel = new ChatbotModel(); 
        $keywordsAndResponses = $chatbotModel->getAllKeywordsAndResponses();   



        include __DIR__ . '/../Views/chatbot.php';
    }
}


?>


