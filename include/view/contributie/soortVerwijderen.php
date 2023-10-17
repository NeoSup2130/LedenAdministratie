<?
include_once 'include/view/template.php';
toonBeginPagina("Soort verwijderen - Sportclub de Cuijt");
$model = new SoortModel;
?>
<form action='index.php?pagina=<?echo $_GET['pagina'];?>' method="post"'>
<h2>U gaat nu deze soort verwijderen: </h2>
        <table>
            <tbody>
                <tr>
                    <th>ID</th>
                    <th>Soort</th>
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
                    <td><?echo $row['ID']?></td>
                    <td><?echo $row['Soort']?></td>
                    <input type="hidden" name="SoortID" id="SoortID" value="<?echo $row['ID']?>">
                    <input type="hidden" name="methode" value="<?echo $_GET['methode']?>">
                    <?
                }
                ?>
                <td>
                    <input type="submit" value="verwijderen" class="btn">
                </td>
                </tr>
            </tbody>
        </table>
</form>
<?
toonEindPagina();
?>