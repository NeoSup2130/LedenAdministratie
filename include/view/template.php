<? function toonBeginPagina($title) 
{
    ?>
    <div class="grid-container">
        <header class="grid-item">
            <h1><?echo $title;?></h1>
            <?
            global $userController;
            echo "Welkom gebruiker ".$_SESSION['GebruikerNaam']."!";
            ?>
        </header>
        <nav class="grid-item">
            <?generateNav();?>
            <ul>
                <li><?$userController->ToonLoguit();?></li>
            </ul>
        </nav>
        <div class="content grid-item">
            <!-- content tabel hier -->
    <?
}?>

<?function toonEindPagina()
{
    ?>
        </div>
    </div>
    <?
}
?>
