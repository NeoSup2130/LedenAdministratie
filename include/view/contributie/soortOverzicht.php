<?
include_once 'include/view/template.php';
toonBeginPagina("Soort leden overzicht - Sportclub de Cuijt");
$model = new SoortModel;
?><h2>Soort lid toevoegen</h2>
<table>
    <thead>
        <tr>
            <th>Naam</th>
            <th colspan="1"></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <form action="index.php?pagina=<?echo $_GET['pagina']?>" method="post">
            <td><input type="text" name="SoortNaam" id="SoortNaam" placeholder="Naam" required></td>
            <input type="hidden" name="methode" value="toevoegen">
            <td><input type="submit" value="toevoegen" class="btn"></td>
            </form>
        </tr>
    </tbody>
</table>
<hr>
<h2>Soort leden overzicht</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Soort naam</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        <?
        $model->toon();
        ?>
    </tbody>
</table>
<?
toonEindPagina();
?>