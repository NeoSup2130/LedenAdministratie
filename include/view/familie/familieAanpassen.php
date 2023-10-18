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
                    <th>Postcode</th>
                    <th>Straat</th>
                    <th>Huisnummer</th>
                    <th>Aangemaakt op</th>
                    <th>Aangepast op</th>
                </tr>
                <tr>
                <?
                if (isset($_GET['FamilieID']) && is_numeric(htmlspecialchars($_GET['FamilieID'])))
                {
                    $row = $model->haalFamilie($_GET['FamilieID'])->fetch();
                    if(!$row) 
                    {
                        alertError("Meegegeven ID is niet geldig!");
                        exit;
                    }
                    // $row['Adres'] komt binnen als "1234AB, ErgensStraat 10b"
                    $adres = explode(', ', $row['Adres']);
                    // adres = ["1234AB", "ErgensStraat 10b"]
                    $postcode = $adres[0];
                    // Vind de dichtsbijzijnde nummer in adres[1] ("ErgensStraat 10b")
                    $nrPos = strcspn($adres[1], "123456789");
                    // nrPos is * in dit voorbeeld -> "ErgensStraat*10b"
                    $huisnr = substr($adres[1], $nrPos);
                    $straat = substr($adres[1], 0, $nrPos-1);
                    ?>
                    <td> 
                        <input type="text" name="Naam" id="Naam" value="<?echo $row['Naam']?>" pattern="^(?!^\s+$)[A-Za-zÀ-ÖØ-öø-ÿ\s'-]+$" required>
                    </td>
                    <td><input type="text" name="Postcode" id="Postcode" value="<?echo $postcode?>" pattern="^[1-9]\d{3}[A-Z]{2}$" required></td>
                    <td><input type="text" name="Straat" id="Straat" value="<?echo $straat?>" pattern="^[A-Za-z\s-]+$" required></td>
                    <td><input type="text" name="Huisnummer" id="Huisnummer" value="<?echo $huisnr?>" pattern="^([1-9]\d*|[1-9])?\w?$" required></td>
            
                    <td><?echo $row['Aangemaakt']?></td>
                    <td><?echo $row['Aangepast']?></td>
                        <input type="hidden" name="Aangepast" id="Aangepast">
                        <input type="hidden" name="FamilieID" id="FamilieID" value="<?echo $_GET['FamilieID']?>">
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