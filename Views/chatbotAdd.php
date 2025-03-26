<?php
$title = "Ajout de mot clé et réponse";

require_once(__DIR__ . '/../Includes/header.php');
require_once(__DIR__ . '/../Includes/db.php');
require_once(__DIR__ . '/../Models/chatbotModel.php');

?>

<form method="POST" action="">
    <div>
      <label for="keyword">Ajouter un/des mot(s)-clé(s): </label>
      <input type="text" name="keyword" id="keyword" />
    </div>
    <div>
      <label for="response">Ajouter une réponse associée: </label>
      <input type="text" name="response" id="response" />
    </div><button type="submit">Ajouter</button>

</form>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['keyword']) && !empty($_POST['response'])) {
        try {
            $keyword = trim($_POST['keyword']);
            $response = trim($_POST['response']);

            // fonction pour ajouter un mot-clé
            $keywordSuccess = addKeyword($keyword);

            // fonction pour ajouter une réponse
            $responseSuccess = addResponse($response);

            if ($keywordSuccess && $responseSuccess) {
                $associationSuccess = associate($keyword, $response);
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
        <div role="alert">
            <?php if ($keywordSuccess && $responseSuccess && $associationSuccess): ?>
                <p>Le mot-clé et la réponse ont bien été ajoutés et associés.</p>
            <?php else: ?>
                <p>Erreur lors de l'ajout du mot-clé, de la réponse ou de l'association.</p>
            <?php endif; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php elseif (isset($errorMessage)): ?>
    <div>
        <div role="alert">
            <p>Erreur: <?= htmlspecialchars($errorMessage) ?></p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>