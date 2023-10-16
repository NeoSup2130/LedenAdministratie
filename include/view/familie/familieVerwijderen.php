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
                    <th colspan="1"></th>
                </tr>
                <tr>
                <?
                if (isset($_GET['familieID']) && is_numeric(htmlspecialchars($_GET['familieID'])))
                {
                    $row = $model->haalFamilie($_GET['familieID'])->fetch();
                    ?>
                    <td><?echo $row['Naam']?></td>
                    <td><?echo $row['Adres']?></td>
                    <td><?echo $row['Aangemaakt']?></td>
                    <td><?echo $row['Aangepast']?></td>
                        <input type="hidden" name="familieID" id="familieID" value="<?echo $_GET['familieID']?>">
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
        if ($famData = $model->haalLedenFamilie($_GET['familieID'])->fetchAll())
        {
            if (!empty($famData))
            {
                ?>
                <h2>Hierbij verwijdert u ook de volgende familie leden:</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Voornaam</th>
                            <th>Achternaam</th>
                            <th>Geboorte Datum</th>
                            <th>Soort lid</th>
                            <th>Aangemaakt op</th>
                            <th>Aangepast op</th>
                        </tr>
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
                    </tr>
                    <?
                }
                ?>
                </tbody>
                </table>
                <?
            }
        }
        ?>
<?
toonEindPagina();
?>