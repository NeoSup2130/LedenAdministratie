<?
include_once 'include/view/template.php';
toonBeginPagina("Familieleden overzicht - Sportclub de Cuijt");
$model = new ledenModel;
$famData;
if (isset($_GET['FamilieID']) && is_numeric(htmlspecialchars($_GET['FamilieID'])))
{
    $famID = $_GET['FamilieID'];
    if (!$famData = $model->haalLedenFamilie($famID))
    {
        alertQueryError();
    }
    $famData = $famData->fetchAll();

    if (empty($famData)) 
    {
        ?><h2>Familie bevat geen familie leden!</h2> <?
        exit;
    }
} else header("index.php"); 
?>
<h2>Overzicht van familie "<?echo $famData[0]['Achternaam']?>"</h2>
<table>
    <thead>
        <tr>
            <th>Voornaam</th>
            <th>Achternaam</th>
            <th>Geboorte Datum</th>
            <th>Soort lid</th>
            <th>Aangemaakt op</th>
            <th>Aangepast op</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        <?
        foreach($famData as &$row)
        {
            ?>
            <tr>
            <td><?echo $row['Naam']?></td>
            <td><?echo $row['Achternaam']?></td>
            <td><?echo $row['GeboorteDatum']?></td>
            <td><?echo $row['Soort']?></td>
            <td><?echo $row['Aangemaakt']?></td>
            <td><?echo $row['Aangepast']?></td>
            <?
            $ids = ["FamilieID", $row["FamilieID"], "LidID", $row["LidID"]];
            $model->toonKnopCRUD("aanpassen", $ids, "get");
            $model->toonKnopCRUD("verwijderen", $ids, "get");
            ?>
            </tr>
            <?
        }
        ?>
    </tbody>
</table>
<?
toonEindPagina();
?>