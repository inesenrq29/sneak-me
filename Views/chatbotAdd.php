<?php
$title = "Ajout de mot clé et réponse";

require_once(__DIR__ . '/../Includes/header.php');
require_once(__DIR__ . '/../Includes/db.php');
require_once(__DIR__ . '/../Models/chatbotModel.php');

$chatbotModel = new ChatbotModel();
?>

<form method="post" action="">
    <div>
      <label for="keyword_name">Ajouter un/des mot(s)-clé(s): </label>
      <input type="text" name="keyword_name" id="keyword_name" required/>
    </div>
    <div>
      <label for="response_name">Ajouter une réponse associée: </label>
      <input type="text" name="response_name" id="response_name" required/>
    </div><button type="submit">Ajouter</button>

</form>
<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['keyword_name']) && !empty($_POST['response_name'])) {
        try {
            $keyword_name = trim($_POST['keyword_name']);
            $response_name = trim($_POST['response_name']);

            // fonction pour ajouter un mot-clé
           $keywordSuccess = $chatbotModel->addKeyword($keyword_name);

            // fonction pour ajouter une réponse
            $responseSuccess = $chatbotModel->addResponse($response_name);

            if ($keywordSuccess && $responseSuccess) {
                $associationSuccess = $chatbotModel->associate($keyword_name, $response_name);
            } else {
                $associationSuccess = false;
            }
        }catch(Exception $exception){
            echo $exception->getMessage();
        }
    }
?>

<?php if (isset($keywordSuccess, $responseSuccess, $associationSuccess)): ?>
    <div class="container-md">
        <div class="alert" role="alert">
            <?php if ($keywordSuccess && $responseSuccess && $associationSuccess): ?>
                <p>Le mot-clé et la réponse ont bien été ajoutés et associés.</p>
            <?php else: ?>
                <p>Erreur lors de l'ajout du mot-clé, de la réponse ou de l'association.</p>
            <?php endif; ?>
            <button type="button" class="btn-close" aria-label="Fermer">Fermer</button>
        </div>
    </div>
<?php elseif (isset($errorMessage)): ?>
    <div class="container-md">
        <div class="alert" role="alert">
            <p>Erreur: <?= htmlspecialchars($errorMessage) ?></p>
            <button type="button" class="btn-close" aria-label="Fermer">Fermer</button>
        </div>
    </div>
<?php endif; ?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".btn-close").forEach(button => {
            button.addEventListener("click", function () {
                this.parentElement.style.display = "none";
            });
        });
    });
</script>

<a href="<?= URL ?>chatbot"><button>Retour au chat</button></a>




