<?php

require_once __DIR__ . '/../Includes/db.php';
require_once __DIR__ . '/../Models/chatbotModel.php';

class ChatbotController {

    public function read() {

        $chatbotModel = new ChatbotModel(); 
        $keywordsAndResponses = $chatbotModel->getAllKeywordsAndResponses();


        include __DIR__ . '/../Views/chatbot.php';
    }

    public function addChatKeyword() {
        $message = ""; // Stockage du message

        if (!empty($_POST['keyword_name']) && !empty($_POST['response_name'])) {
            $keyword_name = $_POST['keyword_name'];
            $response_name = $_POST['response_name'];

            $chatbotModel = new ChatbotModel();

            $keywordAdded = $chatbotModel->addKeyword($keyword_name);
            $responseAdded = $chatbotModel->addResponse($response_name);

            if ($keywordAdded && $responseAdded) {
                $associationResult = $chatbotModel->associate($keyword_name, $response_name);

                if ($associationResult) {
                    $message = "<p class='success'>Le mot-clé et la réponse ont bien été ajoutés et associés.</p>";
                } else {
                    $message = "<p class='error'>Erreur lors de l'association du mot-clé et de la réponse.</p>";
                }
            } else {
                $message = "<p class='error'>Erreur lors de l'ajout du mot-clé ou de la réponse.</p>";
            }
        } else {
            $message = "<p class='error'>Le nom du mot-clé et la réponse sont requis.</p>";
        }

        include __DIR__ . '/../Views/chatbotAdd.php';
    }


}


?>


