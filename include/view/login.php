<?php
    if(isset($_POST['gebruiker']) && isset($_POST['wachtwoord']))
    {
        $gebruiker = htmlspecialchars($_POST['gebruiker'], ENT_QUOTES);
        $wachtwoord = htmlspecialchars($_POST['wachtwoord'], ENT_QUOTES);

        // $stmt = $pdo->prepare("SELECT id, gebruiker, wachtwoord FROM gebruikers WHERE gebruiker = ?");
        // $stmt->execute([$username]);
        // $user = $stmt->fetch();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Ledenadministratie de Cuijt</title>
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <form action="login.php" method="post">
        <div class="form-group">
            <label for="gebruiker">Gebruikersnaam:</label>
            <input type="text" id="gebruiker" name="gebruiker" pattern="[a-zA-Z0-9!@#$%^&*_]+" required>
        </div>
        <div class="form-group">
            <label for="wachtwoord">Wachtwoord:</label>
            <input type="password" id="wachtwoord" name="wachtwoord" pattern="[a-zA-Z0-9!@#$%^&*_]+" required>
        </div>
        <div class="form-group">
            <input type="submit" value="Login" class="btn">
        </div>
    </form>
</div>