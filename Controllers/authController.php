<?php

class AuthController {

    public function login() {
        require_once __DIR__ . "/../Includes/head.php";
        // Vérifie si l'utilisateur est déjà connecté
        if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
            header('Location: ' . URL . 'dashboard');
            exit();
        }

        // Si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // pot de miel
            if (!empty($_POST['honeypot'])){
                //si le champ est rempli, c'est probablement un bot
                header('HTTP/1.1 403 Forbidden');
                exit('Accès interdit');
               }                
            // Récupérer les données du formulaire
            $username = $_POST['username'];
            $password = $_POST['password'];

            // On vérifie le captcha
            if ($_POST['captcha'] == $_SESSION['captcha']) {
                // Récupération des données du formulaire
                $username = $_POST['username'];
                $password = $_POST['password'];


                // Vérification des informations de connexion
                if ($username === 'admin' && $password === 'admin123') {
                    $_SESSION['admin'] = true; // L'authentification est réussie
                    header('Location: ' . URL . 'dashboard');
                    exit();
                } else {
                    $_SESSION['error'] = 'Nom d\'utilisateur ou mot de passe incorrect';
                    header('Location: ' . URL . 'login');
                    exit();
                }
            } else {
                $_SESSION['error'] = 'Captcha incorrect';
                header('Location: ' . URL . 'login');
                exit();
            }
        }

        // Afficher la vue de connexion
        include __DIR__ . '/../Views/login.php';
    }

    // Méthode pour gérer la déconnexion
    public function logout() {
        // Détruire toutes les sessions
        session_unset();
        session_destroy();

        // Rediriger vers la page de connexion
        header('Location: ' . URL . 'login');
        exit();
    }

}


// admin $2y$10$UOC70iO80WD/i3J9Q2a0me51OTxcRPufkLvaOQ0YMcaOhUHmPf1WC admin123
?>

