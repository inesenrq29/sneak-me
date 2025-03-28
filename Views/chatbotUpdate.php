<?php
$title = "Ajout de mot clé et réponse";

require_once(__DIR__ . '/../Includes/header.php');
require_once(__DIR__ . '/../Includes/db.php');
require_once(__DIR__ . '/../Models/chatbotModel.php');
?>

<form method="post" action="">
    <div>
        <label for="keyword_name">Modifier un/des mot(s)-clé(s): </label>
        <input type="text" name="keyword_name" id="keyword_name" required />
    </div>
    <div>
        <label for="response_name">Modifier une réponse associée: </label>
        <input type="text" name="response_name" id="response_name" required />
    </div>
    <button type="submit">Modifier</button>
</form>

<a href="<?= URL ?>chatbot"><button>Retour au chat</button></a>
