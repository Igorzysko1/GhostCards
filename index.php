<?php include "includes/header.php"; ?>

<p class="heading-text">Zestawy fiszek:</p>
<?php
$q_selectZestawy = $conn->query("SELECT * FROM zestawy;");

echo "<div class='fiszkas-list'>";

while ($a_selectZestaw = $q_selectZestawy->fetch_assoc()) {
    echo "<div class='fiszka-set'>";
    if (isset($_SESSION['uzytkownik_id'])) {
        $uzytkownik_id = $_SESSION['uzytkownik_id'];
        if ($a_selectZestaw['uzytkownik_id'] == $uzytkownik_id) {
            echo "<p class='fiszka-set-name'>".$a_selectZestaw['nazwa']." (Twój)</p>";
        } else {
            echo "<p class='fiszka-set-name'>".$a_selectZestaw['nazwa']."</p>";
        }
    } else {
        echo "<p class='fiszka-set-name'>".$a_selectZestaw['nazwa']."</p>";
    }
    echo "<a href='zestawy.php?action=view&zestaw_id=".$a_selectZestaw['zestaw_id']."' class='view-fiszka'><i class='fa fa-eye'></i>&nbsp;&nbsp;Zobacz zestaw</a>";
    if (isset($_SESSION['uzytkownik_id'])) {
        if ($a_selectZestaw['uzytkownik_id'] == $uzytkownik_id) { ?>
            <a href="zestawy.php?action=edit&zestaw_id=<?= $a_selectZestaw['zestaw_id']; ?>" class="view-fiszka">Zmień nazwę zestawu</a>
            <a onclick="return confirm('Czy napewno chcesz usunąć ten zestaw?')" href="zestawy.php?action=delete&zestaw_id=<?= $a_selectZestaw['zestaw_id']; ?>" class="view-fiszka" style="color: red;">Usuń zestaw</a>
        <?php }
    }
    echo "</div>";
}
echo "</div>";
?>

<?php include "includes/footer.php" ?>