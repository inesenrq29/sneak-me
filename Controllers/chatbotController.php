<?php

require_once __DIR__ . '/../Includes/db.php';
require_once __DIR__ . '/../Models/chatbotModel.php';

class ChatbotController {

    public function read() {
        require_once __DIR__ . "/../Includes/head.php";
        require_once __DIR__ . "/../Includes/header.php";

        $chatbotModel = new ChatbotModel(); 
        $keywordsAndResponses = $chatbotModel->getAllKeywordsAndResponses();


        include __DIR__ . '/../Views/chatbot.php';
    }

    public function deleteKeyword() {
        // Vérifier qu'un mot-clé est passé en POST
        if (isset($_POST['keyword_name'])) {
            $keyword_name = $_POST['keyword_name'];    
            $chatbotModel = new ChatbotModel();    
            $chatbotModel->deleteKeyword($keyword_name);    
            header("Location: " . URL . "chatbot");
            exit();
        }
    }
    
    public function addChatKeyword() {

        require_once(__DIR__ . '/../Includes/header.php');
        require_once(__DIR__ . '/../Includes/db.php');
        require_once(__DIR__ . '/../Models/chatbotModel.php');
        
        $message = ""; // Stockage du message*

        if (!empty($_POST['keyword_name']) && !empty($_POST['response_name'])) {
            $keyword_name = $_POST['keyword_name'];
            $response_name = $_POST['response_name'];

            $chatbotModel = new ChatbotModel();

            $keywordAdded = $chatbotModel->addKeyword($keyword_name);
            $responseAdded = $chatbotModel->addResponse($response_name);

            if ($keywordAdded && $responseAdded) {
                $associationResult = $chatbotModel->associate($keyword_name, $response_name);

                if ($associationResult === "mot-clé déjà associé") {
                    $message = "<p class='error'>Le mot-clé est déjà associé à cette réponse.</p>";
                } elseif ($associationResult) {
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

    public function updateKeyword() {
        if (!empty($_POST['keyword_name']) && !empty($_POST['response_name']) &&
            !empty($_POST['keyword_id']) && !empty($_POST['response_id'])) {

            $keyword_name = $_POST['keyword_name'];
            $response_name = $_POST['response_name'];
            $keyword_id = intval($_POST['keyword_id']); // S'assurer que c'est bien un entier
            $response_id = intval($_POST['response_id']); // S'assurer que c'est bien un entier

            $chatbotModel = new ChatbotModel();

            $keywordUpdated = $chatbotModel->updateKeyword($keyword_name, $keyword_id);
            $responseUpdated = $chatbotModel->updateResponse($response_name, $response_id);
        }

        include __DIR__ . '/../Views/chatbotUpdate.php';
    }



}


?>


