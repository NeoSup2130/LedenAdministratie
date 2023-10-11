<?
include_once 'include/view/template.php';
toonBeginPagina("Lid verwijderen - Sportclub de Cuijt");
$model = new ledenModel;
?>
<h2>U gaat nu deze familie lid verwijderen: </h2>
<form action='index.php?pagina=<?echo $_GET['pagina'];?>' method="post"'>
        <table>
            <tbody>
                <tr>
                    <th>Voornaam</th>
                    <th>Achternaam</th>
                    <th>Geboorte Datum</th>
                    <th>Adres</th>
                    <th>Aangemaakt op</th>
                    <th>Aangepast op</th>
                </tr>
                <tr>
                <?
                if (isset($_POST['LidID'])
                    && is_numeric(htmlspecialchars($_POST['LidID']))
                    && !empty($_POST['LidID']))
                {
                    $row = $model->haalLid($_POST['LidID'])->fetch();
                    ?>
                    <td><?echo $row['Naam']?></td>
                    <td><?echo $row['Achternaam']?></td>
                    <td><?echo $row['GeboorteDatum']?></td>
                    <td><?echo $row['Adres']?></td>
                    <td><?echo $row['Aangemaakt']?></td>
                    <td><?echo $row['Aangepast']?></td>
                    <input type="hidden" name="LidID" id="LidID" value="<?echo $_POST['LidID']?>">
                    <input type="hidden" name="FamilieID" id="FamilieID" value="<?echo $_POST['FamilieID']?>">
                    <input type="hidden" name="methode" value="<?echo $_GET['methode']?>">
                    <?
                }
                ?>
                </tr>
            </tbody>
        </table>
        <input type="submit" value="verwijderen" class="btn">
</form>
<?
toonEindPagina();
?>