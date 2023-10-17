<?
include_once 'include/view/template.php';
include_once 'include/model/familieModel.php';
toonBeginPagina("Familie lid toevoegen - Sportclub de Cuijt");
$lidModel = new ledenModel;
$famModel = new familieModel;
$famID; $famData;
if (isset($_GET['familieID'])
    && is_numeric(htmlspecialchars($_GET['familieID']))
    && !empty($_GET['familieID']))
{
    $famID = $_GET['familieID'];
    if (!$famData = $famModel->haalFamilie($famID))
        alertQueryError();
}
?>
<h2>U gaat nu een familie lid toevoegen: </h2>
<form action='index.php?pagina=<?echo $_GET['pagina'];?>' method="post"'>
        <table>
            <tbody>
            <tr>
                    <th>Voornaam</th>
                    <th>Achternaam</th>
                    <th>Geboorte Datum</th>
                    <th>Adres</th>
                </tr>
                <tr>
                <?
                if (!empty($famData))
                {
                    $row = $famData->fetch();
                    ?>
                    <td>
                        <input type="text" name="Naam" id="Naam" pattern="^(?!^\s+$)[A-Za-zÀ-ÖØ-öø-ÿ\s'-]+$" required>
                    </td>
                    <td><?echo $row['Naam']?></td>
                    <td>
                        <input type="text" name="GeboorteDatum" id="GeboorteDatum" pattern="^(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[0-2])/\d{4}$" required>
                    </td>
                    <td><?echo $row['Adres']?></td>
                    <input type="hidden" name="FamilieID" id="FamilieID" value="<?echo $row['ID']?>">
                    <input type="hidden" name="methode" value="<?echo $_GET['methode']?>">
                    <?
                }
                ?>
                </tr>
            </tbody>
        </table>
        <input type="submit" value="toevoegen" class="btn">
</form>
<?
toonEindPagina();
?>