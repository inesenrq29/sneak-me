<form action="" method="post">
<div>
    <label for="username">Entrer votre identifiant: </label>
    <input type="text" name="username" id="username" required/>
</div>
<div>
    <label for="password">Entrer votre mot de passe: </label>
    <input type="password" name="password" id="password" required />
</div>
<div>
    <input type="submit" value="Se connecter"/>
</div>
</form>

<?php
echo password_hash('admin123', PASSWORD_BCRYPT);