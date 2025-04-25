<?php
// Création d'un code aléatoire pour le captcha si il n'existe pas encore dans la session
if (!isset($_SESSION['captcha'])) {
    $_SESSION['captcha'] = rand(10000, 99999);
}
$captcha = $_SESSION['captcha'];
?>

<form action="" method="post">

<div class="red">
    <label for="username">Entrer votre identifiant: </label>
    <input type="text" name="username" id="username" required/>
</div>

<div hidden>
    <label for="lastname">Entrer votre nom: </label>
    <input type="text" name="honeypot"/>
</div>
<div>
    <label for="password">Entrer votre mot de passe: </label>
    <input type="password" name="password" id="password" required />
</div>
   <div>
        <label for="captcha">Saisir le captcha: </label>
        <input type="text" name="captcha" id="captcha" required />
    </div>
<div >
    <input class="connect" type="submit" value="Se connecter"/>
</div>
    <p>Captcha: <?php echo $captcha; ?></p>
</form>

<?php
// Affichage de l'erreur si le captcha ou les identifiants sont incorrects
if (isset($_SESSION['error'])) {
    echo '<p style="color:red;">' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
}
?>

