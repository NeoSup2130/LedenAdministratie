<?
include_once 'include/view/template.php';
toonBeginPagina("Staffel verwijderen - Sportclub de Cuijt");
$staffelModel = new StaffelsModel;
$soortModel = new SoortModel;
$boekjaarModel = new BoekjaarModel;
?>
<form action='index.php?pagina=<?echo $_GET['pagina'];?>' method="post"'>
<h2>U gaat nu deze soort verwijderen: </h2>
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
                    $soorten = $soortModel->haalSoort($row['SoortID'])->fetch();
                    ?>
                    <td><?echo $row['ID']?></td>
                    <td><?echo $boekjaren['Jaar']?></td>
                    <td><?echo $soorten['Soort']?></td>
                    <td><?echo $row['Leeftijd']?></td>
                    <td><?echo $row['Korting']?></td>
                    <td><?echo $row['Bedrag']?></td>
                    <input type="hidden" name="StaffelID" id="StaffelID" value="<?echo $row['ID']?>">
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