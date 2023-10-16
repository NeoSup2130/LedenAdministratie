<?
include_once 'include/view/template.php';
toonBeginPagina("Familie aanpassen - Sportclub de Cuijt");
$model = new familieModel;
?>
<form action='index.php?pagina=<?echo $_GET['pagina'];?>' method="post"'>
        <table>
            <tbody>
                <tr>
                    <th>Familie</th>
                    <th>Adres</th>
                    <th>Aangemaakt op</th>
                    <th>Aangepast op</th>
                </tr>
                <tr>
                <?
                if (isset($_GET['familieID']) && is_numeric(htmlspecialchars($_GET['familieID'])))
                {
                    $row = $model->haalFamilie($_GET['familieID'])->fetch();
                    ?>
                    <td> 
                        <input type="text" name="Naam" id="Naam" value="<?echo $row['Naam']?>">
                    </td>
                    <td>
                        <input type="text" name="Adres" id="Adres" value="<?echo $row['Adres']?>">
                    </td>
                    <td><?echo $row['Aangemaakt']?></td>
                    <td><?echo $row['Aangepast']?></td>
                        <input type="hidden" name="Aangepast" id="Aangepast">
                        <input type="hidden" name="familieID" id="familieID" value="<?echo $_GET['familieID']?>">
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