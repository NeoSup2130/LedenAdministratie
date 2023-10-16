<?
include_once 'include/view/template.php';
toonBeginPagina("Boekjaar aanpassen - Sportclub de Cuijt");
$model = new BoekjaarModel;
?>
<form action='index.php?pagina=<?echo $_GET['pagina'];?>' method="post"'>
        <table>
            <tbody>
                <tr>
                    <th>BoekjaarID</th>
                    <th>Jaar</th>
                </tr>
                <tr>
                <?
                if (isset($_GET['BoekjaarID']) && is_numeric(htmlspecialchars($_GET['BoekjaarID'])))
                {
                    $row = $model->haalBoekjaar($_GET['BoekjaarID'])->fetch();
                    ?>
                    <td> 
                        <?echo $row['ID']?>
                    </td>
                    <td>
                        <input type="number" name="Jaar" id="Jaar" step=1 min=1900 max=2100 value="<?echo $row['Jaar']?>">
                    </td>
                        <input type="hidden" name="BoekjaarID" id="BoekjaarID" value="<?echo $row['ID']?>">
                        <input type="hidden" name="methode" value="<?echo $_GET['methode']?>">
                    <?
                }
                ?>
                </tr>
            </tbody>
        </table>
        <input type="submit" value="aanpassen" class="btn">
</form>
<?
toonEindPagina();
?>