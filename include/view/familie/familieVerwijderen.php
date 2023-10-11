<?
include_once 'include/view/template.php';
toonBeginPagina("Familie verwijderen - Sportclub de Cuijt");
$model = new familieModel;
?>
<form action='index.php?pagina=<?echo $_GET['pagina'];?>' method="post"'>
<h2>U gaat nu deze familie verwijderen: </h2>
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
                if (isset($_POST['familieID']) && is_numeric(htmlspecialchars($_POST['familieID'])))
                {
                    $row = $model->haalFamilie($_POST['familieID'])->fetch();
                    ?>
                    <td><?echo $row['Naam']?></td>
                    <td><?echo $row['Adres']?></td>
                    <td><?echo $row['Aangemaakt']?></td>
                    <td><?echo $row['Aangepast']?></td>
                        <input type="hidden" name="familieID" id="familieID" value="<?echo $_POST['familieID']?>">
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