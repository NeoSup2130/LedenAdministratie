<?
include_once 'include/view/template.php';
toonBeginPagina("Familie lid aanpassen - Sportclub de Cuijt");
$model = new ledenModel;
?>
<h2>U gaat nu deze familie lid aanpassen: </h2>
<form action='index.php?pagina=<?echo $_GET['pagina'];?>' method="post"'>
        <table>
            <tbody>
            <tr>
                    <th>Voornaam</th>
                    <th>Achternaam</th>
                    <th>Geboorte Datum</th>
                    <th>Adres</th>
                    <th>Aangemaakt op</th>
                </tr>
                <tr>
                <?
                if (isset($_GET['LidID'])
                && is_numeric(htmlspecialchars($_GET['LidID']))
                && !empty($_GET['LidID']))
                {
                    $row = $model->haalLid($_GET['LidID'])->fetch();
                    ?>
                    <td> 
                        <input type="text" name="Naam" id="Naam" value="<?echo $row['Naam']?>">
                    </td>
                    <td><?echo $row['Achternaam']?></td>
                    <td>
                        <input type="text" name="GeboorteDatum" id="GeboorteDatum" value="<?echo $row['GeboorteDatum']?>">
                    </td>
                    <td><?echo $row['Adres']?></td>
                    <td><?echo $row['Aangemaakt']?></td>
                    <input type="hidden" name="LidID" id="LidID" value="<?echo $row['LidID']?>">
                    <input type="hidden" name="FamilieID" id="FamilieID" value="<?echo $row['FamilieID']?>">
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