<?
include_once 'include/view/template.php';
toonBeginPagina("Soort aanpassen - Sportclub de Cuijt");
$model = new SoortModel;
?>
<form action='index.php?pagina=<?echo $_GET['pagina'];?>' method="post"'>
        <table>
            <tbody>
                <tr>
                    <th>Soort ID</th>
                    <th>Naam</th>
                    <th colspan="1"></th>
                </tr>
                <tr>
                <?
                if (isset($_GET['SoortID']) && is_numeric(htmlspecialchars($_GET['SoortID'])))
                {
                    $row = $model->haalSoort($_GET['SoortID'])->fetch();
                    if(!$row) 
                    {
                        alertError("Meegegeven ID is niet geldig!");
                        exit;
                    }
                    ?>
                    <td> 
                        <?echo $row['ID']?>
                    </td>
                    <td>
                        <input type="text" name="SoortNaam" id="SoortNaam" value="<?echo $row['Soort']?>" required>
                    </td>
                        <input type="hidden" name="SoortID" id="SoortID" value="<?echo $row['ID']?>">
                        <input type="hidden" name="methode" value="<?echo $_GET['methode']?>">
                    <?
                }
                ?>
                <td>
                    <input type="submit" value="aanpassen" class="btn">
                </td>
                </tr>
            </tbody>
        </table>
</form>
<?
toonEindPagina();
?>