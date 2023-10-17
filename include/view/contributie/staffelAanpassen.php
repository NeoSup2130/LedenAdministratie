<?
include_once 'include/view/template.php';
toonBeginPagina("Staffel aanpassen - Sportclub de Cuijt");
$staffelModel = new StaffelsModel;
$soortModel = new SoortModel;
$boekjaarModel = new BoekjaarModel;
?>
<form action='index.php?pagina=<?echo $_GET['pagina'];?>' method="post"'>
        <table>
            <tbody>
                <tr>
                    <th>ID</th>
                    <th>Boekjaar</th>
                    <th>Soort</th>
                    <th>Leeftijd</th>
                    <th>Korting</th>
                    <th>Basis bedrag</th>
                    <th colspan="1"></th>
                </tr>
                <tr>
                <?
                if (isset($_GET['StaffelID']) && is_numeric(htmlspecialchars($_GET['StaffelID'])))
                {
                    $row = $staffelModel->haalStaffel($_GET['StaffelID'])->fetch();
                    if(!$row) 
                    {
                        alertError("Meegegeven ID is niet geldig!");
                        exit;
                    }
                    $boekjaren = $boekjaarModel->haalBoekjaar($row['BoekjaarID'])->fetch();
                    $soorten = $soortModel->haalSoorten()->fetchAll();

                    ?>
                    <td><?echo $row['ID']?></td>
                    <td><?echo $boekjaren['Jaar']?></td>
                    <td>
                    <select name="SoortID" id="SoortID" required>
                        <?
                        foreach($soorten as &$soort)
                        {
                        ?>
                        <option value=<?echo $soort['ID']?>><?echo $soort['Soort']?></option>
                        <?
                        }
                        ?>
                    </select>
                    </td>
                    <td>
                        <input type="number" name="Leeftijd" id="Leeftijd" min="1" max="100" step="1" value="<?echo $row['Leeftijd']?>" required>
                    </td>
                    <td>
                        <input type="number" name="Korting" id="Korting" min="0" max="100" step=".01" value="<?echo $row['Korting']?>" required>
                    </td>
                    <td>
                        <input type="number" name="Bedrag" id="Bedrag" min="0" step=".01" value="<?echo $row['Bedrag']?>" required>
                    </td>
                    <input type="hidden" name="methode" id="methode" value="aanpassen">
                    <input type="hidden" name="ID" id="ID" value="<?echo $row['ID']?>">
                    <input type="hidden" name="BoekID" id="BoekID" value="<?echo $row['BoekjaarID']?>">
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