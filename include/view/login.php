<?php
$loginFout = false;
    if(isset($_POST['gebruiker']) && isset($_POST['wachtwoord']))
    {
        include_once('include/basis.php');
        $user = new AdminUserContr($_POST['gebruiker'], $_POST['wachtwoord']);
        if ($user->LoginIn())
        {
            header("Refresh:0");
        }
        else 
        {
            $loginFout = true;
        }
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
    <form action="index.php" method="post">
        <div class="form-group">
            <label for="gebruiker">Gebruikersnaam:</label>
            <input type="text" id="gebruiker" name="gebruiker" <?if(isset($_POST['gebruiker'])) echo "value=".$_POST['gebruiker'];?>  pattern="[a-zA-Z0-9!@#$%^&*_]+" required>
        </div>
        <div class="form-group">
            <label for="wachtwoord">Wachtwoord:</label>
            <input type="password" id="wachtwoord" name="wachtwoord" <?if(isset($_POST['wachtwoord'])) echo "value=".$_POST['wachtwoord'];?>  pattern="[a-zA-Z0-9!@#$%^&*_]+" required>
        </div>
        <div class="form-group">
            <input type="submit" value="Login" class="btn">
        </div>
    </form>
</div>
<? if ($loginFout){ ?>
    <script>
        let formObject = document.forms[0];
        let foutMelding = document.createElement("p");
        foutMelding.classList.add("form-group");
        foutMelding.classList.add("fout");
        foutMelding.innerText = "Verkeerde gebruikersnaam of wachtwoord!";
        formObject.insertBefore(foutMelding, formObject.firstChild);

        let inputWachtwoord = document.getElementById("wachtwoord");
        inputWachtwoord.classList.add('fout');
        let inputGebruiker = document.getElementById("gebruiker");
        inputGebruiker.classList.add('fout');
    </script>
<? } ?>
