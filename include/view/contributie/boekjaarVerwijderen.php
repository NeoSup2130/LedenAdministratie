<?
include_once 'include/view/template.php';
toonBeginPagina("Boekjaar verwijderen - Sportclub de Cuijt");
$model = new BoekjaarModel;
?>
<form action='index.php?pagina=<?echo $_GET['pagina'];?>' method="post"'>
<h2>U gaat nu dit boekjaar verwijderen: </h2>
        <table>
            <tbody>
                <tr>
                    <th>ID</th>
                    <th>Boekjaar</th>
                    <th colspan="1"></th>
                </tr>
                <tr>
                <?
                if (isset($_GET['BoekjaarID']) && is_numeric(htmlspecialchars($_GET['BoekjaarID'])))
                {
                    $row = $model->haalBoekjaar($_GET['BoekjaarID'])->fetch();
                    ?>
                    <td><?echo $row['ID']?></td>
                    <td><?echo $row['Jaar']?></td>
                    <input type="hidden" name="BoekjaarID" id="BoekjaarID" value="<?echo $row['ID']?>">
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
<h2>Hierbij verwijdert u ook de volgende contributies:</h2>
    <table>
        <thead>
            <tr>
                <th>Soort ID</th>
                <th>Leeftijd</th>
                <th>Korting</th>
                <th>Bedrag</th>
            </tr>
        <tbody>
            <?
                Model::toonSimpelQuery($model->haalContributieJaar($_GET['BoekjaarID']));
            ?>
        </tbody>
    </table>

<?
toonEindPagina();
?>