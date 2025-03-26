<?php
session_start();

require_once __DIR__ . "/Controllers/authController.php";

define("URL", str_replace("index.php", "",(isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER["PHP_SELF"]
));

$authController = new AuthController();

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

    case "dashboard":
      if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
          $authController->dashboard();
      } else {
          header("Location: " . URL . "login");
          exit();
      }
      break;

      case "chatbot":
            if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
                $chatbotController->chatbot();
            } else {
                header("Location: " . URL . "login");
                exit();
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

