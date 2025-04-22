<?php
session_start();

require_once __DIR__ . "/Controllers/authController.php";
require_once __DIR__ . "/Controllers/chatbotController.php";
require_once __DIR__ . "/Controllers/dashboardController.php";


define("URL", str_replace("index.php", "",(isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER["PHP_SELF"]
));

$authController = new AuthController();
$chatbotController = new ChatbotController();
$dashboardController = new DashboardController();
$produitController = new ProduitController();


try {
  if(empty($_GET['page'])){
    $page = "login";
  }else {
    $url = explode("/", filter_var($_GET['page'], FILTER_SANITIZE_URL));
    $page = $url[0];
  }

  switch($page){
    case "login" : 
      $authController->login();
      break;

    case "logout":
      session_destroy();
      header('Location: ' . URL . 'login');
      exit;
      break;

      case "produit":
        if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
            $produitController->produit();
        } else {
            header("Location: " . URL . "login");
            exit();
        }
        break;

    case "dashboard":
      if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
        $dashboardController->dashboard();
      } else {
          header("Location: " . URL . "login");
          exit();
      }
      break;

      case "chatbot":
        if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
            $chatbotController->read();
        } else {
            header("Location: " . URL . "login");
            exit();
        }
        break;

        case "chatbot-add":
                if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
                    $chatbotController->addChatKeyword();
                } else {
                    header("Location: " . URL . "login");
                    exit();
                }
                break;

                case "chatbot-update":
                    if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
                        $chatbotController->updateKeyword();
                    } else {
                        header("Location: " . URL . "login");
                        exit();
                    }
                    break;

                case "deleteKeyword":
                  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['keyword_name'])) {
                      $chatbotController->deleteKeyword();
                  }
                  break;
                    default:
      echo "404 Page non trouvée";
      break;
  }

} catch (Exception $e) { 
  echo "500 : Erreur interne du serveur.";
}

?>

